<?php

namespace THEME\ViewModel\Post\Templates;

use Andimar\Theme\ViewModel\Post\ContentTemplate;


class Speaker extends Teacher implements ContentTemplate {

    
    /** 
     *
     * @param WP_Post $post
     * @return array
     */
    function getData( \WP_Post $post ) : array {

        $postData = [
            'id'          => $post->ID,
            'name'        => $post->post_title,
            'excerpt'     => $post->post_excerpt,
            'image'       => $this->getImage( $post )['sizes']['large'],
            'link'        => $this->getLink( $post )            
        ];

        return $postData;
    }

    function getLink( $post ) : string {

        //get the speaker link
        $speakers = get_terms( ['taxonomy'=> 'conduttori', 'object_ids' => $post->ID ]);

        if( empty( $speakers ) ) return '';

        $speaker = array_shift( $speakers );

        return str_replace( 'conduttori', 'audio', get_term_link( $speaker, 'conduttori') ) ;
    }


}


