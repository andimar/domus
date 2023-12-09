<?php

namespace THEME\ViewModel\Archive\Components;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

class Subcategories implements Component{

    private $name = 'sub_categories';

    function __construct() {
    }

    /**
     * set non empty subcategories list 
     */
    function getData(array $contextData = []): ComponentData {

        $term = $this->getTerm( $contextData['slug'], $contextData['taxonomy'] ) ;

        return new ComponentData( $this->name, empty($term) ? [] : $this->getSubCategories( $term ) );

    }

    function getTerm( string $slug, string $taxonomy ) : \WP_Term|null {

        if( $slug == '' ) return null;

        return get_term_by( 'slug', $slug, $taxonomy );
    }


    function getSubCategories( \WP_Term $term ) : array {        

        if( empty( $term ) ) return [];
        
        // adapt the array shape
        $subcategories = empty( $term ) ? [] : array_map( fn( $subterm ) => [

            'title' => $subterm->name,
            'slug'  => $subterm->slug,
            'url'   => get_term_link( $subterm->term_id )

        ], get_terms( [ 

            'parent'     => $term->term_id,
            'taxonomy'   => $term->taxonomy,
            'hide_empty' => true            
        ]) );
        
        return $subcategories;
    }

}
