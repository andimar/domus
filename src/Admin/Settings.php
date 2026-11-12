<?php
namespace Domus\Admin;
use Domus\Data\SiteSettings;
final class Settings {
    private const GENERAL_CAPABILITY='domus_manage_settings';
    private const HOURS_CAPABILITY='domus_manage_hours';
    public static function init(): void {
        add_filter('map_meta_cap',static function(array $caps,string $cap,int $userId): array {
            if(!in_array($cap,[self::GENERAL_CAPABILITY,self::HOURS_CAPABILITY],true))return $caps;
            $user=get_userdata($userId);
            $administrator=$user&&in_array('administrator',(array)$user->roles,true);
            if(is_multisite()&&is_super_admin($userId))$administrator=true;
            if($cap===self::HOURS_CAPABILITY){
                $editor=$user&&in_array('editor',(array)$user->roles,true);
                return $administrator?['manage_options']:($editor?['edit_others_posts']:['do_not_allow']);
            }
            return $administrator?['manage_options']:['do_not_allow'];
        },10,3);
        add_filter('option_page_capability_domus_settings',static fn()=>self::GENERAL_CAPABILITY);
        add_filter('option_page_capability_domus_hours',static fn()=>self::HOURS_CAPABILITY);
        add_action('admin_menu',[self::class,'menu']);
        add_action('admin_init',[self::class,'register']);
        add_action('admin_enqueue_scripts',[self::class,'assets']);
    }
    public static function menu(): void {
        add_theme_page('Impostazioni Domus','Domus Medica',self::GENERAL_CAPABILITY,'domus-settings',[self::class,'general']);
        if(current_user_can('edit_theme_options'))add_theme_page('Orari del laboratorio','Orari',self::HOURS_CAPABILITY,'domus-hours',[self::class,'hours']);
        else add_submenu_page('edit.php','Orari del laboratorio','Orari',self::HOURS_CAPABILITY,'domus-hours',[self::class,'hours']);
        add_theme_page('Domande frequenti','FAQ','manage_options','domus-faqs',[self::class,'faqs']);
    }
    public static function register(): void {
        register_setting('domus_settings','domus_site_settings',['type'=>'array','sanitize_callback'=>[self::class,'sanitizeSettings'],'default'=>[]]);
        register_setting('domus_settings','domus_section_images',['type'=>'array','sanitize_callback'=>[self::class,'sanitizeImages'],'default'=>[]]);
        register_setting('domus_settings','domus_rotate_images',['type'=>'boolean','sanitize_callback'=>static fn($v)=>(bool)$v,'default'=>true]);
        register_setting('domus_hours','domus_hours',['type'=>'array','sanitize_callback'=>[self::class,'sanitizeHours'],'default'=>[]]);
        register_setting('domus_faqs','domus_faqs',['type'=>'array','sanitize_callback'=>[self::class,'sanitizeFaqs'],'default'=>SiteSettings::faqDefaults()]);
    }
    public static function sanitizeSettings(mixed $value): array {
        $out=[];$value=is_array($value)?$value:[];
        foreach(SiteSettings::fields() as $key=>$field){$v=$value[$key]??$field[3];if(!is_scalar($v))$v=$field[3];$out[$key]=match($field[2]){'url'=>esc_url_raw((string)$v,['https','http']),'email'=>sanitize_email((string)$v),'textarea'=>sanitize_textarea_field((string)$v),'select'=>array_key_exists((string)$v,$field[4])?(string)$v:$field[3],default=>sanitize_text_field((string)$v)};}
        $out['schema_version']=2;return $out;
    }
    public static function sanitizeImages(mixed $value): array {
        $value=is_array($value)?$value:[];
        $out=[];foreach(['hero','packages','services','visit','hours','faq','contact'] as $key){$ids=is_array($value[$key]??null)?$value[$key]:explode(',',(string)($value[$key]??''));$out[$key]=array_values(array_filter(array_unique(array_map('absint',$ids)),static fn($id)=>wp_attachment_is_image($id)));}return $out;
    }
    public static function sanitizeHours(mixed $value): array {
        $value=is_array($value)?$value:[];$previous=SiteSettings::hours();$out=[];
        foreach($previous as $key=>$fallback){if($key==='saturday_closed'){$out[$key]=!empty($value[$key]);continue;}if($key==='hours_note'){$out[$key]=sanitize_textarea_field($value[$key]??'');continue;}$v=$value[$key]??$fallback;$out[$key]=is_string($v)&&preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/',$v)?$v:$fallback;}
        foreach(['collection_weekdays','collection_saturday','results_morning','results_afternoon'] as $part)if($out[$part.'_open']>=$out[$part.'_close']){add_settings_error('domus_hours','invalid_hours','L’apertura deve precedere la chiusura. Fascia non aggiornata.');$out[$part.'_open']=$previous[$part.'_open'];$out[$part.'_close']=$previous[$part.'_close'];}return $out;
    }
    public static function sanitizeFaqs(mixed $value): array {
        $rows=[];foreach(is_array($value)?$value:[] as $row){if(!is_array($row))continue;$q=sanitize_text_field($row['question']??'');$a=sanitize_textarea_field($row['answer']??'');if($q!==''&&$a!=='')$rows[]=['question'=>$q,'answer'=>$a,'enabled'=>!empty($row['enabled'])];}return array_slice($rows,0,50);
    }
    public static function assets(string $hook): void {
        if(in_array($hook,['post.php','post-new.php'],true)){
            wp_enqueue_style(
                'domus-admin-editor',
                get_template_directory_uri().'/frontend/styles/admin-editor.css',
                [],
                (string)filemtime(get_template_directory().'/frontend/styles/admin-editor.css')
            );
        }
        if(!str_contains($hook,'domus-'))return;wp_enqueue_media();wp_enqueue_script('domus-admin',get_template_directory_uri().'/frontend/scripts/admin.js',[], '1.0.0',true);
    }
    private static function start(string $title,string $group): void {
        $capability=$group==='domus_hours'?self::HOURS_CAPABILITY:'manage_options';
        if(!current_user_can($capability))wp_die('Accesso non consentito.','Accesso non consentito',['response'=>403]);echo '<div class="wrap"><h1>'.esc_html($title).'</h1>';settings_errors();echo '<form action="options.php" method="post">';settings_fields($group);
    }
    private static function end(): void {submit_button('Salva modifiche');echo '</form></div>';}
    public static function general(): void {
        if(!current_user_can(self::GENERAL_CAPABILITY))wp_die('Pagina riservata agli amministratori.','Accesso non consentito',['response'=>403]);
        self::start('Domus Medica: aspetto e contenuti','domus_settings');$values=SiteSettings::all();
        echo '<p>Palette azzurri + oro chiarissimo. Titoli Newsreader, testi e titoli dei pacchetti Source Sans 3, prezzi Georgia. Queste scelte sono fissate. Le anteprime usano i dati salvati.</p><p><a href="'.esc_url(admin_url('themes.php?page=domus-hours')).'">Gestisci gli orari</a> · <a href="'.esc_url(admin_url('themes.php?page=domus-faqs')).'">Gestisci le FAQ</a> · <a href="'.esc_url(admin_url('customize.php')).'">Personalizza i mezzi pubblici</a></p>';
        $presetFile=get_template_directory().'/frontend/assets/copy-presets.json';$presets=is_file($presetFile)?json_decode(file_get_contents($presetFile),true):[];
        if($presets){echo '<h2>Testi di partenza</h2><p>Scegli una proposta del mockup per compilare i campi. Puoi rivederli prima di salvare.</p><select id="domus-copy-preset">';foreach($presets as $key=>$preset)echo '<option value="'.esc_attr($key).'">'.esc_html($preset['label']).'</option>';echo '</select> <button type="button" class="button" data-domus-copy-preset>Applica testi suggeriti al modulo</button><script type="application/json" id="domus-copy-data">'.wp_json_encode($presets,JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT).'</script>';}
        $group='';foreach(SiteSettings::fields() as $key=>$field){if($group!==$field[0]){if($group!=='')echo '</tbody></table>';$group=$field[0];echo '<h2>'.esc_html($group).'</h2><table class="form-table"><tbody>';}
            echo '<tr><th><label for="setting-'.esc_attr($key).'">'.esc_html($field[1]).'</label></th><td>';$name='domus_site_settings['.$key.']';$id='setting-'.$key;
            if($field[2]==='textarea')echo '<textarea id="'.esc_attr($id).'" class="large-text" rows="3" name="'.esc_attr($name).'">'.esc_textarea($values[$key]).'</textarea>';
            elseif($field[2]==='select'){echo '<select id="'.esc_attr($id).'" name="'.esc_attr($name).'">';foreach($field[4] as $option=>$label)echo '<option value="'.esc_attr($option).'" '.selected($values[$key],$option,false).'>'.esc_html($label).'</option>';echo '</select>';}
            else echo '<input id="'.esc_attr($id).'" class="regular-text" type="'.esc_attr($field[2]).'" name="'.esc_attr($name).'" value="'.esc_attr($values[$key]).'">';
            if($key==='footer_login_url')echo '<p class="description">Inserisci l’indirizzo completo della pagina di accesso. Se lasci vuoto viene usata la login WordPress. Il link compare solo scegliendo Mostra nella voce precedente.</p>';
            elseif($field[2]!=='select')echo '<p class="description">Suggerito dal mockup: '.esc_html($field[3]).'</p><button type="button" class="button-link" data-domus-suggest="'.esc_attr($id).'" data-suggestion="'.esc_attr($field[3]).'">Usa il testo suggerito</button>';echo '</td></tr>';
        }echo '</tbody></table><h2>Immagini per sezione</h2><p>Scegli una o più immagini dalla libreria. Con la rotazione attiva cambia l’immagine a ogni nuovo accesso alla home, senza slideshow. Senza immagini selezionate vengono usate le scene illustrative del mockup.</p>';
        $pools=(array)get_option('domus_section_images',[]);foreach(['hero'=>'Apertura','packages'=>'Pacchetti (immagine di sezione facoltativa)','services'=>'Altri servizi (immagine di sezione facoltativa)','visit'=>'La tua visita','hours'=>'Orari (facoltativa)','faq'=>'FAQ (facoltativa)','contact'=>'Contatti'] as $key=>$label){echo '<p><strong>'.esc_html($label).'</strong> <input type="hidden" id="images-'.esc_attr($key).'" name="domus_section_images['.esc_attr($key).']" value="'.esc_attr(implode(',',(array)($pools[$key]??[]))).'"><button type="button" class="button" data-domus-media="images-'.esc_attr($key).'">Scegli immagini</button> <button type="button" class="button-link" data-domus-clear="images-'.esc_attr($key).'">Ripristina immagini suggerite</button> <span id="images-'.esc_attr($key).'-count">'.count((array)($pools[$key]??[])).' selezionate</span></p>';}
        echo '<input type="hidden" name="domus_rotate_images" value="0"><label><input type="checkbox" name="domus_rotate_images" value="1" '.checked((bool)get_option('domus_rotate_images',true),true,false).'> Ruota le immagini a ogni visita</label>';self::end();
    }
    public static function hours(): void {
        self::start('Orari del laboratorio','domus_hours');$hours=SiteSettings::hours();echo '<p>Fuso orario: '.esc_html(wp_timezone_string()).'. Gli avvisi datati attivi vengono messi in evidenza automaticamente in questa sezione della home.</p><table class="form-table"><tbody>';
        foreach(['collection_weekdays'=>'Prelievi lunedì–venerdì','collection_saturday'=>'Prelievi sabato','results_morning'=>'Ritiro referti, mattina lunedì–venerdì','results_afternoon'=>'Ritiro referti, pomeriggio lunedì–venerdì'] as $key=>$label){echo '<tr><th>'.esc_html($label).'</th><td>';foreach(['open'=>'Apertura','close'=>'Chiusura'] as $part=>$text)echo '<label>'.esc_html($text).' <input type="time" required name="domus_hours['.esc_attr($key.'_'.$part).']" value="'.esc_attr($hours[$key.'_'.$part]).'"></label> ';echo '</td></tr>';}
        echo '<tr><th>Sabato</th><td><input type="hidden" name="domus_hours[saturday_closed]" value="0"><label><input type="checkbox" name="domus_hours[saturday_closed]" value="1" '.checked((bool)$hours['saturday_closed'],true,false).'> Prelievi chiusi il sabato</label></td></tr><tr><th><label for="hours-note">Nota aggiuntiva</label></th><td><textarea id="hours-note" class="large-text" rows="3" name="domus_hours[hours_note]">'.esc_textarea($hours['hours_note']).'</textarea></td></tr></tbody></table>';self::end();
    }
    public static function faqs(): void {
        self::start('Domande frequenti','domus_faqs');$rows=(array)get_option('domus_faqs',SiteSettings::faqDefaults());echo '<p>Le prime voci suggeriscono i testi del mockup. Modifica le risposte, aggiungi o rimuovi voci, usa le frecce per ordinarle. Le voci disattivate restano salvate.</p><div data-domus-faq-list>';
        foreach($rows as $i=>$row)self::faqRow((string)$i,$row);echo '</div><template id="domus-faq-template">';self::faqRow('__INDEX__',['question'=>'','answer'=>'','enabled'=>true]);echo '</template><p><button type="button" class="button" data-domus-faq-add>Aggiungi domanda</button></p>';self::end();
    }
    private static function faqRow(string $i,array $row): void {
        echo '<fieldset data-domus-faq-row style="padding:16px;margin:16px 0;border:1px solid #c3c4c7;max-width:850px"><legend>Domanda frequente</legend><label>Domanda <input class="large-text" name="domus_faqs['.esc_attr($i).'][question]" value="'.esc_attr($row['question']??'').'"></label><p><label>Risposta <textarea class="large-text" rows="3" name="domus_faqs['.esc_attr($i).'][answer]">'.esc_textarea($row['answer']??'').'</textarea></label></p><input type="hidden" name="domus_faqs['.esc_attr($i).'][enabled]" value="0"><label><input type="checkbox" name="domus_faqs['.esc_attr($i).'][enabled]" value="1" '.checked(!empty($row['enabled']),true,false).'> Visibile</label> <button type="button" class="button" data-faq-up aria-label="Sposta domanda in alto">↑</button> <button type="button" class="button" data-faq-down aria-label="Sposta domanda in basso">↓</button> <button type="button" class="button-link-delete" data-faq-remove>Rimuovi domanda</button></fieldset>';
    }
}
