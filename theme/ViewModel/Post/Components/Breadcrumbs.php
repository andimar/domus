<?php

namespace  Andimar\Theme\ViewModel\Post\Components;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

class Breadcrumbs implements Component {

    function getData( array $contextData = [] ) : ComponentData {
            
        return new ComponentData( 'breadcrumbs',  $this->getBreadcrumbs() );
    }

    protected function getPost() {
        
        global $posts;

        return array_shift( $posts ); 
    }

    protected function getTaxonomy() {

        return 'category';
    }

    function getCategories() : array {     

        $categories = wp_get_post_terms( $this->getPost()->ID, $this->getTaxonomy(), ['fields' => 'all', 'orderby' => 'parent'] );

        return array_map( function( $term ) {

            return [ 
                'label'      => $term->name, 
                'url'        => get_term_link( $term->term_id, $term->taxonomy ),
            ];

        }, $categories );
    }

    function getBreadcrumbs() : array {

        return array_merge( [[
            'label' => 'HOME',
            'url'   => '/'
        ]], $this->getCategories() ) ;
    }
}