<?php

namespace THEME\CustomTaxonomies;

class Speaker {

    static function init() {

        // Add the custom columns to the posts post type:
        add_action( 'init',      [ get_called_class(), 'add_taxonomy'   ], 1 );
        add_filter( 'term_link', [ get_called_class(), 'filter_speakers'], 10, 3 );

        add_action( 'restrict_manage_posts', [ get_called_class(), 'addSpeakersFilter'] );
    } 

    /**
     * registra il post-type per le tabelle
     *
     * @return void
     */
    static function add_taxonomy() {

        $labels = [
            'name'              => 'conduttori',
            'singular_name'     => 'Conduttore',
            'search_items'      => 'Cerca Conduttore',
            'all_items'         => 'Tutte i Conduttori',
            'edit_item'         => 'Modifica Conduttore', 
            'update_item'       => 'Aggiorna Conduttore',
            'add_new_item'      => 'Aggiungi Conduttore',
            'new_item_name'     => 'Nuovo Conduttore',
            'menu_name'         => 'Conduttori',
        ]; 

        $args = [
            'labels'            => $labels,
            'public'            =>  true,
            'hierarchical'      =>  true,
            'show_in_nav_menus' =>  true,
            'show_admin_column' =>  true,
            'has_archive'       =>  true,
            'rewrite'           =>  [ 'slug' => 'conduttori', 'with_front' => true],
        ];

        register_taxonomy( 'conduttori', ['iniziativa', 'audio', 'insegnanti'], $args );


        $speakers = implode('|',get_terms(['taxonomy' => 'conduttori', 'fields' => 'slugs']));

        add_rewrite_rule( "audio/($speakers)/?$", 'index.php?post_type=audio&conduttori=$matches[1]', 'top' );
        add_rewrite_rule( "audio/($speakers)/page/(\d+)/?$", 'index.php?post_type=audio&conduttori=$matches[1]&paged=$matches[2]', 'top' );
    }

    
    static function filter_speakers( string $termlink,  $term, string $taxonomy ) {

        if( $taxonomy == 'conduttori' )  {

           $termlink = str_replace('conduttori/', 'audio/', $termlink);

        }

        return $termlink;
    }


    static function addSpeakersFilter( $post_type ) {
    
        if (in_array( $post_type,  [ 'insegnanti', 'audio']))  {

            $taxonomy = 'conduttori';
           
            $selected = isset( $_GET[$taxonomy]) ? $_GET[$taxonomy] : '';

            $info_taxonomy = get_taxonomy( $taxonomy );

            wp_dropdown_categories([

                'show_option_all' => __("Mostra tutti i {$info_taxonomy->label}"),
                'taxonomy'        => $taxonomy,
                'name'            => $taxonomy,
                'orderby'         => 'name',
                'value_field'     =>  'slug',
                'selected'        => $selected,
                'show_count'      => true,
                'hide_empty'      => true,
            ]);
        };
    }
    


}
