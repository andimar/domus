<?php

namespace THEME\CustomPostTypes;

class Teacher {
    
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

        register_post_type('insegnanti', [

            'public'          => true,
            'show_ui'         => true,
            'capability_type' => 'post',
            'hierarchical'    => false,
            'has_archive'     => true,
            'rewrite'         => [ 'with_front' => true  ],
            'supports'        => [ 'title', 'editor', 'thumbnail' ],
            'show_in_nav_menus' => true,
            'menu_position' => 7,
            'taxonomies' => [ 'conduttori' ],
            
            'labels' => [
                'name'   => 'Insegnanti',
                'singular_name' => 'Insegnante',
                'add_new' => 'Aggiungi nuovo',
                'add_new_item' => 'Aggiungi nuovo Insegnante',
                'edit' => 'Modifica',
                'edit_item' => 'Modifica Insegnante',
                'new_item' => 'Nuovo Insegnante',
                'view' => 'Vedi',
                'view_item' => 'Vedi Insegnante',
                'search_items' => 'Cerca Insegnante',
                'not_found' => 'Nessun Insegnante trovato',
                'not_found_in_trash' => 'Nessun Insegnante trovato nel cestino'
            ]
        ]);

    }


}
