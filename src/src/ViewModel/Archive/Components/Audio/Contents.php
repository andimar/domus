<?php

namespace THEME\ViewModel\Archive\Components\Audio;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

class Contents implements Component {

    private \WP_Post $contentsPage;

    function __construct() {

        $this->contentsPage = $this->getAudioContentsPage();
        
    }

    function getData(array $contextData = []) : ComponentData {

        return new ComponentData( 'contents', $this->getContents() );
    }


    function getContents() : array {

        return [
            'text' => apply_filters( 'the_content', $this->contentsPage->post_content) 
        ];
    }
    
    
    private function getAudioContentsPage() : \WP_Post {

        $audioContentsPage = get_posts([ 'post_type' => 'page', 'name' => 'audio-content' ]);

        return array_shift( $audioContentsPage );
    }

    
}

