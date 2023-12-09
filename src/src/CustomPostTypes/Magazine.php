<?php

namespace THEME\CustomPostTypes;

class Magazine {
    
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

        register_post_type('riviste', [

            'public'          => true,
            'show_ui'         => true,
            'capability_type' => 'post',
            'hierarchical'    => false,
            'has_archive'     => true,
            'rewrite'         => [ 'with_front' => true  ],
            'supports'        => [ 'title', 'custom-fields', 'thumbnail' ],
            'show_in_nav_menus' => true,
            'menu_position' => 7,
            'taxonomies' => [ ],
            
            'labels' => [
                'name'   => 'Riviste',
                'singular_name' => 'Rivista',
                'add_new' => 'Aggiungi nuovo',
                'add_new_item' => 'Aggiungi nuova Rivista',
                'edit' => 'Modifica',
                'edit_item' => 'Modifica Rivista',
                'new_item' => 'Nuovo Rivista',
                'view' => 'Vedi',
                'view_item' => 'Vedi Rivista',
                'search_items' => 'Cerca Rivista',
                'not_found' => 'Nessuna Rivista trovata',
                'not_found_in_trash' => 'Nessuna Rivista trovata nel cestino'
            ]
        ]);

    }


}
