<?php

namespace Andimar\Theme\ViewModel\Archive\Components;

use Andimar\Theme\ViewModel\Components\ComponentData;

class Breadcrumbs {

    protected string $name = 'breadcrumbs';


    function getData(array $contextData = []): ComponentData {

        return new ComponentData( $this->name, $this->getBreadcrumbs() );
    }


    protected function getHome( ) {

        return [ 'label' => 'HOME',  'url' => '/' ];
    }
    

    protected function getPostType() : array {

        $object = get_queried_object(); 

        switch( get_class($object) ) {

            case "WP_Post_Type" : 
                
                $postType = $object; 
                break;

            case "WP_Term" : 

                global $posts;
        
                $post = array_shift($posts);
        
                $postType = get_post_type_object( $post->post_type );                
                break;

            default:
                $postType = null; 
        }
       
        return $postType == null ? [] : [ 'label' => $postType->label,  'url' => "/{$postType->rewrite['slug']}/" ];        
    }

    
    protected function getTerm() : \WP_Term|null {
        	
        $object = get_queried_object(); 

        return get_class($object) === "WP_Term" ? $object : null;
    }

    
    protected function getCategories( $currentTerm ) : array {

        if ( $currentTerm === null ) return [];
        
        return $currentTerm->parent == 0 ? [ $currentTerm ] : array_merge( $this->getCategories( get_term( $currentTerm->parent, $currentTerm->taxonomy ) ), [ $currentTerm ] ) ;
    }

    
    protected function getTermTemplate( \WP_Term $term ) : array {

        return [ 'label' => $term->name,  'url' => get_term_link( $term->term_id ) ];

    }


    function getBreadcrumbs() : array {

        $categories = array_map( fn( $category ) => $this->getTermTemplate( $category ), $this->getCategories( $this->getTerm() ) );

        if( !empty( $categories )) array_unshift( $categories, $this->getPostType() );

        array_pop($categories);
        
        array_unshift( $categories, $this->getHome() );

        return $categories;        
    }
}
