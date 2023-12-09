<?php

namespace THEME\ThemeSetup;


class Menu {   
    /**
     * Initializer for setting up action handler
     */
    public static function init()
    {
        add_action('init', [ get_called_class(), 'register_menu' ]); // Add Menu  +       
    }

    /**
     * Insert a new row 
     */
    public static function register_menu()
    {
        register_nav_menus(
            [ // Using array to specify more menus if needed
            'main-menu' => 'Main Menu', // Main Navigation
            'footer-menu' => 'Footer Menu' // Footer Navigation            
            ]
        );
    }    
}
