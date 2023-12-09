<?php

namespace THEME\AdminUserInterface;

class AddMagazinePageToMenu {

    function __construct() {

        add_action('admin_menu', [ $this, 'addPageToMenu' ]);    

    }

    function addPageToMenu() {

        $magazine_page = get_posts([ 'post_type' => 'page', 'name' => 'sati']);

        if( empty( $magazine_page ) ) return;

        // Ottiene l'ID della pagina home
        $magazine_page_id = array_shift( $magazine_page )->ID;
    
        // Crea l'URL per l'editor della pagina
        $url_editor_pagina = admin_url('post.php?post=' . $magazine_page_id . '&action=edit');
    
        // Aggiungi una nuova voce al menu del backend          
        add_submenu_page( 'edit.php?post_type=riviste', 'Contenuti archivio Sati', 'Pagina Sati', 'edit_pages',  $url_editor_pagina, '', 99);
        add_menu_page('Contenuti archivio Sati', 'SATI PAGE', 'edit_pages', $url_editor_pagina, '', 'dashicons-book', 21);
    }
    

}
