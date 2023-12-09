<?php

namespace THEME\ThemeSetup;

/**
 * Vengono specificate le prinvipali impostazioni del tema
 */
class Support {
    
    /**
     * Initializer for setting up action handler
     */
    public static function init() {

        self::add_theme_support();    
    }

    public static function add_theme_support() {

        if ( function_exists('add_theme_support')) {

            // Add Menu Support
            add_theme_support('menus');
            
            // Add yoast breadcrumbs
            add_theme_support( 'yoast-seo-breadcrumbs' );

            // Add Custom Thumbnail Theme Support
            add_theme_support('post-thumbnails');

            // Add support for responsive embeds.
            add_theme_support( 'responsive-embeds' );

            // Enables post and comment RSS feed links to head
            // add_theme_support('automatic-feed-links');
        
            add_post_type_support( 'page', 'excerpt' );

        }
    }

    
}
