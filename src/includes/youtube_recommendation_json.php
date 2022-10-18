<?php
if (! class_exists('Youtube_Recommendation_json')) {
	class youtube_recommendation_json {
		private $channel_id;

     public function __construct($channel_id){
        $this->$channel_id = $channel_id;
     }

     public function from_yt_feed(){
		  $channel_id = $this->channel_id;
		  //UC9_-53kycytS_3Jmcwj052A id do canal do p4ulo para teste
 		  $feed_url = "https://www.youtube.com/feeds/videos.xml?channel_id={$channel_id}";
		  $response = wp_remote_get($feed_url);
		  $content = wp_remote_retrieve_body($response);

		  $content = preg_replace('/<(\/)?(yt|media)\:/i', '<$1$2_', $content);

     }
	}
}