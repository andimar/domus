<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Single;

class SingleEvent extends Single {

    function initComponents(): array {
        
        return [
            Archive\Components\News::class,
            Post\Components\Events\Breadcrumbs::class,
            Post\Components\Speakers::class,
            // ORDER MODULE
        ];
    }


}
