<?php
namespace Domus\ThemeSetup;

use Domus\Data\Catalog;
use Domus\Data\SiteSettings;

/** Metadata rendered on the server. Yoast retains ownership when present. */
final class Seo {
    public static function init(): void {
        add_action('wp', static function (): void {
            if (!self::externalProvider()) remove_action('wp_head', 'rel_canonical');
        });
        add_action('wp_head', [self::class, 'head'], 5);
        add_filter('pre_get_document_title', static fn($title) => self::externalProvider() ? $title : self::title(), 20);
        add_filter('wp_robots', [self::class, 'robots']);
        add_filter('wpseo_robots_array', static function ($robots) {
            if (self::excluded()) $robots['index'] = 'noindex';
            if (self::nonProduction()) $robots['follow'] = 'nofollow';
            return $robots;
        });
        add_action('send_headers', static function (): void {
            if (self::nonProduction()) header('X-Robots-Tag: noindex, nofollow', true);
        });
        add_filter('robots_txt', static fn($text) => self::nonProduction() ? "User-agent: *\nDisallow: /\n" : $text, 99);
        add_filter('wp_sitemaps_add_provider', static fn($provider, $name) => $name === 'users' ? false : $provider, 10, 2);
        add_filter('wp_sitemaps_posts_query_args', [self::class, 'sitemapPosts']);
        add_filter('wp_sitemaps_taxonomies_query_args', static function ($args, $taxonomy) {
            if ($taxonomy === 'category') $args['exclude'] = array_unique(array_merge((array)($args['exclude'] ?? []), [(int)get_option('default_category')]));
            return $args;
        }, 10, 2);
        add_filter('wpseo_title', static fn($value) => self::yoastValue('title', $value));
        add_filter('wpseo_metadesc', static fn($value) => self::yoastValue('metadesc', $value));
        foreach (['opengraph', 'twitter'] as $channel) {
            add_filter('wpseo_'.$channel.'_title', static fn($value) => self::yoastSocial($channel, 'title', $value));
            add_filter('wpseo_'.$channel.'_desc', static fn($value) => self::yoastSocial($channel, 'description', $value));
        }
        add_filter('wpseo_canonical', static function ($value) {
            // Keep explicit canonicals. Default indexable caches can contain a previous host.
            $manual = is_singular() ? (string)get_post_meta(get_queried_object_id(), '_yoast_wpseo_canonical', true) : '';
            if (self::nonProduction() || (($manual === '') && (is_singular() || is_home() || is_front_page()))) return self::canonical() ?: $value;
            return $value;
        });
        add_filter('wpseo_opengraph_url', static fn($value) => self::nonProduction() ? self::canonical() : $value);
        add_filter('wpseo_schema_needs_organization', '__return_true');
        add_filter('wpseo_schema_organization', static function ($data) {
            $data = array_replace($data, self::organization());
            // Legacy Yoast can generate an ImageObject with an empty URL.
            if (is_array($data['logo'] ?? null) && empty($data['logo']['url'])) unset($data['logo'], $data['image']);
            return $data;
        });
        add_filter('wpseo_schema_website', static function ($data) {
            $data['publisher'] = ['@id' => home_url('/#organization')];
            return $data;
        });
        add_filter('wpseo_schema_webpage', static function ($data) {
            $data['about'] = ['@id' => home_url('/#organization')];
            $data['name'] = self::yoastValue('title', $data['name'] ?? '');
            $data['description'] = self::yoastValue('metadesc', $data['description'] ?? '');
            return $data;
        });
        // The catalog is a service directory; login accounts are not clinical authors.
        add_filter('wpseo_schema_needs_article', static fn($needed) => self::catalogEntry() ? false : $needed);
        add_filter('wpseo_schema_needs_person', static fn($needed) => self::catalogEntry() ? false : $needed);
        foreach (['organization', 'website', 'webpage', 'breadcrumb', 'main_image', 'imageobject', 'person', 'article'] as $piece) {
            add_filter('wpseo_schema_'.$piece, [self::class, 'schemaUrls'], 99);
        }
        add_filter('wpseo_sitemap_exclude_author', '__return_empty_array');
        add_filter('wpseo_exclude_from_sitemap_by_post_ids', static fn($ids) => array_values(array_unique(array_merge((array)$ids, self::noindexPostIds()))));
        add_filter('wpseo_exclude_from_sitemap_by_term_ids', static fn($ids) => array_values(array_unique(array_merge((array)$ids, [(int)get_option('default_category')]))));
    }

    public static function externalProvider(): bool {
        $active = defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || defined('AIOSEO_VERSION') || defined('SEOPRESS_VERSION') || function_exists('the_seo_framework');
        return (bool)apply_filters('domus_seo_external_provider', $active);
    }

    public static function nonProduction(): bool {
        return getenv('DOMUS_THEME_PREVIEW') === '1' || in_array(wp_get_environment_type(), ['local', 'development', 'staging'], true);
    }

