<?php
namespace Domus\ViewModel;
use Domus\Data\SiteSettings;
use Domus\Data\Catalog;
use Domus\ViewModel\Common\HasComponents;
final class Website {
    use HasComponents;
    public function __construct(string $type='home') {
        $settings=SiteSettings::all();$layout=$settings['layout'];
        if((getenv('DOMUS_THEME_PREVIEW')==='1'||current_user_can('edit_theme_options'))&&isset($_GET['domus_layout'])&&in_array($_GET['domus_layout'],['base','obliqua','vicina'],true))$layout=sanitize_key($_GET['domus_layout']);
        $base=get_template_directory_uri().'/frontend';$hours=SiteSettings::hours();$packages=Catalog::items('post');$services=Catalog::items('altri-servizi');$notices=Catalog::items('avvisi');
        $active=array_values(array_filter($notices,static fn($n)=>$n['is_active']));$hoursNotices=array_values(array_filter($active,static fn($n)=>$n['start']||$n['end']));
        $pools=[];foreach(['hero','packages','services','visit','hours','faq','contact'] as $section)$pools[$section]=SiteSettings::images($section);
        $settings['phone_href']='tel:'.preg_replace('/[^+\d]/','',$settings['phone']);$settings['email_href']='mailto:'.$settings['email'];
        $settings['footer_login_url']=$settings['footer_login_url']?:wp_login_url();
        $destination=$settings['address'].', '.$settings['postcode'].' '.$settings['city'].', Italia';
        $nav=[];$locations=get_nav_menu_locations();$menu=wp_get_nav_menu_items((int)($locations['primary']??0))?:[];
        foreach($menu as $entry){if($entry->menu_item_parent)continue;$url=$entry->url;$label=html_entity_decode($entry->title,ENT_QUOTES|ENT_HTML5,'UTF-8');$fragment=wp_parse_url($url,PHP_URL_FRAGMENT);if(in_array($fragment,['news','offerte'],true)){$url=home_url('/#pacchetti');$label='Pacchetti e analisi';}elseif(in_array($fragment,['home-features','features'],true))$url=home_url('/#orari');elseif(in_array($fragment,['map','dove-siamo','home-map'],true))$url=home_url('/#contatti');$nav[]=['title'=>$label,'url'=>$url];}
        if(!$nav)$nav=[['title'=>'Pacchetti e analisi','url'=>home_url('/#pacchetti')],['title'=>'Orari','url'=>home_url('/#orari')],['title'=>'Contatti','url'=>home_url('/#contatti')]];
        if($services&&!array_filter($nav,static fn($i)=>str_contains($i['url'],'#altri-servizi')))array_splice($nav,1,0,[['title'=>'Altri servizi','url'=>home_url('/#altri-servizi')]]);
        $map=shortcode_exists('domus_map')?do_shortcode('[domus_map height="360px"]'):'<a class="map-fallback" href="https://www.openstreetmap.org/?mlat=41.8863007&amp;mlon=12.5662862#map=17/41.8863/12.5663" target="_blank" rel="noopener">Apri la mappa su OpenStreetMap</a>';
        $current=is_singular()?get_queried_object():null;$current=$current instanceof \WP_Post?Catalog::item($current):null;
        $listing=[];if(in_array($type,['archive','search'],true)){global $wp_query;$listing=array_map([Catalog::class,'item'],array_filter($wp_query->posts??[],static fn($p)=>$p instanceof \WP_Post));}
        $this->context=['site'=>['url'=>home_url('/'),'name'=>get_bloginfo('name'),'language'=>get_bloginfo('language')],'settings'=>$settings,'layout'=>$layout,'assets'=>['base'=>$base,'logo'=>get_theme_mod('custom_logo')?wp_get_attachment_image_url(get_theme_mod('custom_logo'),'full'):$base.'/assets/prototype/assets/brand/logo-tradizionale-esteso.svg','logo_light'=>$base.'/assets/prototype/alternative-20261024/assets/logo-chiaro.svg'],'navigation'=>$nav,'body_classes'=>implode(' ',get_body_class()),'package_categories'=>array_values(array_reduce($packages,static function($all,$item){foreach($item['categories'] as $category)$all[$category['slug']]=$category;return $all;},[])),'packages'=>$packages,'services'=>$services,'notices'=>$notices,'active_notices'=>$active,'hours_notices'=>$hoursNotices,'notice'=>$active[0]??null,'active_count'=>count($active),'hours'=>$hours,'faqs'=>SiteSettings::faqs(),'images'=>$pools,'map_html'=>$map,'maps_url'=>'https://www.google.com/maps/dir/?api=1&destination='.rawurlencode($destination).'&travelmode=transit','transport'=>\Domus\ThemeSetup\Transport::data(),'page'=>['type'=>$type,'title'=>wp_get_document_title(),'heading'=>is_search()?'Risultati per: '.get_search_query(false):(is_post_type_archive()?post_type_archive_title('',false):'Pacchetti e analisi')],'current'=>$current,'listing'=>$listing,'pagination_html'=>get_the_posts_pagination(),'year'=>wp_date('Y'),'privacy_url'=>get_privacy_policy_url(),'can_edit'=>current_user_can('edit_theme_options')];
        $this->context['page']['heading']=\Domus\ThemeSetup\Seo::heading();
        $this->context['photo_data_json']=wp_json_encode(['rotate'=>(bool)get_option('domus_rotate_images',true),'pools'=>$pools],JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT);
        $this->context['notices_url']=get_post_type_archive_link('avvisi')?:home_url('/#orari');
        $this->context['top_bar_style']=\Domus\ThemeSetup\TopBar::value();
        $this->context['related_packages']=Catalog::related($current,$packages);
        $this->loadComponents([Common\Components\WordPressHooks::class]);
    }
}
