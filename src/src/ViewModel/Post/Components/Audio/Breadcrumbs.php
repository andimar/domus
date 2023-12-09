<?php

namespace  THEME\ViewModel\Post\Components\Audio;

use Andimar\Theme\ViewModel\Post\Components\Breadcrumbs as BasicBreadcrumbs;
use Andimar\Theme\ViewModel\Components\Component;

class Breadcrumbs extends BasicBreadcrumbs implements Component {

    protected function getTaxonomy() {

        return 'conduttori';
    }

    function getBreadcrumbs() : array {

        return array_merge( [
            
            [ 'label' => 'HOME',  'url' => '/' ],
            [ 'label' => 'Audio', 'url' => '/audio/' ]

        ], $this->getCategories() ) ;
    }

}