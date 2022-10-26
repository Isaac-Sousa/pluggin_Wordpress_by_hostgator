<?php
if(! class_exists('youtube_recommendatio')){
   class youtube_recommendation {
	   public $options;

	   public function __construct(){
		   $this->options = get_option('yt_rec');

		   if($this->options['channel_id'] != ""){
			   add_filter('the_content', array($this, 'add_videos_list_in_single_content') );
			   add_action('wp_enqueue_scripts', array($this,'enqueue_assets') );
		   }
	   }
	   public function add_videos_list_in_single_content($content){
		   if(is_single()){
			   $position = $this->options['show_position'];
			   if($position == 'before'){
				   $content = $this->build_html_videos_list() . $content;
			   }elseif($position == 'after'){
				   $content .= $this->build_html_videos_list() . $content;
			   }
			   return $content;
		   }

	   }

	   private function build_html_videos_list() {
		   $limit                = $this->options['limit'];
		   $layout               = $this->options['layout'];
		   $custom_css           = $this->options['custom_ css'];


		   $custom_css = strip_tags($custom_css);
		   $custom_css = htmlspecialchars($custom_css, ENT_HTML5 | ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');

		   $language = get_locale();

		   $container_id = 'yt-rec-container';
		   if($custom_css != ""){
			   $content .= "<style>$custom_css</style>";
			   $content .= "<div id='$container_id'> ._('Loading...', 'recommend') . ";
			   $script = "<script>
    YoutubeRecommendation.listCallbacks.push({
        containerId: '$container_id',
        layout: '$layout' ,
        limit: $limit,
        lang: '$language',
        callback:YoutubeRecommendation.buildList,
    });
</script>";
		   }
		   return $content . $script;
	   }






	   public function enqueue_assets(){
		   wp_enqueue_style('recommend-style', plugin_dir_url(__DIR__) . 'public/css/style.css');
		   wp_enqueue_script('recommend-scripts', plugin_dir_url(__DIR__) . 'public/js/scripts.js', array('jquery'), false, false);
		   wp_enqueue_script('recommend-loader', plugin_dir_url(__DIR__) . 'public/js/loader.js', array('jquery'), false, true);
		   wp_localize_script('recommend-scripts', 'yt_rec_ajax', array('url' => network_admin_url('admin-ajax.php') ) );
	   }
 }
}