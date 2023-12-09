<?php

namespace THEME\ViewModel\Archive\Components;

use THEME\ViewModel\Post\Templates\Archive;
use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

class News implements Component {

    private Archive $template;

    function __construct() {

        $this->template = new Archive; 
        
    }


    function getData(array $contextData = []): ComponentData {

        return new ComponentData( 'articles', $this->getHomePageNews() );
    }


    function getHomePageNews() : array {

        $featuredPosts = get_posts([

            'posts_per_page' => 4,

        ]);

        return array_map( fn( $post ) => $this->template->getData( $post ), $featuredPosts );

    }

}
