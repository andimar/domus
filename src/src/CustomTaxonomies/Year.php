<?php

namespace THEME\CustomTaxonomies;

class Year {

    static function init() {

        // Add the custom columns to the posts post type:
        add_action( 'init',      [ get_called_class(), 'add_taxonomy'   ], 1 );        
    }

    /**
     * registra il post-type per le tabelle
     *
     * @return void
     */
    static function add_taxonomy() {

        $labels = [
            'name'              => 'anno',
            'singular_name'     => 'Anno',
            'search_items'      => 'Cerca anno',
            'all_items'         => 'Tutti gli anni',
            'edit_item'         => 'Modifica Anno', 
            'update_item'       => 'Aggiorna Anno',
            'add_new_item'      => 'Aggiungi Anno',
            'new_item_name'     => 'Nuovo Anno',
            'menu_name'         => 'Anni',
        ]; 

        $args = [
            'labels'            => $labels,
            'public'            =>  true,
            'hierarchical'      =>  true,
            'show_in_nav_menus' =>  true,
            'has_archive'       =>  true,
            'rewrite'           =>  [ 'slug' => 'anno', 'with_front' => true],
        ];

        register_taxonomy( 'anno', [ 'riviste' ], $args );        
    }

    
    

}
