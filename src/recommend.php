<?php

/**
 * @link            https://github.com/Isaac-Sousa/pluggin_Wordpress_by_hostgator
 * @since           1.0.0
 * @package         Recommend
 *
 * @wordpress-plugin
 * Plugin Name:     Recommendation
 * Plugin URI:      link
 * Description:     Videos recommendations
 * Version:         1.0.0
 * Author:          Isaac de Sousa
 * Author URI:      link
 * License:         indicação/informação
 * License URI:     link
 * Text Domain:     Isso ai mesmo
 * Domain Path:     link
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
	define( 'RECOMMEND_NAME','recommend');
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

require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation.php';
require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation_json.php';
require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation_shortcode.php';
require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation_widget.php';

if(is_admin())
	require_once RECOMMEND_PLUGIN_DIR . 'includes/youtube_recommendation_admin.php';
    $yt_yt_rec_admin = NEW youtube_recommendation_admin(
    RECOMMEND_BASENAME,
    RECOMMEND_PLUGIN_SLUG,
    RECOMMEND_JSON_FILENAME,
    RECOMMEND_VERSION
    );

//add_filter('the_content', 'thanks');
//function thanks ($content){
//	return $content.'start again';
//}