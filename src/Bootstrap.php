<?php
namespace Domus;
final class Bootstrap {
    public static function init(): void {
        ThemeSetup\Support::init();
        ThemeSetup\Assets::init();
        ThemeSetup\Transport::init();
        Admin\Settings::init();
    }
}
