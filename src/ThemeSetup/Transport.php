<?php
namespace Domus\ThemeSetup;
final class Transport {
    public static function init(): void {add_action('customize_register',[self::class,'customize']);}
    public static function defaults(): array {
        $file=get_template_directory().'/frontend/assets/transport.json';return is_file($file)?(json_decode(file_get_contents($file),true)?:[]):[];
    }
    public static function sanitizeLines(mixed $value): string {
        $out=[];foreach(explode("\n",is_scalar($value)?(string)$value:'') as $line){$parts=explode('|',$line,2);if(count($parts)!==2)continue;$label=sanitize_text_field(trim($parts[0]));$url=esc_url_raw(trim($parts[1]),['https','http']);if($label!==''&&$url!=='')$out[]=$label.' | '.$url;}return implode("\n",$out);
    }
    public static function customize(\WP_Customize_Manager $wp): void {
        $wp->add_section('domus_transport',['title'=>'Mezzi pubblici','priority'=>35,'description'=>'Collegamenti mostrati nei contatti, sotto Il tuo itinerario. Un link distinto per ogni linea.']);
        foreach(['show'=>'Mostra mezzi pubblici','metro'=>'Mostra metro','tram'=>'Mostra tram e sostitutivi','bus'=>'Mostra bus'] as $key=>$label){$id='domus_transport_'.$key;$wp->add_setting($id,['default'=>true,'sanitize_callback'=>static fn($v)=>(bool)$v]);$wp->add_control($id,['section'=>'domus_transport','type'=>'checkbox','label'=>$label]);}
        foreach(['title'=>['Titolo sezione','Con i mezzi pubblici.'],'stops'=>['Fermate metro','Gardenie / Mirti'],'area'=>['Descrizione area','Linee nell’area Castani, Gardenie e Mirti'],'note'=>['Nota di servizio','Verifica il servizio e le deviazioni prima di partire.'],'alert_url'=>['Link avvisi del gestore','https://www.atac.roma.it/tempo-reale/rete-tram--stato-del-servizio-aggiornato----tutte-le-info']] as $key=>$field){$id='domus_transport_'.$key;$wp->add_setting($id,['default'=>$field[1],'sanitize_callback'=>$key==='alert_url'?'esc_url_raw':'sanitize_text_field']);$wp->add_control($id,['section'=>'domus_transport','label'=>$field[0],'type'=>$key==='alert_url'?'url':'text']);}
        foreach(self::defaults() as $i=>$group){$key=['metro','tram','bus'][$i]??'bus';$default=implode("\n",array_map(static fn($l)=>$l['label'].' | '.$l['href'],$group['lines']));$id='domus_transport_lines_'.$key;$wp->add_setting($id,['default'=>$default,'sanitize_callback'=>[self::class,'sanitizeLines']]);$wp->add_control($id,['section'=>'domus_transport','type'=>'textarea','label'=>$group['label'],'description'=>'Una linea per riga: numero o nome | URL completo. Per eliminare una linea, rimuovi la riga.']);}
    }
    public static function data(): array {
        $groups=[];foreach(self::defaults() as $i=>$group){$key=['metro','tram','bus'][$i]??'bus';if(!get_theme_mod('domus_transport_'.$key,true))continue;$fallback=implode("\n",array_map(static fn($l)=>$l['label'].' | '.$l['href'],$group['lines']));$lines=[];foreach(explode("\n",self::sanitizeLines(get_theme_mod('domus_transport_lines_'.$key,$fallback))) as $line){$parts=explode('|',$line,2);if(count($parts)===2)$lines[]=['label'=>trim($parts[0]),'href'=>trim($parts[1])];}if($lines)$groups[]=['label'=>$group['label'],'lines'=>$lines,'note'=>$key==='metro'?get_theme_mod('domus_transport_stops','Gardenie / Mirti'):($key==='tram'?'Consulta le sostituzioni e gli avvisi di servizio.':'')];}
        return ['visible'=>(bool)get_theme_mod('domus_transport_show',true),'title'=>get_theme_mod('domus_transport_title','Con i mezzi pubblici.'),'area'=>get_theme_mod('domus_transport_area','Linee nell’area Castani, Gardenie e Mirti'),'groups'=>$groups,'note'=>get_theme_mod('domus_transport_note','Verifica il servizio e le deviazioni prima di partire.'),'alert_url'=>get_theme_mod('domus_transport_alert_url','https://www.atac.roma.it/tempo-reale/rete-tram--stato-del-servizio-aggiornato----tutte-le-info')];
    }
}
