<?php
namespace Domus\ThemeSetup;
final class Support {
    public static function init(): void {
        add_action('after_setup_theme', static function (): void {
            load_theme_textdomain('domus-medica', get_template_directory() . '/languages');
            add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
            add_theme_support('custom-logo');
            add_theme_support('automatic-feed-links');
            add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
            register_nav_menus(['primary' => 'Menu principale', 'secondary' => 'Menu secondario']);
        });
    }
}
