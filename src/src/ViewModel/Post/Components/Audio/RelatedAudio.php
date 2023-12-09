<?php

namespace THEME\ViewModel\Post\Components\Audio;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

use THEME\ViewModel\Post\Templates\ArchiveAudio as AudioTemplate;

class RelatedAudio implements Component {

    protected int $postId;

    function getData(array $contextData = []) : ComponentData {

        $this->postId = $contextData['post']['id'];

        return new ComponentData( 'audio_relateds', $this->getRelateds() );
    }

    protected function getSpeakersTermIds() {

        return wp_get_post_terms( $this->postId, 'conduttori', ['fields' => 'ids'] );

    }


    protected function getRelateds() : array {

        $audioTemplate = new AudioTemplate;

        $relateds = array_map( fn($post) => $audioTemplate->getData( $post ), get_posts([

            'post_type' => 'audio', 
            'tax_query' => [[
                'taxonomy' => 'conduttori',
                'terms'    => $this->getSpeakersTermIds()
            ]],
        
        ]));

        return $relateds;

    }
}
