<?php
if (! class_exists('Youtube_Recommendation_json')) {
	class youtube_recommendation_json {
		private $channel_id;

     public function __construct($channel_id, $expiration = 1, $dirname, $filename){
        $this->channel_id = $channel_id;
		$this->expiration = $expiration;
		$this->filename   = $filename;
		$this->dirname    = $dirname;
		$this->path       = $this->create_folder_path();

		$ajax_action      = 'youtube_recommendation_videos';
		add_action("wp_ajax_$ajax_action", array($this, 'write_content'));
	    add_action("wp_ajax_nopriv_$ajax_action", array($this, 'write_content'));

     }

	 public function write_content(){
		 echo $this->get_content();
		 wp_die();
	 }

     private function get_content(){

		 if($this->is_expired()){
			 echo 'Youtube';
		  $json_content = $this->from_yt_feed();
	      $this->save_file($json_content);
		 }else{
			 echo 'Cache';
		  $json_content = $this->from_file();
		 }

	   return $json_content;
     }

	 private function is_expired(){
		 $file_expiration_in_hours = $this->expiration;

		 $json_file = $this->get_filename_full_path();
		 $json_file_expired = (time()-filemtime($json_file)>($file_expiration_in_hours * 3600));

		 return ($json_file_expired);
	 }

	 private function save_file(){
		 $json_path = $this->get_filename_full_path();
		 $fp        = fopen($json_path,'w');
		 fwrite($fp,$json_path);
		 fclose($fp);
	 }

	 private function from_file(){
		 $json_path = $this->get_filename_full_path();
		 $json      = file_get_contents($json_path);
		 return $json;
	 }

	 private function get_filename_full_path(){
      return $this->path . '/' . $this->filename;
	 }



	 private function create_folder_path(){
		 $upload_dir = wp_upload_dir();
		 if (! empty($upload_dir['basedir'] ) ) {
			 $dirname = $upload_dir['basedir'] .'/'.$this->dirname;
			 if(! file_exists($dirname ) ){
				 wp_mkdir_p($dirname);

				 return $dirname;
			 }
		 }
	 }



     //private
     public function from_yt_feed(){
		  $channel_id = $this->channel_id;
		  //UC9_-53kycytS_3Jmcwj052A id do canal do p4ulo para teste
 		  $feed_url = "https://www.youtube.com/feeds/videos.xml?channel_id={$channel_id}";
		  $response = wp_remote_get($feed_url);
		  $content = wp_remote_retrieve_body($response);

		  $content = preg_replace('/<(\/)?(yt|media)\:/i', '<$1$2_', $content);
          $xml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);

		  $json = json_encode($xml);
		  $content = json_decode($json, true);

		  $videos = array();
		  $count = 0;

		  foreach ($content['entry'] as $index => $item){
		  if ($count == 0) {
			  $videos['channel']                  = $item['author'];
			  $videos['channel']['avatar']        = $this->get_channel_avatar();
		   }
		  $yt_video_id = $item['yt_videoId'];
		  $videos['videos'][$count]['id']            = $yt_video_id;
		  $videos['videos'][$count]['link']          = "https://youtu.be/{$yt_video_id}";
		  $videos['videos'][$count]['thumbnail']     = "https;//img.youtube.com/vi/{$yt_video_id}/mqdefault.jpg";
		  $videos['videos'][$count]['title']         = $item['title'];
		  $videos['videos'][$count]['published']     = $item['published'];
		  $videos['videos'][$count]['rating']        = $item['media_group']['media_community']['media_starRating']['@attributes']['avarege'];
		  $videos['videos'][$count]['likes']         = $item['media_group']['media_community']['media_starRating']['@attributes']['count'];
		  $videos['videos'][$count]['views']         = $item['media_group']['media_community']['media_statistics']['@attributes']['views'];

          $count ++;
		  }
		  return json_encode($videos);
     }
	 //private
     public function get_channel_avatar(){
		 $channel_id                      = $this->channel_id;
		 $channel_url                     ="https://m.youtube.com/channel/{$channel_id}";
		 $response                        =wp_remote_get($channel_url);
		 $content                         =wp_remote_retrieve_body($response);
		 $http_code                       =wp_remote_retrieve_response_code($response);
		 if ($http_code != 200){
			 return;
	     }
         $pattern = '/class="appbar-nav-avatar" src"([ˆ"])"/i';
		 preg_match($pattern, $content, $matches);

		 if($matches['1']){
			 $avatar = $matches['1'];
		 }
	     return $avatar;


     }


	}
}
// TODO - uploads Not working
$my = new Youtube_Recommendation_json(
'UCFuIUoyHB12qpYa8Jpxoxow',
1,
RECOMMEND_PLUGIN_SLUG,
RECOMMEND_JSON_FILENAME
);



// TODO json - Working for now
$my = new Youtube_Recommendation_json('UCFuIUoyHB12qpYa8Jpxoxow');
$json = $my->from_yt_feed();
var_dump($json);

//TODO avatar -Not working, returning NULL value!
//$my = new Youtube_Recommendation_json('UCFuIUoyHB12qpYa8Jpxoxow');
//$avatar = $my->get_channel_avatar();
//var_dump($avatar);