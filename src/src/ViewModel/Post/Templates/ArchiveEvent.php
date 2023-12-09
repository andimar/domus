<?php

namespace THEME\ViewModel\Post\Templates;

use Andimar\Theme\ViewModel\Post\ContentTemplate;


class ArchiveEvent extends SingleEvent implements ContentTemplate {

    use Teachers;

    /** 
     *
     * @param WP_Post $post
     * @return array
     */
    function getData( \WP_Post $post ) : array {

        $teacher = $this->getTeacher( $post );

        $customFields = $this->getCustomFields( $post );
    
        $postData = [
            'id'         => $post->ID,
            'title'      => $post->post_title,
            'excerpt'    => $post->post_excerpt,
            'teacher'    => $teacher['name'],
            'avatar'     => $teacher['avatar'],
            'date'       => $this->getStartDate( $customFields ),
            'end-date'   => $this->getEndDate( $customFields ),
            'location'   => $this->getLocation( $customFields ),
            'price'      => $this->getPrice( $customFields ),
            'category'   => $this->getEventCategory( $post ),
            'occurs'     => $this->getOccurency( $customFields ),
            'by_ameco'   => $this->getByAmeco( $customFields ),            
            'link'       => get_permalink( $post )

        ];


        return $postData;
    }

}


