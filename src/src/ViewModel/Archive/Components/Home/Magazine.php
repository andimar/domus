<?php

namespace THEME\ViewModel\Archive\Components\Home;

use Andimar\Theme\ViewModel\Components\Component;
use THEME\ViewModel\Post\Templates;

class Magazine extends Section implements Component {

    protected function getName()               : string { return 'magazine'; }
    protected function getCustomFieldsPrefix() : string { return 'home_magazine'; }
    protected function getCardPostType()       : string { return 'riviste'; }
    protected function getCardTemplate()       : string { return  Templates\Magazine::class; }

}

