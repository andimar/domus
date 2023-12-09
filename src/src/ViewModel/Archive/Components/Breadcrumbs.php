<?php

namespace THEME\ViewModel\Archive\Components;

use \Andimar\Theme\ViewModel\Archive\Components\Breadcrumbs as BasicBreadcrumbs;

class Breadcrumbs extends BasicBreadcrumbs {

    protected function getPostType() : array {

        $object = get_queried_object(); 

        switch( get_class($object) ) {

            case "WP_Post_Type" : 
                
                $postType = $object; 
                break;

            case "WP_Term" : 

                global $posts;
        
                $post = array_shift($posts);

                if( empty($posts) ) {

                    $term = get_queried_object();
                    
                    switch( $term->taxonomy ) {

                        case "attivita"   : $postType = get_post_type_object( 'iniziativa' ); break;
                        case "conduttori" : $postType = get_post_type_object( 'audio'      ); break;

                    }

                } else {

                    $postType = get_post_type_object( $post->post_type );
                }
                
                
                
                break;

            default:
                $postType = null; 
        }

       
        
        switch( $postType->name ) {

            case "iniziativa" : 
                
                $label = 'Iniziative';
                $slug  = 'attivita';
                break;


            default:
                $label = $postType->label;
                $slug  = $postType->rewrite['slug'];
        }
       
        return $postType == null ? [] : [ 'label' => $postType->label,  'url' => "/{$postType->rewrite['slug']}/" ];        
    }

}
