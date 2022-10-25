<?php
if(! class_exists('youtube_recommendatio')){
   class youtube_recommendation {
	   public $options;

	   public function __construct(){
		   $this->options = get_option('yt_rec');

		   if($this->options['channel_id']!= ""){
			   add_filter('the_content', array($this, 'add_videos_list_in_single_content') );
			   add_action('wp_enqueue_scripts', array($this,'enqueue_assets') );
		   }
	   }
	   public function enqueue_assets(){
		   wp_enqueue_style('recommend-style', plugin_dir_url(__DIR__) . 'public/css/styles.css');
		   wp_enqueue_script('recommend-script', plugin_dir_url(__DIR__) . 'public/js/scripts.js', array('jquery'), false, false);
		   wp_enqueue_script('recommend-loader', plugin_dir_url(__DIR__) . 'public/js/loader.js', array('jquery'), false, true);
		   wp_localize_script('recommend-script', 'yt_rec_ajax', array('url'=> network_admin_url('admin-ajax.php') ) );
	   }

 }
}