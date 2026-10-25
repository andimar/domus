<?php
namespace Domus\Rendering;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
final class TwigRenderer {
    public static function render(string $template, array $context): string {
        $twig = new Environment(new FilesystemLoader(get_template_directory() . '/frontend/templates'), ['autoescape' => 'html', 'cache' => false]);
        return $twig->render($template, $context);
    }
}
