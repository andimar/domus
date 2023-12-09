<?php

namespace THEME\ViewModel\Archive\Components\Home;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

class Where implements Component {

    function getData(array $contextData = []): ComponentData {

        return new ComponentData( 'where', [] );
    }

}
