<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Single;

class SingleAudio extends Single {

    function initComponents(): array {
        
        return [
            Archive\Components\News::class,
            Post\Components\Audio\Breadcrumbs::class,
            Post\Components\Speakers::class,
            Post\Components\Audio\OrderModule::class,
            Post\Components\Audio\RelatedAudio::class,
        ];
    }


}
