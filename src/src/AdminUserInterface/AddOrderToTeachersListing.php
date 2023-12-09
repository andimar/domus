<?php

namespace THEME\AdminUserInterface;

class AddOrderToTeachersListing {


    function __construct() {

        add_filter('manage_insegnanti_posts_columns',         [ $this, 'addOrderColumn'      ] );
        add_action('manage_insegnanti_posts_custom_column',   [ $this, 'showOrderColumn'     ], 10, 2);
        add_filter('manage_edit-insegnanti_sortable_columns', [ $this, 'enableSortByOrder'   ] );
        add_action('quick_edit_custom_box',                   [ $this, 'addOrderToQuickEdit' ], 10, 2);
        add_action('save_post',                               [ $this, 'saveQuickEditOrder'  ] );

        add_action('pre_get_posts',                           [ $this, 'orderby_order_column_in_admin' ]);

        
    }

    // Aggiungi una nuova colonna
    function addOrderColumn($columns) {

        $new_columns = [];

        foreach ($columns as $key => $title) {
            // Aggiungi la nuova colonna prima della colonna 'date'
            if ($key == 'date') {
                $new_columns['order'] = 'Ordine';
            }
    
            $new_columns[$key] = $title;
        }
    
        return $new_columns;        
    }


    function orderby_order_column_in_admin($query) {
        if (!is_admin()) {
            return;
        }
    
        $orderby = $query->get('orderby');
    
        if ('order' == $orderby) {
            $query->set('meta_key', 'order');
            $query->set('orderby', 'meta_value_num');
        }
    }
    
    


    // Popola la colonna
    function showOrderColumn($column, $post_id) {
        
        if ('order' === $column) {
            $order = get_post_meta( $post_id, 'order', true );
            echo $order;
        }
    }

    
    // Rendi la colonna "Ordine" ordinabile
    function enableSortByOrder($columns) {
        $columns['order'] = 'order';
        return $columns;
    }


    function saveQuickEditOrder( $post_id ) {
        
        if (isset($_REQUEST['order'])) {
            
            update_post_meta( $post_id, 'order', sanitize_text_field($_REQUEST['order']));
        }
    }

    function addOrderToQuickEdit( $column_name, $post_type ) {

        if ($column_name == 'order') { 
            ?>
            <fieldset class="inline-edit-col-right">
                <div class="inline-edit-col">
                    <label>
                        <span class="title">Ordine</span>
                        <span>
                            <input type="number" name="order" value="">
                        </span>
                    </label>
                </div>
            </fieldset>
            <script>
                function getFirstParent( element, tagName ) {

                    if( element.tagName === 'BODY'  ) return null;
                    if( element.tagName === tagName ) return element;
                    else return getFirstParent( element.parentElement, tagName );
                }

                [].forEach.call( document.querySelectorAll('.editinline'), quickEditButton => quickEditButton.addEventListener('click', evt => {

                    let row = getFirstParent( evt.target, 'TR');

                    let post_id = row.id.replace('post-','');
                    
                    let value = row.querySelector( `.order` ).textContent.trim();

                    document.querySelector( `.inline-edit-col input[name="order"]`).value = value;
                }));                
            </script>
            <?php
        }
    }
    
    



}
