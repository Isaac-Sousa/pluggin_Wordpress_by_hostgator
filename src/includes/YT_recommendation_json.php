<?php
if (! class_exists('YT_recommendation_json')){
    class YT_recommendation_json {
     private $channel_id;

   public function __construct($channel_id){
		$this->channel_id = $channel_id;
	}
	public function from_yt_feed(){
	   $channel_id =  $this->channel_id;
	   $feed_url  = "https://www.youtube.com/feeds/videos.xml?channel_id=$channel_id ";
	}





    }

}