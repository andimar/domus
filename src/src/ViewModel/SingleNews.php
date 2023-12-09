<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Single;

class SingleNews extends Single {


    function initComponents(): array {
        
        return [
            // \Andimar\Theme\ViewModel\Post\Components\Breadcrumbs::class,            
            Archive\Components\News::class,
        ];
    }


}
