<?php
if (! class_exists('youtube_recommendation_admin')){

	class youtube_recommendation_admin {
		private $options;
		private $plugin_basename;
		private $plugin_slug;
		private $json_filename;
		private $plugin_version;

    public function __construct($basename,$slug,$json_filename,$version){

	   $this->options             =get_option('yt_rec');
       $this->plugin_basename     =$basename;
	   $this->plugin_slug         =$slug;
	   $this->json_filename       =$json_filename;
	   $this->plugin_version      =$version;

    }
}


}