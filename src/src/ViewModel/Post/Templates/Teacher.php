<?php

namespace THEME\ViewModel\Post\Templates;

use Andimar\Theme\ViewModel\Post\ContentTemplate;


class Teacher extends SingleEvent implements ContentTemplate {

    
    /** 
     *
     * @param WP_Post $post
     * @return array
     */
    function getData( \WP_Post $post ) : array {

        $postData = [
            'id'           => $post->ID,
            'name'         => $post->post_title,
            'excerpt'      => $post->post_excerpt,
            'description'  => $this->getContent( $post ),
            'image'        => $this->getImage( $post )['sizes']['large'],
        ];

        return $postData;
    }


}


