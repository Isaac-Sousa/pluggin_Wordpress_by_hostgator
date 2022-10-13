<?php
/**
 * Plugin Mame: Recommend
 */

add_filter( 'the_content', 'thanks' );

function thanks ($content){
    return $content.'<p><strong>Obrigado por me instalar!</strong></p>';
}