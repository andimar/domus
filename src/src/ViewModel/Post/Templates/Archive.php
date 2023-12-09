<?php

namespace THEME\ViewModel\Post\Templates;

use Andimar\Theme\ViewModel\Post\ContentTemplate;


class Archive extends Single implements ContentTemplate {

    /**
     * Basic post data for a generic Single
     *
     * @param WP_Post $post
     * @return array
     */
    function getData( $post ) : array {

        return [
            'id'         => $post->ID,
            'title'      => $post->post_title,
            'excerpt'    => $post->post_excerpt,
            'image'      => $this->getImage( $post ) ['sizes'] ['medium'],
            'tags'       => $this->getTags( $post ),
            'link'       => \get_the_permalink( $post ),
            'categories' => $this->getCategories( $post )
        ];
    }
}


