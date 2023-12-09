<?php

namespace THEME\ViewModel\Archive\Components\Audio;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

use THEME\ViewModel\Post\Templates;

class Teachers implements Component {

    protected Templates\Speaker $postTemplate;

    function __construct() {

        $this->postTemplate = new Templates\Speaker;
        
    }

    function getData(array $contextData = []) : ComponentData {

        return new ComponentData( 'teachers', $this->getTeachers() );
    }


    protected function getSpeakersTermIds() : array { 

        return get_terms( [ 'taxonomy' => 'conduttori', 'hide_empty' => true, 'fields' => 'ids' ] );
    }


    function getTeachers() {

        $posts = get_posts([

            'post_type' => 'insegnanti', 'posts_per_page' => -1,
            'tax_query' => [[
                'taxonomy' => 'conduttori',
                'terms'    => $this->getSpeakersTermIds()
            ]],
            'meta_key' => 'order',
            'orderby'  => 'meta_value_num',
            'order'    => 'ASC'
        ]);


        
        return  array_map( fn($post) => $this->postTemplate->getData($post), $posts );
    }
    
}

