<?php

namespace THEME\AdminUserInterface;

class AddCodeToAudioListing {

    function __construct() {

        add_filter('manage_audio_posts_columns',         [ $this, 'addCodeColumn'      ] );
        add_action('manage_audio_posts_custom_column',   [ $this, 'showCodeColumn'     ], 10, 2);
        add_filter('manage_edit-audio_sortable_columns', [ $this, 'enableSortByCode'   ] );
    
        

        //add_action('pre_get_posts',                           [ $this, 'orderby_order_column_in_admin' ]);

        
    }

    // Aggiungi una nuova colonna
    function addCodeColumn($columns) {
        
        $new_columns = [];

        foreach ($columns as $key => $title) {
            // Aggiungi la nuova colonna prima della colonna 'date'
            if ($key == 'date') {
                $new_columns['codice'] = 'Codice';
            }
    
            $new_columns[$key] = $title;
        }
    
        return $new_columns;        
    }


    function orderby_code_column_in_admin($query) {
        if (!is_admin()) {
            return;
        }
    
        $orderby = $query->get('orderby');
    
        if ('codice' == $orderby) {
            $query->set('meta_key', 'codice');
            $query->set('orderby', 'meta_value_num');
        }
    }
    
    


    // Popola la colonna
    function showCodeColumn($column, $post_id) {
        if ('codice' === $column) {
            $code = get_post_meta( $post_id, 'codice', true );
            echo $code;
        }
    }

    
    // Rendi la colonna "Ordine" ordinabile
    function enableSortByCode($columns) {
        $columns['codice'] = 'codice';
        return $columns;
    }





}
