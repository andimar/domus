<?php
namespace Domus\ThemeSetup;

final class ImagePoolControl extends \WP_Customize_Control {
    public $type='domus-images';
    public function render_content(): void {
        echo '<span class="customize-control-title">'.esc_html($this->label).'</span>';
        echo '<p class="description">'.esc_html($this->description).'</p>';
        echo '<div data-domus-image-list></div><p><button type="button" class="button" data-domus-image-select>Scegli immagini</button> <button type="button" class="button-link" data-domus-image-reset>Ripristina</button></p><p class="description" role="status" data-domus-image-count></p>';
    }
}
