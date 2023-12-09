<?php

namespace THEME\ViewModel\Post\Templates;

use Andimar\Theme\ViewModel\Post\ContentTemplate;


class ArchiveAudio extends Audio implements ContentTemplate {

    use Teachers;
    
    /** 
     *
     * @param WP_Post $post
     * @return array
     */
    function getData( \WP_Post $post ) : array {

        $teacher      = $this->getTeacher( $post );
        $customFields = $this->getCustomFields( $post );

        $postData = [
            'id'          => $post->ID,
            'title'       => $post->post_title,
            'excerpt'     => $post->post_excerpt,
            'content'     => $post->post_content,
            'image'       => $this->getImage( $post )['sizes']['large'],
            'teacher'     => $teacher['name'],
            'avatar'      => $teacher['avatar'],
            'period'      => $this->getPeriod( $customFields ), 
            'location'    => $this->getLocation( $customFields ),
            'price'       => $this->getPrice( $customFields ),
            'code'        => $this->getCode( $customFields ),
            'description' => $this->getDescription( $customFields, $post->post_title ),
            'link'        => get_permalink($post)
        ];

        return $postData;
    }


    function getDescription(array $meta, string $default = '', int $length = 60): string {

        $description = parent::getDescription( $meta, $default );

        return strlen( $description ) > $length ? substr( $description, 0, $length ).'...' : $description;
        
    }


}


