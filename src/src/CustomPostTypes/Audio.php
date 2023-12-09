<?php

namespace THEME\CustomPostTypes;

class Audio {
    
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

        register_post_type('audio', [

            'public'          => true,
            'show_ui'         => true,
            'capability_type' => 'post',
            'hierarchical'    => false,
            'has_archive'     => true, 
            'rewrite'         => [ 'with_front' => true  ],
            'supports'        => [ 'title', 'editor' ],
            'show_in_nav_menus' => true,
            'menu_position' => 6,
            'taxonomies' => [ 'conduttori' ],
            
            'labels' => [
                'name' => 'Audio',
                'singular_name' => 'Audio',
                'add_new' => 'Aggiungi nuovo',
                'add_new_item' => 'Aggiungi nuovo audio',
                'edit' => 'Modifica',
                'edit_item' => 'Modifica audio',
                'new_item' => 'Nuovo audio',
                'view' => 'Vedi',
                'view_item' => 'Vedi audio',
                'search_items' => 'Cerca audio',
                'not_found' => 'Nessun audio trovato',
                'not_found_in_trash' => 'Nessun audio trovato nel cestino'
            ]
        ]);

    }


}
