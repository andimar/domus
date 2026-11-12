<?php
namespace Domus\ThemeSetup;

final class Login {
    public static function init(): void {
        add_action('login_enqueue_scripts',static function(): void {
            $file='/frontend/styles/login.css';
            wp_enqueue_style('domus-login',get_template_directory_uri().$file,[],(string)filemtime(get_template_directory().$file));
        });
        add_filter('login_headerurl',static fn()=>home_url('/'));
        add_filter('login_headertext',static fn()=>get_bloginfo('name'));
    }
}
