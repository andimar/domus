<?php

namespace THEME\ViewModel\Post\Templates;

use Andimar\Theme\ViewModel\Post\ContentTemplate;


class Audio extends SingleEvent implements ContentTemplate {

    /** 
     *
     * @param WP_Post $post
     * @return array
     */
    function getData( \WP_Post $post ) : array {

        $customFields =  $this->getCustomFields( $post );
        
        $postData = [
            'id'          => $post->ID,
            'title'       => $post->post_title,
            'excerpt'     => $post->post_excerpt,
            'content'     => $post->post_content,
            'image'       => $this->getImage( $post )['sizes']['large'],
            'link'        => get_permalink($post),
            'period'      => $this->getPeriod( $customFields ),            
            'location'    => $this->getLocation( $customFields ),
            'price'       => $this->getPrice( $customFields ),
            'code'        => $this->getCode( $customFields ),
            'description' => $this->getDescription( $customFields, $post->post_title )
        ];

        return $postData;
    }

    function getPeriod( array $meta ) : string {

        return empty( $meta['periodo'] ) ? '' : $meta['periodo'];    
    }


    function getPrice( array $meta ) : string {
        
        $price = isset( $meta['prezzo'] ) ? (float) $meta['prezzo'] : 0;

        return $price == 0 ? '' : number_format( $price, 2,',','.');
    }

    function getCode( array $meta, string $default = '' ) : string {

        return empty( $meta['codice'] ) ? $default : $meta['codice'];
    }

    function getLocation( array $meta, string $default = '') : string {

        return empty( $meta['location'] ) ? $default : $meta['location'];
    }

    function getDescription( array $meta, string $default = '') : string {

        return empty( $meta['descrizione'] ) ? $default : $meta['descrizione'];
    }


}


