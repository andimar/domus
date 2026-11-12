<?php
namespace Domus\ThemeSetup;

final class TopBar {
    public static function init(): void {
        add_action('customize_register',static function(\WP_Customize_Manager $wp): void {
            $wp->add_section('domus_top_bar',['title'=>'Barra superiore','priority'=>30,'description'=>'La riga con posizione, telefono ed email sopra il logo e il menu.']);
            $wp->add_setting('domus_top_bar_style',['default'=>'light','sanitize_callback'=>[self::class,'sanitize'],'transport'=>'refresh']);
            $wp->add_control('domus_top_bar_style',['section'=>'domus_top_bar','type'=>'radio','label'=>'Colore della barra','choices'=>['light'=>'Azzurro chiarissimo · attuale','dark'=>'Blu scurissimo · come il footer, testi chiari','gold'=>'Oro chiarissimo · come le FAQ']]);
        });
    }
    public static function sanitize(mixed $value): string {
        return in_array($value,['light','dark','gold'],true)?$value:'light';
    }
    public static function value(): string {
        return self::sanitize(get_theme_mod('domus_top_bar_style','light'));
    }
}
