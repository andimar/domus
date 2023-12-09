<?php

namespace THEME\ViewModel\Archive\Components;

use THEME\ViewModel\Post\Templates\Magazine as MagazineTemplate;
use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

class Magazines implements Component {

    private MagazineTemplate $template;

    function __construct() {

        $this->template = new MagazineTemplate; 
        
    }


    function getData(array $contextData = []): ComponentData {

        return new ComponentData( 'magazines', $this->getMagazines() );
    }

    function getYears() : array {

        return get_terms([ 'taxonomy' => 'anno' ]);
        
    }

    function getMagazinesPerYear( int $yearId ) : array {

        return array_map( fn( $post ) => $this->template->getData( $post ), get_posts([

            'post_type' => 'riviste',
            'posts_per_page' => -1,
            'tax_query' => [[
                'taxonomy' => 'anno',
                'terms' => [ $yearId ]
            ]]

        ]) );
    }

    function getMagazines() : array {

        return array_map( fn( $year ) => [

            'year' => $year->name,
            'magazines' => $this->getMagazinesPerYear( $year->term_id )

        ], $this->getYears());
    }

}
