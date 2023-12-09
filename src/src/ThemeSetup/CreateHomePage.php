<?php

namespace THEME\ThemeSetup;

use Andimar\Theme\Utils\Pages;

class CreateHomePage {

    function __construct(){

        Pages::createPage( 'Home', 'home' );
    }
}