    private static function catalogEntry(): bool {
        return is_singular(['post', 'altri-servizi']) && (bool)get_post_meta(get_queried_object_id(), '_domus_enabled', true);
    }

    public static function excluded(): bool {
        return self::nonProduction() || !get_option('blog_public') || is_search() || is_404() || is_author() || is_date() || is_attachment() || is_preview()
            || isset($_GET['domus_layout']) || is_category((int)get_option('default_category'))
            || (is_singular() && (post_password_required() || get_post_meta(get_queried_object_id(), '_yoast_wpseo_meta-robots-noindex', true) === '1'));
    }

    public static function robots(array $robots): array {
        if (self::excluded()) {
            unset($robots['index']);
            $robots['noindex'] = true;
            if (self::nonProduction()) { unset($robots['follow']); $robots['nofollow'] = true; }
        } else $robots['max-image-preview'] = 'large';
        return $robots;
    }

    public static function heading(): string {
        if (is_404()) return 'Pagina non trovata';
        if (is_search()) return 'Risultati per: '.get_search_query(false);
        if (is_singular()) return Catalog::plainText((string)(get_post_meta(get_queried_object_id(), '_domus_card_title', true) ?: get_the_title(get_queried_object_id())));
        if (is_archive()) return Catalog::plainText(get_the_archive_title());
        return 'Pacchetti e analisi';
    }

    public static function title(): string {
        $s = SiteSettings::all();
        if (is_front_page()) $title = $s['seo_home_title'] ?: $s['site_name'].' | Analisi cliniche a '.str_replace(' · ', ' ', $s['city']);
        else {
            $title = self::heading().' | '.$s['site_name'];
            if (is_singular()) {
                $manual = (string)get_post_meta(get_queried_object_id(), '_yoast_wpseo_title', true);
                if ($manual !== '' && !str_contains($manual, '%%')) $title = $manual;
            }
        }
        $page = max((int)get_query_var('paged'), (int)get_query_var('page'));
        return Catalog::plainText($title).($page > 1 ? ' · Pagina '.$page : '');
    }

    public static function description(): string {
        $s = SiteSettings::all();
        if (is_front_page()) return Catalog::plainText($s['seo_home_description'] ?: $s['site_name'].', laboratorio di analisi cliniche a '.str_replace(' · ', ' ', $s['city']).', '.$s['address'].'. Pacchetti, orari dei prelievi, referti e contatti.');
        if (is_search()) return 'Risultati della ricerca nel sito '.$s['site_name'].'.';
        if (is_404()) return 'La pagina richiesta non è disponibile. Consulta i pacchetti, gli orari e i contatti di '.$s['site_name'].'.';
        if (is_singular()) {
            $post = get_queried_object();
            if (post_password_required($post)) return 'Contenuto protetto da password.';
            $manual = (string)get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
            if ($manual !== '' && !str_contains($manual, '%%')) return Catalog::plainText($manual);
            // Imported medical claims and unconfirmed tariffs must not become snippets automatically.
            if (self::catalogEntry()) return self::heading().' presso '.$s['site_name'].' a '.str_replace(' · ', ' ', $s['city']).'. Consulta la scheda e contatta il laboratorio per informazioni su accesso, preparazione e tariffe.';
            $text = (string)($post->post_excerpt ?: strip_shortcodes($post->post_content));
        } else $text = term_description() ?: self::heading().': informazioni e aggiornamenti del laboratorio '.$s['site_name'].' a '.str_replace(' · ', ' ', $s['city']).'.';
        $text = Catalog::plainText($text);
        return $text !== '' ? wp_html_excerpt($text, 160, '…') : self::heading().' | '.$s['site_name'];
    }

    private static function yoastValue(string $field, string $value): string {
        if (is_singular() && !is_front_page() && get_post_meta(get_queried_object_id(), '_yoast_wpseo_'.$field, true) !== '') return $value;
        if (is_front_page()) {
            $options = (array)get_option('wpseo_titles', []);
            $manual = (string)($options[$field.'-home-wpseo'] ?? '');
            if ($manual !== '' && !str_contains($manual, '%%')) return $value;
        }
        return $field === 'title' ? self::title() : self::description();
    }

    private static function yoastSocial(string $channel, string $field, string $value): string {
        if (is_singular() && get_post_meta(get_queried_object_id(), '_yoast_wpseo_'.$channel.'-'.$field, true) !== '') return $value;
        return self::yoastValue($field === 'title' ? 'title' : 'metadesc', $value);
    }

