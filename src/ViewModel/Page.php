<?php
namespace Domus\ViewModel;
use Domus\ViewModel\Common\HasComponents;
final class Page {
    use HasComponents;
    public function __construct(string $type) {
        $this->context = [
            'page' => ['type' => $type, 'title' => is_404() ? 'Pagina non trovata' : html_entity_decode(wp_get_document_title(), ENT_QUOTES | ENT_HTML5, 'UTF-8')],
            'site' => ['name' => get_bloginfo('name'), 'url' => home_url('/'), 'language' => get_bloginfo('language')],
            'posts' => (new \Domus\Data\Posts())->currentQuery(),
            'pagination_html' => get_the_posts_pagination(),
        ];
        $settings = (new \Domus\Data\LegacySettings())->all();
        $this->context['branding'] = ['title'=>$settings['regina_lite_text_logo']??get_bloginfo('name'),'logo_url'=>esc_url($settings['regina_lite_img_logo']??''),'phone'=>$settings['regina_lite_phone']??'','email'=>$settings['regina_lite_email']??'','facebook_url'=>esc_url($settings['regina_lite_contact_bar_facebook_url']??'')];
        $this->context['navigation'] = array_map(static fn($item): array=>['title'=>html_entity_decode($item->title, ENT_QUOTES | ENT_HTML5, 'UTF-8'),'url'=>esc_url(str_starts_with($item->url, '#') ? home_url('/').$item->url : $item->url)],wp_get_nav_menu_items((int)($settings['nav_menu_locations']['primary']??0))?:[]);
        $this->context['footer'] = ['company'=>['name'=>'DOMUS MEDICA Srl','vat'=>'01315941003'],'contacts'=>$this->context['branding'],'address'=>['name'=>'Domus Medica','street'=>'Via dei Castani, 170','city'=>'00172 - Roma'],'links'=>[['title'=>'Accedi','url'=>wp_login_url()],['title'=>'Feed dei contenuti','url'=>get_feed_link()],['title'=>'WordPress.org','url'=>'https://it.wordpress.org/']]];
        $this->context['body_classes'] = implode(' ',get_body_class());
        $this->context['page']['heading'] = is_search() ? 'Risultati per: '.get_search_query(false) : (is_archive() ? html_entity_decode(wp_strip_all_tags(get_the_archive_title()), ENT_QUOTES | ENT_HTML5, 'UTF-8') : 'Articoli');
        $this->context['related'] = is_singular('post') ? (new \Domus\Data\Posts())->related((int)get_queried_object_id()) : [];
        $this->loadComponents([Common\Components\WordPressHooks::class]);
    }
}
