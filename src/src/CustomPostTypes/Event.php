<?php

namespace THEME\CustomPostTypes;

class Event {
    
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

        // da finire
        register_post_type('iniziativa', [

            'public'          => true,
            'show_ui'         => true,
            'capability_type' => 'post',
            'hierarchical'    => false,
            'has_archive'     => true,
            'rewrite'         => [ 'with_front' => true  ],
            'supports'        => [ 'title', 'editor' ],
            'show_in_nav_menus' => true,
            'menu_position' => 6,
            'taxonomies' => [ 'attivita', 'conduttori' ],
            
            'labels' => [
                'name' => 'Iniziative',
                'singular_name' => 'Iniziativa',
                'add_new' => 'Aggiungi nuovo',
                'add_new_item' => 'Aggiungi nuova Iniziativa',
                'edit' => 'Modifica',
                'edit_item' => 'Modifica Iniziativa',
                'new_item' => 'Nuova Iniziativa',
                'view' => 'Vedi',
                'view_item' => 'Vedi Iniziativa',
                'search_items' => 'Cerca Iniziativa',
                'not_found' => 'Nessuna Iniziativa trovata',
                'not_found_in_trash' => 'Nessuna Iniziativa trovata nel cestino'
            ]
        ]);

    }


}