    public static function canonical(): string {
        if (is_search() || is_404()) return '';
        if (is_singular()) {
            $manual = (string)get_post_meta(get_queried_object_id(), '_yoast_wpseo_canonical', true);
            if (!self::nonProduction() && preg_match('~^https?://~i', $manual)) return esc_url_raw($manual);
            return (string)wp_get_canonical_url(get_queried_object_id());
        }
        if (is_front_page()) $url = home_url('/');
        elseif (is_home()) $url = get_option('page_for_posts') ? get_permalink((int)get_option('page_for_posts')) : home_url('/');
        elseif (is_category() || is_tag() || is_tax()) $url = get_term_link(get_queried_object());
        elseif (is_post_type_archive()) $url = get_post_type_archive_link(get_query_var('post_type'));
        else return '';
        if (!$url || is_wp_error($url)) return '';
        $page = (int)get_query_var('paged');
        if ($page > 1) $url = get_option('permalink_structure') ? trailingslashit($url).'page/'.$page.'/' : add_query_arg('paged', $page, $url);
        return $url;
    }

    public static function organization(): array {
        $s = SiteSettings::all();
        $phone = preg_replace('/[^+\d]/', '', $s['phone']);
        if (str_starts_with($phone, '00')) $phone = '+'.substr($phone, 2);
        elseif ($phone !== '' && !str_starts_with($phone, '+')) $phone = '+39'.$phone;
        $data = ['@type' => ['DiagnosticLab', 'MedicalBusiness'], '@id' => home_url('/#organization'), 'name' => $s['site_name'],
            'legalName' => $s['company'], 'url' => home_url('/'), 'telephone' => $phone, 'email' => $s['email'],
            'address' => ['@type' => 'PostalAddress', 'streetAddress' => $s['address'], 'postalCode' => $s['postcode'], 'addressLocality' => trim(explode('·', $s['city'])[0]), 'addressCountry' => 'IT']];
        if ($s['facebook']) $data['sameAs'] = [$s['facebook']];
        if ($s['vat']) $data['vatID'] = $s['vat'];
        $logo = wp_get_attachment_image_url((int)get_theme_mod('custom_logo'), 'full');
        if ($logo) $data['logo'] = $logo;
        return $data;
    }

    /** Align historical HTTP URLs cached by Yoast with the configured WordPress origin. */
    public static function schemaUrls(mixed $value): mixed {
        if (is_array($value)) return array_map([self::class, 'schemaUrls'], $value);
        if (is_string($value)) return preg_replace('~https?://(?:www\.)?analisidomusmedica\.it(?=/|$)~i', untrailingslashit(home_url('/')), $value);
        return $value;
    }

    public static function graph(): array {
        if (is_404() || is_search() || (is_singular() && post_password_required())) return [];
        $url = self::canonical();
        if (!$url) return [];
        $graph = [self::organization(), ['@type' => 'WebSite', '@id' => home_url('/#website'), 'url' => home_url('/'),
            'name' => SiteSettings::all()['site_name'], 'publisher' => ['@id' => home_url('/#organization')], 'inLanguage' => get_bloginfo('language')],
            ['@type' => is_archive() || is_home() ? 'CollectionPage' : 'WebPage', '@id' => $url.'#webpage', 'url' => $url,
             'name' => self::title(), 'description' => self::description(), 'isPartOf' => ['@id' => home_url('/#website')],
             'about' => ['@id' => home_url('/#organization')], 'inLanguage' => get_bloginfo('language')]];
        if (!is_front_page()) {
            $graph[2]['breadcrumb'] = ['@id' => $url.'#breadcrumb'];
            $graph[] = ['@type' => 'BreadcrumbList', '@id' => $url.'#breadcrumb', 'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => home_url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => self::heading(), 'item' => $url]]];
        }
        return $graph;
    }

    public static function head(): void {
        if (self::externalProvider()) return;
        echo '<meta name="description" content="'.esc_attr(self::description()).'">'."\n";
        $url = self::canonical();
        if ($url) echo '<link rel="canonical" href="'.esc_url($url).'">'."\n";
        if (is_404() || is_search() || (is_singular() && post_password_required())) return;
        foreach (['og:type' => 'website', 'og:title' => self::title(), 'og:description' => self::description(), 'og:url' => $url,
                  'og:site_name' => SiteSettings::all()['site_name'], 'og:locale' => get_locale()] as $key => $value) {
            if ($value !== '') echo '<meta property="'.esc_attr($key).'" content="'.esc_attr($value).'">'."\n";
        }
        $image = is_singular() ? get_the_post_thumbnail_url(get_queried_object_id(), 'large') : false;
        if ($image) echo '<meta property="og:image" content="'.esc_url($image).'">'."\n";
        echo '<meta name="twitter:card" content="'.($image ? 'summary_large_image' : 'summary').'">'."\n";
        $graph = self::graph();
        if ($graph) echo '<script type="application/ld+json" id="domus-schema">'.wp_json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).'</script>'."\n";
    }

    private static function noindexPostIds(): array {
        static $ids;
        return $ids ??= get_posts(['post_type' => 'any', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids',
            'meta_key' => '_yoast_wpseo_meta-robots-noindex', 'meta_value' => '1']);
    }

    public static function sitemapPosts(array $args): array {
        $args['has_password'] = false;
        $args['post__not_in'] = array_values(array_unique(array_merge((array)($args['post__not_in'] ?? []), self::noindexPostIds())));
        return $args;
    }
}
