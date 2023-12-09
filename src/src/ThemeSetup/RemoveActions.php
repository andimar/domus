<?php

namespace THEME\ThemeSetup;

/**
 * Vengono specificate le prinvipali impostazioni del tema
 */
class RemoveActions {
    
    /**
     * Initializer for setting up action handler
     */
    public static function init() {

        self::remove_feeds();
        self::remove_emoji();
        self::more_removal();        
        
    }

    public static function remove_feeds () {
        
        // Remove Actions
        remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
        remove_action('wp_head', 'feed_links', 2);       // Display the links to the general feeds: Post and Comment Feed
        remove_action('wp_head', 'rsd_link');  
    }

        
    public static function remove_emoji () {
        
        // remove emojis
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
    }

    public static function more_removal () {
        
        remove_action('wp_head', 'wlwmanifest_link');    // Display the link to the Windows Live Writer manifest file.
        remove_action('wp_head', 'index_rel_link');      // Index link
        remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
        remove_action('wp_head', 'start_post_rel_link', 10, 0);  // Start link

        remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
        remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.        
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

        remove_action('wp_head', 'rel_canonical');
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
        remove_action('wp_head', '_wp_render_title_tag', 1 );
    }
}
