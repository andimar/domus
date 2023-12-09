<?php
namespace THEME\AdminUserInterface;

class OptionsPage {

    function __construct() {

        $this->createSettingsPage();
    }


    /**
     * Serve per creare la pagina dei settings
     */
    protected function createSettingsPage() {

        if( function_exists('acf_add_options_page') ) {
        
            acf_add_options_page( [
                'page_title' 	=> 'Opzioni del sito',
                'menu_title'	=> 'Opzioni del sito',
                'menu_slug' 	=> 'site-general-settings',
                'capability'	=> 'edit_posts',
                'redirect'		=> false
            ]);            
        }


        // aggiunge subpage 
        if( function_exists('acf_add_options_sub_page') ) {

            acf_add_options_sub_page([
                'title'  => 'Audio',
                'parent' => 'site-general-settings'
            ]);
        }
    }

}