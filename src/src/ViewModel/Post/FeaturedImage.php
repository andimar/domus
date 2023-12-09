<?php

namespace THEME\ViewModel\Post;

class FeaturedImage extends ImageSizes {

    function __construct($post_id) {

        parent::__construct( get_post_thumbnail_id( $post_id ) , $post_id ); 
    }
}
