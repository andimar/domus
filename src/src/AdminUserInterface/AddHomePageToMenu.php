<?php

namespace THEME\AdminUserInterface;

class AddHomePageToMenu
{

    function __construct() {

        add_action('admin_menu', [ $this, 'addFrontPageToMenu' ]);    

    }

    function addFrontPageToMenu() {

        // Ottiene l'ID della pagina home
        $front_page_id = get_option('page_on_front');
    
        // Crea l'URL per l'editor della pagina
        $url_editor_pagina = admin_url('post.php?post=' . $front_page_id . '&action=edit');
    
        // Aggiungi una nuova voce al menu del backend
        add_submenu_page( 'themes.php', 'Impostazioni Home page', 'HOME PAGE', 'edit_pages',  $url_editor_pagina, '', 99);
        add_menu_page('Impostazioni Home Page', 'HOME PAGE', 'edit_pages', $url_editor_pagina, '', 'dashicons-admin-home', 20);
    }
    

}
