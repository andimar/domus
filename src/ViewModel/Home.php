<?php
namespace Domus\ViewModel;
use Domus\Data\LegacySettings;
use Domus\Data\Posts;
use Domus\ViewModel\Common\HasComponents;
final class Home {
    use HasComponents;
    public function __construct() {
        $settings=(new LegacySettings())->all();
        $value=static fn(string $key, mixed $default=''): mixed => $settings[$key] ?? $default;
        $header=(array)($settings['header_image_data'] ?? []);
        $imageId=(int)($header['attachment_id'] ?? 0);
        $this->context=[
            'page'=>['type'=>'home','title'=>html_entity_decode(wp_get_document_title(), ENT_QUOTES | ENT_HTML5, 'UTF-8')],
            'site'=>['name'=>get_bloginfo('name'),'url'=>home_url('/'),'language'=>get_bloginfo('language')],
            'body_classes'=>implode(' ',get_body_class()),
            'branding'=>['title'=>$value('regina_lite_text_logo',get_bloginfo('name')),'logo_url'=>esc_url($value('regina_lite_img_logo')),'phone'=>$value('regina_lite_phone'),'email'=>$value('regina_lite_email'),'facebook_url'=>esc_url($value('regina_lite_contact_bar_facebook_url'))],
            'navigation'=>$this->menu((int)($settings['nav_menu_locations']['primary'] ?? 0)),
            'home'=>[
                'hero'=>['url'=>esc_url($value('header_image')),'alt'=>$imageId ? get_post_meta($imageId,'_wp_attachment_image_alt',true) : ''],
                'intro'=>['visible'=>(bool)$value('regina_lite_subheader_features_show',1),'title'=>$value('regina_lite_top_box_title'),'description_html'=>wp_kses_post($value('regina_lite_top_box_description'))],
                'news'=>['visible'=>(bool)$value('regina_lite_news_general_show',1) && (bool)$value('regina_lite_latest_news_show',1),'title'=>$value('regina_lite_news_section_title'),'subtitle'=>$value('regina_lite_news_section_sub_title'),'items'=>(new Posts())->latest((int)get_option('posts_per_page',10))],
                'hours'=>['visible'=>(bool)$value('regina_lite_subheader_features_show',1),'title'=>$value('regina_lite_features_general_title'),'collection_title'=>$value('regina_lite_features_feature1_title'),'results_title'=>$value('regina_lite_features_feature2_title'),'results_description_html'=>wp_kses_post($value('regina_lite_features_feature2_description')),'collection'=>[
                    ['label'=>'Lun - Ven','open'=>$value('regina_lite_features_open_hour_weekdays'),'close'=>$value('regina_lite_features_close_hour_weekdays')],
                    ['label'=>'Sabato','open'=>$value('regina_lite_features_open_hour_saturday'),'close'=>$value('regina_lite_features_close_hour_saturday')],
                ],'results'=>[['label'=>'Mattina','open'=>'10:00','close'=>'14:00'],['label'=>'Pomeriggio','open'=>'15:00','close'=>'17:00']]],
                'location'=>['visible'=>(bool)$value('regina_lite_map_general_show',1),'html'=>shortcode_exists('domus_map') ? do_shortcode('[domus_map height="360px"]') : '<p>Via dei Castani, 170, Roma</p>'],
            ],
            'footer'=>$this->footer(),
        ];
        // Shortcode e dati raccolti prima degli hook: gli asset accodati compaiono in wp_head/footer.
        $this->loadComponents([Common\Components\WordPressHooks::class]);
    }
    private function menu(int $id): array {
        return array_map(static fn($item): array=>['title'=>html_entity_decode($item->title, ENT_QUOTES | ENT_HTML5, 'UTF-8'),'url'=>esc_url($item->url),'parent'=>(int)$item->menu_item_parent],wp_get_nav_menu_items($id)?:[]);
    }
    private function footer(): array {
        $settings=(new LegacySettings())->all();
        return [
            'company'=>['name'=>'DOMUS MEDICA Srl','vat'=>'01315941003'],
            'contacts'=>['phone'=>$settings['regina_lite_phone']??'','email'=>$settings['regina_lite_email']??'','facebook_url'=>esc_url($settings['regina_lite_contact_bar_facebook_url']??'')],
            'address'=>['name'=>'Domus Medica','street'=>'Via dei Castani, 170','city'=>'00172 - Roma'],
            'links'=>[
                ['title'=>'Accedi','url'=>esc_url(wp_login_url())],
                ['title'=>'Feed dei contenuti','url'=>esc_url(get_feed_link())],
                ['title'=>'WordPress.org','url'=>'https://it.wordpress.org/'],
            ],
        ];
    }
}
