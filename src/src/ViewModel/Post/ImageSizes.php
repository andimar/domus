<?php

namespace THEME\ViewModel\Post;

class ImageSizes {

    protected $image;
    protected $attachment_id;
    protected $post_id;

    function __construct( $image_id, $post_id ) {

        $this->post_id = $post_id;

        $this->attachment_id = $image_id;
        
        $this->image = [ 
            'sizes' => [] 
        ];

        $this->setImageMetaData();
    }


    function allSizes() {

        $image_sizes = get_intermediate_image_sizes();

        return is_array( $image_sizes ) ? $this->sizes($image_sizes) : [];
    }


    function sizes( $image_sizes ) {

        foreach($image_sizes as $size) {
            
            $size_name = strpos( $size,  'blz_' ) !== false ? $size : 'blz_' . $size;
            
            $thumbor = get_field( 'thumbor', $this->post_id );
            
            if( !$thumbor ) {

                remove_filter( 'wp_get_attachment_image_src', 'tbm_fix_thumbnail_img', 1 );
            } 

            $src = wp_get_attachment_image_src( $this->attachment_id, $size_name );

            
            $url = is_array( $src ) ? $src[0] : wp_get_attachment_image_url( $this->attachment_id, $size_name );

            $url = str_replace(['preprod.', 'staging.', 'local.', 'new.'], 'www.', $url);

            //$url = str_replace('amecoweb.test', 'associazioneameco.it', $url);
        
            $this->image['sizes'][$size] = $url;
        }

        return $this->image;
    }


    private function setImageMetaData(){

        $this->image['title']       = get_the_title($this->attachment_id);
        $this->image['credits']     = get_field('image_credits', $this->attachment_id);
        $this->image['credits_url'] = get_field('image_credits_url', $this->attachment_id);
    }


}