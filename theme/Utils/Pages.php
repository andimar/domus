<?php

namespace Andimar\Theme\Utils;

class Pages {

    public static function createPage( $title, $slug, $content = '', $parent = 0) : void {

        if( self::getPageID( $slug ) != 0 ) return;
    
        wp_insert_post([

            'comment_status' => 'close',
            'ping_status'    => 'close',
            'post_author'    => 1,
            'post_title'     => $title,
            'post_name'      => $slug,
            'post_status'    => 'publish',
            'post_content'   => '',
            'post_type'      => 'page',
            'post_parent'    =>  0
        ], false, false );
    }

    public static function getPageID( string $pageSlug ) : int {

        $objPage = get_posts([ 'name' => $pageSlug, 'post_type' => 'page' ]);

        return empty( $objPage ) ? 0 : array_shift($objPage)->ID;
    }
}
