<?php
if ( ! class_exists('youtube_recommendation_shortcode')){
class youtube_recommendation_shortcode {

	public function __construct(){
		add_shortcode('YoutubeR', array($this, 'shortcode'));
	}





 }
}