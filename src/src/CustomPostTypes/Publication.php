<?php

namespace THEME\CustomPostTypes;

class Publication {
    
    static function init() {

        // Add the custom columns to the posts post type:
        add_filter( 'init',    [ get_called_class(), 'add_post_type'] );
    }

    /**
     * registra il post-type per le tabelle
     *
     * @return void
     */
    static function add_post_type() {

        register_post_type('dispense', [

            'public'          => true,
            'show_ui'         => true,
            'capability_type' => 'post',
            'hierarchical'    => false,
            'has_archive'     => true, 
            'rewrite'         => [ 'with_front' => true  ],
            'supports'        => [ 'title', 'thumbnail','excerpt' ],
            'show_in_nav_menus' => true,
            'menu_position' => 8,
            'taxonomies' => [ 'conduttori' ],
            
            'labels' => [
                'name' => 'Dispense',
                'singular_name' => 'Dispensa',
                'add_new' => 'Aggiungi nuovo',
                'add_new_item' => 'Aggiungi nuovo Dispensa',
                'edit' => 'Modifica',
                'edit_item' => 'Modifica Dispensa',
                'new_item' => 'Nuovo Dispensa',
                'view' => 'Vedi',
                'view_item' => 'Vedi audio',
                'search_items' => 'Cerca audio',
                'not_found' => 'Nessun audio trovata',
                'not_found_in_trash' => 'Nessun audio trovata nel cestino'
            ]
        ]);

    }


}
