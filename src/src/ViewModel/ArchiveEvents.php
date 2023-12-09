<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Archive as ArchiveBase;
use THEME\ViewModel\Archive\Components;

class ArchiveEvents extends ArchiveBase {

    const ARCHIVE_POSTS_PER_PAGE = 12;

    protected string $categorySlug;
    protected ?\WP_Term $term;

    function __construct( string $eventsPostTemplate, $categorySlug ) {

        $this->categorySlug = $categorySlug;

        parent::__construct( $eventsPostTemplate );

        $this->term = $this->getTerm();
        
        $this->data['title'] = empty( $this->term ) ? '' : $this->term->name ;

        $events = $this->getEvents();

        $this->data['content'] = empty( $events ) ? 'Non sono previste iniziative o eventi di questo tipo' : '';

        if( $this->categorySlug == '' ) {
            $this->data['next_events'] = array_splice( $events, 0, 5 );            
        }

        $this->data['events'] = $events;
        
    
        $this->data['categories'] = $this->categorySlug == '' ? $this->data['categories'] : $this->data['sub_categories'];
        unset($this->data['sub_categories']);

        ///PROBLEMA INGLESE
        $this->data['categories'] = array_filter( $this->data['categories'] , fn($cat) => !str_contains($cat['slug'],'-en') );
        
        $this->data['categories'] = array_map( fn($cat) => [

            'url'   => $cat['url'],
            'slug'  => $cat['slug'],
            'title' => str_contains( strtolower($cat['title']), 'gioved') ? 'Intensivi del giovedì' : $cat['title']

        ], $this->data['categories']  );
    }


    protected function getEvents() {

        $events =  $this->data['articles'];

        usort( $events, function( $evtA, $evtB ) {

            $a = strtotime($evtA['date']);
            $b = strtotime($evtB['date']);

            if ($a == $b) {
                return 0;
            }
            return ($a > $b) ? -1 : 1;
        });
        
        unset($this->data['articles']);

        return $events;
    }


    protected function setData() {       
        $this->data = [
            'type'     => 'archive',
            'slug'     => $this->categorySlug,
            'taxonomy' => 'attivita' 
        ];
    }

    function initComponents(): array
    {
        return [
            
            Components\Categories::class,
            Components\Subcategories::class,
            \Andimar\Theme\ViewModel\Archive\Components\Pagination::class,
            Archive\Components\Breadcrumbs::class,
        ];
    }

    
    function getTerm() : ?\WP_Term {

        return empty($this->categorySlug) ? null : get_queried_object();
    }
    
}
