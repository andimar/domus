<?php

namespace THEME\ViewModel\Post\Templates;

use Andimar\Theme\ViewModel\Post\ContentTemplate;

use THEME\ViewModel\Post\FeaturedImage;


class SingleEvent implements ContentTemplate {

    /** 
     *
     * @param WP_Post $post
     * @return array
     */
    function getData( \WP_Post $post ) : array {

        $customFields = $this->getCustomFields( $post );
    
        return [
            'id'         => $post->ID,
            'title'      => $post->post_title,
            'content'    => $this->getContent( $post ),
            'excerpt'    => $post->post_excerpt,
            'date'       => $this->getStartDate( $customFields ),
            'end-date'   => $this->getEndDate( $customFields ),
            'location'   => $this->getLocation( $customFields ),
            'price'      => $this->getPrice( $customFields ),
            'category'   => $this->getEventCategory( $post ),
            'occurs'     => $this->getOccurency( $customFields ),
            'by_ameco'   => $this->getByAmeco( $customFields ),
            
        ];
    }

    function getStartDate( array $meta ) : string {

        return date('d-m-Y', strtotime( $meta['data_inizio'] ) );
    }

    function getEndDate( array $meta ) : string {

        return date('d-m-Y', strtotime( $meta['data_fine'] ) );
    }

    function getPrice( array $meta ) : string {

        $price = isset( $meta['costo'] ) ? (float) $meta['costo'] : 0;

        return $price == 0 ? '' : number_format( $price, 2,',','.') .'€';
    }


    function getLocation( array $meta ): string {

        return empty( $meta['location'] ) ? '' : $meta['location'];

    }
   
    function getOccurency( array $meta ) : string {

        return empty( $meta['ricorre'] ) ? '' : $meta['ricorre'];
    }


    function getByAmeco( array $meta ) : bool {

        return empty( $meta['by_ameco'] ) ? false : $meta['by_ameco'];
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
     * Returns the post category
     * 
     * @param WP_Post $post
     * @return WP_Term
     */
    protected function getEventCategory( $post ) {

        $categories = wp_get_post_terms( $post->ID, 'attivita' );

        $category = empty( $categories ) ? (object) ['slug' => ''] : array_shift( $categories );

        return $category->slug;
    }



    /**
     * Returns acf custom fields for the given post     
     * 
     * @param WP_Post $post
     * @return array
     */
    protected function getCustomFields( $post ) : array {

        $customFields = get_fields( $post->ID );

        return empty( $customFields) ? [] : $customFields;
       
    }
    

}
