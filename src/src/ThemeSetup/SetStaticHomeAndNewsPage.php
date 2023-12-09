<?php

namespace THEME\ThemeSetup;

use Andimar\Theme\Utils\Pages;
use Exception;

class SetStaticHomeAndNewsPage {

    function __construct(){

        Pages::createPage( 'News', 'news' );

        $this->setPages();
    }

    

    function setPages() {
        
        $homeId = Pages::getPageID( 'home' );
        $newsId = Pages::getPageID( 'news' );

        if( $homeId == 0 || $newsId == 0 ) { 

            throw new Exception('Impossibile impostare la pagina Home e la pagina News');
        }

        /// set Home page
        update_option( 'page_on_front', $homeId );
        update_option( 'show_on_front', 'page' );
    
        // Set the blog page
        update_option( 'page_for_posts', $newsId );

    }

}
