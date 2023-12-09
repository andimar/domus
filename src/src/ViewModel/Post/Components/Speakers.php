<?php

namespace THEME\ViewModel\Post\Components;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

use THEME\ViewModel\Post\Templates\Teacher as TeacherTemplate;

class Speakers implements Component {

    protected int $postId;


    function getData(array $contextData = []) : ComponentData {

        $this->postId = $contextData['post']['id'];

        return new ComponentData( 'speakers', $this->getTeachers() );
    }


    protected function getSpeakersTermIds() : array { 

        return wp_get_post_terms( $this->postId, 'conduttori', [ 'fields' => 'ids' ] );
    }


    protected function getTeachers() {

        $teacherTemplate = new TeacherTemplate;

        $teachers = get_posts( [

            'post_type' => 'insegnanti',
            'tax_query' => [[
                "taxonomy" => "conduttori",
                "terms"    =>  $this->getSpeakersTermIds()
            ]],
        ]);

        return array_map( fn( $post ) => $teacherTemplate->getData( $post ), array_filter( $teachers, fn( $post ) => !str_contains($post->post_name, '-2') ) );
    }

    
}

