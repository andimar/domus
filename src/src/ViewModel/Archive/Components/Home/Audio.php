<?php

namespace THEME\ViewModel\Archive\Components\Home;

use Andimar\Theme\ViewModel\Components\Component;
use THEME\ViewModel\Post\Templates;

class Audio extends Section implements Component {

    protected function getName()               : string { return 'audio'; }
    protected function getCustomFieldsPrefix() : string { return 'home_audio'; }
    protected function getCardPostType()       : string { return 'audio'; }
    protected function getCardTemplate()       : string { return  Templates\ArchiveAudio::class; }

}
