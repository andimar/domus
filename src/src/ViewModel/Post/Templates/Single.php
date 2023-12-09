<?php

namespace THEME\ViewModel\Post\Templates;

use Andimar\Theme\ViewModel\Post\ContentTemplate;

use THEME\ViewModel\Post\FeaturedImage;


class Single implements ContentTemplate {

    
    /**
     * Basic post data for a generic Single
     *
     * @param WP_Post $post
     * @return array
     */
    function getData( \WP_Post $post ) : array {

        /// basic post data 
        $postData = [
            'id'         => $post->ID,
            'title'      => $post->post_title,
            'excerpt'    => $post->post_excerpt,
            'content'    => $this->getContent( $post ),
            'image'      => $this->getImage( $post ),
            'pubdate'    => $this->getDate( $post ),
            'moddate'    => $this->getUpdateDate( $post ),
            'tags'       => $this->getTags( $post ),
            'link'       => get_the_permalink( $post ),
            'categories' => $this->getCategories( $post )
        ];

        /// add post_meta to basic data
        $customFields = $this->getCustomFields( $post );

        if( is_array( $customFields ) && !empty( $customFields ) ) {

            $postData = array_merge( $postData, $customFields );
        }

        return $postData;
    }


    /**
     * Returns the filtered post_content
     *
     * @param WP_Post $post
     * @return string
     */
    protected function getContent( $post ) {

        return apply_filters('the_content', $post->post_content);
    }


    protected function getCategories( $post ) {

        return wp_get_post_terms( $post->ID, 'category', [ 'fields'=> 'slugs' ] );
    }

    /**
     * Returns the featured image for the given post
     * as a FeaturedImage object
     * 
     * Basic sizes ( square, small, medium, large ) and relatives x2 formats
     *
     * @param WP_Post $post
     * @return FeaturedImage
     */
    protected function getImage( $post ) {

        $featuredImage = new FeaturedImage( $post->ID );

        return $featuredImage->sizes(['extra_small', 'extra_small_x2', 'square', 'square_x2', 'small', 'small_x2', 'medium', 'medium_x2', 'large', 'large_x2', 'product' ]);
    }


    /**
     * Returns an associative array with
     * the give post's publication date 
     * and its timestamp
     *
     * @param WP_Post $post
     * @return array
     */
    protected function getDate($post) {

        $timestamp = strtotime(  $post->post_date );

        return [ 'date_label' => $this->dateLabel(  $post->post_date ), 'date' => $post->post_date, 'date_gmt' => $post->post_date_gmt, 'timestamp' => $timestamp ];
    }

    protected function getUpdateDate($post) {

        $timestamp = strtotime(  $post->post_modified );

        return [ 'date_label' => $this->dateLabel(  $post->post_modified ), 'date' => $post->post_modified, 'date_gmt' => $post->post_modified_gmt, 'timestamp' => $timestamp ];
    }

    private function dateLabel( $date ) {

        $timestamp = strtotime( $date );
        
        $day = ( int ) date('d', $timestamp);
        $month = ['gen','feb','mar','apr','mag','giu','lug','ago','set','ott','nov','dic'][( ( int ) date('m', $timestamp)) -1 ];
        $year = date('Y', $timestamp);
        
        return "{$day} {$month} {$year}";
    }
    
    

    /**
     * Returns a list of the tag names
     *
     * @param WP_Post $post
     * @return string[]
     */
    protected function getTags( $post ) {

        $tags = get_the_tags( $post->ID );
        
        return ( $tags === false ) ? [] : array_map( function( $tag ){ return $tag->name; }, $tags );
    }

    /**
     * Returns the post category
     * 
     * @param WP_Post $post
     * @return WP_Term
     */
    protected function getCategory( $post ) {

        $categories = wp_get_post_terms( $post, 'category' );

        return empty( $categories ) ? null : array_shift( $categories );
    }



    /**
     * Returns acf custom fields for the given post     
     * 
     * @param WP_Post $post
     * @return array
     */
    protected function getCustomFields( $post ) {

        $fields = get_fields( $post->ID );
        
        $fieldsRetrieved = [];

        if( $fields ) {

            foreach( $fields as $name => $value ) {
            
                $fieldsRetrieved['meta'][$name] = $value;
            }
        }
 
        return $fieldsRetrieved;
    }
    

}
