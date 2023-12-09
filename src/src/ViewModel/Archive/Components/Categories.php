<?php

namespace THEME\ViewModel\Archive\Components;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

class Categories implements Component {

    protected $name = 'categories';

    function __construct() {
    }

    /**
     * set non empty subcategories list 
     */
    function getData(array $contextData = []): ComponentData {

        return new ComponentData( $this->name, $this->getCategories( $contextData['taxonomy'] ) );
        
    }

    function getCategories( string $taxonomy ) : array {        

        // adapt the array shape
        return $taxonomy == '' ? [] : array_map( fn( $term ) => [

            'title' => $term->name,
            'slug'  => $term->slug,
            'url'   => get_term_link( $term->term_id )

        ], get_terms( [ 

            'parent'     => 0,
            'taxonomy'   => $taxonomy,
            'hide_empty' => true            
        ]) );
    
    }

}
