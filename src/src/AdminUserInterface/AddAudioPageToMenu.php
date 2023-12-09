<?php

namespace THEME\AdminUserInterface;

class AddAudioPageToMenu {

    function __construct() {

        add_action('admin_menu', [ $this, 'addPageToMenu' ]);    

    }

    function addPageToMenu() {

        $audio_page = get_posts([ 'post_type' => 'page', 'name' => 'audio-content']);

        if( empty( $audio_page ) ) return;

        // Ottiene l'ID della pagina home
        $audio_page_id = array_shift( $audio_page )->ID;
    
        // Crea l'URL per l'editor della pagina
        $url_editor_pagina = admin_url('post.php?post=' . $audio_page_id . '&action=edit');
    
        // Aggiungi una nuova voce al menu del backend
        add_submenu_page( 'edit.php?post_type=audio', 'Contenuti archivio Audio', 'Pagina Audio', 'edit_pages',  $url_editor_pagina, '', 99);
        add_menu_page('Contenuti archivio audio', 'AUDIO PAGE', 'edit_pages', $url_editor_pagina, '', 'dashicons-format-audio', 21);
    }
    

}
