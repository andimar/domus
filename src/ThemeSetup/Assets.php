<?php
namespace Domus\ThemeSetup;
final class Assets {
    public static function init(): void {
        add_action('wp_enqueue_scripts', static function (): void {
            $base=get_template_directory_uri().'/frontend';
            $files=['styles.css','themes.css','alternative-20261024/round2.css','alternative-20261024/obliqua/layout.css','alternative-20261024/typography.css','alternative-20261024/structure.css','alternative-20261024/round4.css','alternative-20261024/round5.css','alternative-20261024/contacts.css','alternative-20261024/palettes.css','alternative-20261024/font-study.css','alternative-20261024/vicina/layout.css'];
            $previous=[];foreach($files as $i=>$file){$handle='domus-design-'.$i;wp_enqueue_style($handle,$base.'/assets/prototype/'.$file,$previous,(string)filemtime(get_template_directory().'/frontend/assets/prototype/'.$file));$previous=[$handle];}
            wp_enqueue_style('domus',$base.'/styles/website.css',$previous,(string)filemtime(get_template_directory().'/frontend/styles/website.css'));
            wp_enqueue_script('domus',$base.'/scripts/main.js',[],(string)filemtime(get_template_directory().'/frontend/scripts/main.js'),true);
        });
    }
}
