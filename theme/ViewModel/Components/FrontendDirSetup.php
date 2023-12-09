<?php

namespace Andimar\Theme\ViewModel\Components;


class FrontendDirSetup 
{

    function getData( array $data = []) {

        $base_dir = get_template_directory_uri() . '/frontend';

        return new ComponentData( $name = 'base_dir', $data = $base_dir );
    }


}
