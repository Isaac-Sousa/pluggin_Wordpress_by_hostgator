<?php

/**
 * @link            https://github.com/Isaac-Sousa/pluggin_Wordpress_by_hostgator
 * @since           1.0.0
 * @package         Recommend
 *
 * @wordpress-plugin
 * Plugin Name:     Recommendation
 * Plugin URI:      link
 * Description:     Vou te recomendar uns videos bacanas!
 * Version:         1.0.0
 * Author:          Isaac de Sousa
 * Author URI:      https://br.linkedin.com/in/isaac-de-sousa-2b0438252?trk=people-guest_people_search-card
 * License:         indicação/informação
 * License URI:     link
 * Text Domain:     recommend
 * Domain Path:     /languages/
 */
if ( ! defined( 'WPINC' ) ) {
	wp_die();
}

//Plugin Version
if ( ! defined( 'RECOMMEND_VERSION') ) { //NOME DA CONSTANTE COM O NOME DO PLUGIN
	define( 'RECOMMEND_VERSION', '1.0.0' );
}

//Plugin Name

if ( ! defined( 'RECOMMEND_NAME') ) {
	define( 'RECOMMEND_NAME','My recommend');
}

//Plugin Slug

if ( ! defined( 'RECOMMEND_PLUGIN_SLUG') ) {
	define( 'RECOMMEND_PLUGIN_SLUG','recommend');
}

//Plugin Basename

if(! defined('RECOMMEND_BASENAME')){
	define('RECOMMEND_BASENAME',plugin_basename(__FILE__));
}

//Plusin Folder

if(! defined('RECOMMEND_PLUGIN_DIR')){
	define('RECOMMEND_PLUGIN_DIR',plugin_dir_path(__FILE__));
}

//JSON FILE name

if(! defined('RECOMMEND_JSON_FILENAME')){
	define('RECOMMEND_JSON_FILENAME','yt_rec.json');
}
load_plugin_textdomain(
	RECOMMEND_PLUGIN_SLUG, false, RECOMMEND_PLUGIN_SLUG.'/languages/'
);







require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation.php';
require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation_json.php';
require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation_shortcode.php';
require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation_widget.php';
if(is_admin())
require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation_admin.php';

$reco = new youtube_recommendation();
//$channel_id = $recommendation->options['channel_id'];
//if($channel_id != ""){
//	$expiration = $recommendation->options['cache_expiration'];
//	$recommendation_json = new youtube_recommendation_json( $channel_id, $expiration, RECOMMEND_PLUGIN_SLUG, RECOMMEND_JSON_FILENAME );
//
//	$yt_rec_shortcode = new youtube_recommendation_shortcode();
//	$yt_rec_widget = new youtube_recommendation_widget();
//}

if(is_admin()){
	$youtube_recommendation_admin= new Youtube_Recommendation_Admin(
		RECOMMEND_BASENAME,
		RECOMMEND_PLUGIN_SLUG,
		RECOMMEND_JSON_FILENAME,
		RECOMMEND_VERSION
	);
}




