<?php

namespace Andimar\Theme\ViewModel\Components;

class Mobile {

    function getData( array $contextData = [] ) {

        return new ComponentData( 'mobile', wp_is_mobile() );
    }

}
