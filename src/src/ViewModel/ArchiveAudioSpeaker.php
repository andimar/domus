<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Archive as ArchiveBase;

class ArchiveAudioSpeaker extends ArchiveBase {

    protected string $categorySlug;

    function __construct( string $audioPostTemplate, string $categorySlug ) {

        $this->categorySlug = $categorySlug;

        parent::__construct( $audioPostTemplate );
  
        $this->data['title'] = $this->getTitle();

    }

    function getTitle() {

        $speaker = get_term_by( 'slug', $this->categorySlug, 'conduttori' );

        return  __('Audio') . ' ' . $speaker->name;

    }

    protected function setArticles( string $listName = 'audios') {

        parent::setArticles($listName);
    }


    function initComponents(): array {

        $components = [
            \Andimar\Theme\ViewModel\Archive\Components\Pagination::class,
            Archive\Components\Breadcrumbs::class,
            Archive\Components\Audio\Contents::class,
            Archive\Components\Audio\Teachers::class,
            Archive\Components\News::class,
        ];

        return $components;
    }
    
}
