<?php

namespace THEME\ViewModel\Archive\Components\Home;

use Andimar\Theme\ViewModel\Components\Component;

class About extends Section implements Component {

    protected function getName()               : string { return 'about'; }
    protected function getCustomFieldsPrefix() : string { return 'what_is_ameco'; }
    protected function getCardPostType()       : string { return ''; }
    protected function getCardTemplate()       : string { return ''; }
}

