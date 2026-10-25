<?php
namespace Domus\Data;
/** Lettura sola: non migra né modifica le impostazioni Regina Lite. */
final class LegacySettings {
    public function all(): array {
        $settings = get_option('theme_mods_regina-lite', []);
        return is_array($settings) ? $settings : [];
    }
}
