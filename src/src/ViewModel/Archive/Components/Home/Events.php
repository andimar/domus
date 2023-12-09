<?php

namespace THEME\ViewModel\Archive\Components\Home;

use Andimar\Theme\ViewModel\Components\Component;
use THEME\ViewModel\Post\Templates;

class Events extends Section implements Component {

    protected function getName()               : string { return 'events'; }
    protected function getCustomFieldsPrefix() : string { return 'home_events'; }
    protected function getCardPostType()       : string { return 'iniziativa'; }
    protected function getCardTemplate()       : string { return  Templates\ArchiveEvent::class; }

}
