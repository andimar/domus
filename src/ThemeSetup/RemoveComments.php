<?php
namespace Domus\ThemeSetup;

final class RemoveComments {
    public static function init(): void {
        add_action('init', [self::class, 'removeSupport'], 100);
        add_action('registered_post_type', [self::class, 'removeTypeSupport']);
        add_filter('comments_open', '__return_false', 20);
        add_filter('pings_open', '__return_false', 20);
        add_filter('comments_array', '__return_empty_array', 20);
        add_filter('feed_links_show_comments_feed', '__return_false');
        add_filter('feed_links_extra_show_post_comments_feed', '__return_false');
        add_filter('pre_option_default_comment_status', static fn()=> 'closed');
        add_filter('pre_option_default_ping_status', static fn()=> 'closed');
        add_filter('wp_headers', static function(array $headers): array {unset($headers['X-Pingback']);return $headers;});
        add_action('admin_menu', static function(): void {remove_menu_page('edit-comments.php');remove_submenu_page('options-general.php','options-discussion.php');}, 999);
        add_action('widgets_init', static function(): void {unregister_widget('WP_Widget_Recent_Comments');});
        foreach(['manage_posts_columns','manage_pages_columns','manage_media_columns'] as $hook)add_filter($hook,static function(array $columns): array {unset($columns['comments']);return $columns;});
        add_action('admin_bar_menu', static function(\WP_Admin_Bar $bar): void {$bar->remove_node('comments');}, 999);
        add_action('wp_dashboard_setup', static function(): void {
            remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
            remove_meta_box('dashboard_activity', 'dashboard', 'normal');
        });
        add_action('admin_init', static function(): void {
            global $pagenow;
            if(in_array($pagenow, ['edit-comments.php', 'comment.php','options-discussion.php'], true)){wp_safe_redirect(admin_url());exit;}
        });
        add_filter('rest_endpoints', static function(array $routes): array {
            foreach(array_keys($routes) as $route)if(preg_match('#^/wp/v2/comments(?:/|$)#', $route))unset($routes[$route]);
            return $routes;
        });
        add_filter('xmlrpc_methods', static function(array $methods): array {
            foreach(array_keys($methods) as $method)if(str_contains(strtolower($method), 'comment')||str_starts_with($method, 'pingback.'))unset($methods[$method]);
            return $methods;
        });
        add_action('template_redirect', static function(): void {if(is_comment_feed()){status_header(404);exit;}});
    }
    public static function removeTypeSupport(string $type): void {
        remove_post_type_support($type, 'comments');
        remove_post_type_support($type, 'trackbacks');
    }
    public static function removeSupport(): void {
        foreach(get_post_types() as $type)self::removeTypeSupport($type);
    }
}
