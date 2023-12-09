<?php

namespace THEME\ThemeSetup;

class Thumbnails {

    public static function init() {

        self::init_thumbnails();
  
    }

    
    public static function init_thumbnails() {
        
        add_image_size('blz_extra_small', 0, 120, true);
        add_image_size('blz_square', 160, 160, true);
        add_image_size('blz_small', 480, 300, true); 
        add_image_size('blz_medium', 560, 350, true);
        add_image_size('blz_large', 1060, 424, true);
        add_image_size('blz_product', 400, 0, true);

        /** x2 thumbnails */
        add_image_size('blz_extra_small_x2', 0, 240, true);
        add_image_size('blz_square_x2', 320, 320, true);
        add_image_size('blz_small_x2', 960, 600, true); 
        add_image_size('blz_medium_x2', 1120, 700, true);
        add_image_size('blz_large_x2', 2120, 848, true);        
    }

}
