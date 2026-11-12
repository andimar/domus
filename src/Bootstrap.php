<?php
namespace Domus;
final class Bootstrap {
    public static function init(): void {
        ThemeSetup\Support::init();
        ThemeSetup\Seo::init();
        ThemeSetup\RemoveComments::init();
        ThemeSetup\Assets::init();
        ThemeSetup\Transport::init();
        ThemeSetup\HomeImages::init();
        ThemeSetup\TopBar::init();
        ThemeSetup\Login::init();
        Admin\Settings::init();
    }
}
