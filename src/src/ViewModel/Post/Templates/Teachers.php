<?php

namespace THEME\ViewModel\Post\Templates;

trait Teachers {


    function getEmptyTeacher() : array {

        return [

            'avatar' => '',
            'name'   => '',
            'link'   => '' 
        ];
    }

    
    function getTeacher( \WP_Post $post ) {

        $eventHosts = wp_get_post_terms( $post->ID, 'conduttori' );

        if ( empty( $eventHosts ) ) return $this->getEmptyTeacher();

        $eventHost = array_shift( $eventHosts );

        $teachers = get_posts([

            'post_type' => 'insegnanti',
            'tax_query' => [[
                "taxonomy" => "conduttori",
                "terms"    => $eventHost->term_id
            ]],
        ]);

        if( empty($teachers) ) return $this->getEmptyTeacher();

        $teacher = array_shift( $teachers );

        $images = $this->getImage( $teacher );

        return [
            'avatar' => $images['sizes']['medium'],
            'name'   => $teacher->post_title,
            'link'   => get_the_permalink( $teacher ) 
        ];
    }
}


