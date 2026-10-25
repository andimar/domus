<?php
$autoload = __DIR__ . '/vendor/autoload.php';
if (!is_file($autoload)) {
    add_action('admin_notices', static function (): void { echo '<div class="notice notice-error"><p>Domus Medica: installare le dipendenze Composer e assemblare il frontend prima di attivare il tema.</p></div>'; });
    return;
}
require_once $autoload;
Domus\Bootstrap::init();
