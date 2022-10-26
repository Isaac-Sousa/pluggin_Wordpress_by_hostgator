<?php
if ( ! class_exists('youtube_recommendation_shortcode')){
class youtube_recommendation_shortcode {

	public function __construct(){
		add_shortcode('YoutubeR', array($this, 'shortcode'));
	}
	public function shortcode($args, $content=null){
    extract($args);

	$short_code_unique_id = 'yt_rec_shortcode_' . wp_rand(1, 1000);

	$limit = isset($limit) ? $limit : 1;
	$layout = (isset($layout) && 'layout' == 'list') ? $layout : 'grid';
	$language = get_locale();

	$content = "
<div id='$container_id'> ._('Loading...', 'recommend') . ;

<script>
    YoutubeRecommendation.listCallbacks.push({
        containerId: '$container_id',
        layout: '$layout' ,
        limit: $limit,
        lang: '$language',
        callback:YoutubeRecommendation.buildList,
    });
</script>";

	return $content;

	}

 }
}