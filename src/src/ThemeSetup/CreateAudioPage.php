<?php

namespace THEME\ThemeSetup;

use Andimar\Theme\Utils\Pages;

class CreateAudioPage {

    function __construct(){

        Pages::createPage( 'Audio', 'audio-content' );
    }
}
