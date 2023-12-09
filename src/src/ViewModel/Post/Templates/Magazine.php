<?php

namespace THEME\ViewModel\Post\Templates;

use Andimar\Theme\ViewModel\Post\ContentTemplate;


class Magazine extends Single implements ContentTemplate {

    
    /** 
     *
     * @param WP_Post $post
     * @return array
     */
    function getData( \WP_Post $post ) : array {

        
        $postData = [
            'id'         => $post->ID,
            'title'      => $post->post_title,
            'excerpt'    => $post->post_excerpt,
            'image'      => $this->getImage( $post )['sizes']['large'],
            'issueyear'  => $this->getIssueYear( $post )
            
        ];

        return $postData;
    }


    function getIssueYear( $post ) {

        $years = wp_get_post_terms( $post->ID, 'anno' );

        return empty($years) ? '' : array_shift( $years )->name;
    }
}


