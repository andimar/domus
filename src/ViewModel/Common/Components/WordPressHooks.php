<?php
namespace Domus\ViewModel\Common\Components;
use Domus\ViewModel\Common\Component;
use Domus\ViewModel\Common\ComponentData;
final class WordPressHooks implements Component {
    public function __construct(mixed $data, array $context) {}
    public function getData(): ComponentData {
        $html = [];
        foreach (['wp_head', 'wp_body_open', 'wp_footer'] as $hook) {
            ob_start();
            $hook();
            $html[$hook] = (string) ob_get_clean();
        }
        return new ComponentData('wordpress', $html);
    }
}
