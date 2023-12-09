<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Single;

class SingleMagazine extends Single {

    function initComponents(): array {
        
        return [
            \Andimar\Theme\ViewModel\Post\Components\Breadcrumbs::class,            
            Archive\Components\News::class,
            Archive\Components\Magazines::class,

        ];
    }

}
