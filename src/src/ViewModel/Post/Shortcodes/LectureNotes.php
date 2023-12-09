<?php

namespace THEME\ViewModel\Post\Shortcodes;

use Timber\Timber;
use THEME\ViewModel\Post\Templates\Archive as ArchiveTemplate;

class LectureNotes {


    function __construct() {


        /// rileva il link nel testo
        add_shortcode( 'dispense',  [ $this, 'getLectureNotesMarkup'] );   
        
    }


    function getLectureNotesMarkup() {

        $lectureNotes = $this->getLectureNotes();

        if( isset( $_GET['is_json'] ) ) return json_encode( $lectureNotes );

        return Timber::compile( 'templates/components/widgets/lecture-notes.twig', $lectureNotes );
    }


    protected function getLectureNotes() {

        $postTemplate = new ArchiveTemplate;

        $lectureNotes = array_map( fn( $post ) => $postTemplate->getData( $post), get_posts([
            'post_type' => 'dispense', 
            'posts_per_page' => -1 
        ]) );

    
        return [ 'articles' => $lectureNotes ];
    }
}
