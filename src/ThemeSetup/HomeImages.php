<?php
namespace Domus\ThemeSetup;

final class HomeImages {
    public static function init(): void {
        add_action('customize_register',[self::class,'customize']);
        add_action('customize_controls_enqueue_scripts',static function(): void {
            wp_enqueue_media();
            $path='/frontend/scripts/customizer-images.js';
            wp_enqueue_script('domus-customizer-images',get_template_directory_uri().$path,['customize-controls','media-views'],(string)filemtime(get_template_directory().$path),true);
        });
    }
    public static function sanitize(mixed $value): array {
        if(!is_array($value))return [];
        return array_values(array_filter(array_unique(array_map('absint',$value)),static fn($id)=>wp_attachment_is_image($id)));
    }
    public static function customize(\WP_Customize_Manager $wp): void {
        require_once __DIR__.'/ImagePoolControl.php';
        $wp->add_section('domus_home_images',['title'=>'Immagini della home','priority'=>34,'description'=>'Scegli una o più immagini per sezione. Con la rotazione attiva cambia l’immagine a ogni visita, senza slideshow. Le selezioni sono condivise con Aspetto → Domus Medica.']);
        foreach(['hero'=>'Apertura','packages'=>'Pacchetti','services'=>'Altri servizi','visit'=>'La tua visita','hours'=>'Orari','faq'=>'FAQ','contact'=>'Contatti'] as $key=>$label){
            $id='domus_section_images['.$key.']';
            $wp->add_setting($id,['type'=>'option','capability'=>'manage_options','default'=>[],'sanitize_callback'=>[self::class,'sanitize'],'transport'=>'refresh']);
            $wp->add_control(new ImagePoolControl($wp,$id,['section'=>'domus_home_images','label'=>$label,'description'=>in_array($key,['hero','visit','contact'],true)?'Senza selezioni vengono usate le immagini suggerite del mockup.':'Immagine di sezione facoltativa. Senza selezioni la foto non viene mostrata.']));
        }
        $wp->add_setting('domus_rotate_images',['type'=>'option','capability'=>'manage_options','default'=>true,'sanitize_callback'=>static fn($value)=>(bool)$value]);
        $wp->add_control('domus_rotate_images',['section'=>'domus_home_images','type'=>'checkbox','label'=>'Ruota le immagini a ogni visita','description'=>'Con più immagini usa l’ordine scelto. Con una sola immagine la foto resta fissa.']);
    }
}
