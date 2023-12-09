<?php

namespace THEME\CustomTaxonomies;

class Attivita {

    static function init() {

        // Add the custom columns to the posts post type:
        add_action( 'init',    [ get_called_class(), 'add_taxonomy'], 1 );
    }

    /**
     * registra il post-type per le tabelle
     *
     * @return void
     */
    static function add_taxonomy() {

        $labels = [
            'name'              => 'attivita',
            'singular_name'     => 'Attivita',
            'search_items'      => 'Cerca attivita',
            'all_items'         => 'Tutte le attività',
            'edit_item'         => 'Modifica attività', 
            'update_item'       => 'Aggiorna attività',
            'add_new_item'      => 'Aggiungi attività',
            'new_item_name'     => 'Nuova attività',
            'menu_name'         => 'Attività',
        ]; 

        $args = [
            'labels'            => $labels,
            'public'            =>  true,
            'hierarchical'      =>  true,
            'show_in_nav_menus' =>  true,
            'has_archive'       =>  true,
            'rewrite'           =>  [ 'slug' => 'attivita', 'with_front' => true],
        ];

        register_taxonomy( 'attivita', 'iniziativa', $args );

        add_rewrite_rule( 'attivita/?$', 'index.php?post_type=iniziativa', 'top' );
        add_rewrite_rule( 'attivita/page/(\d+)/?$', 'index.php?post_type=iniziativa&paged=$matches[1]', 'top' );
    }
}
