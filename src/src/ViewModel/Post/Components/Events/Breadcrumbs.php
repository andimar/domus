<?php

namespace  THEME\ViewModel\Post\Components\Events;

use Andimar\Theme\ViewModel\Post\Components\Breadcrumbs as BasicBreadcrumbs;
use Andimar\Theme\ViewModel\Components\Component;

class Breadcrumbs extends BasicBreadcrumbs implements Component {

    protected function getTaxonomy() {

        return 'attivita';
    }

    function getBreadcrumbs() : array {

        return array_merge( [
            
            [ 'label' => 'HOME',  'url' => '/' ],
            [ 'label' => 'Iniziative', 'url' => '/attivita/' ]

        ], $this->getCategories() ) ;
    }

}