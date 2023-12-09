<?php

namespace THEME\ThemeSetup;

class SetupImagesOptimization {

    function __construct() {

        /// Removes Lazy loading 
        //add_filter( 'wp_lazy_loading_enabled', '__return_false' );
        
        // Removes the decoding attribute from images added inside post content.        
        //add_filter( 'wp_img_tag_add_decoding_attr', '__return_false' );

        // disable srcset on frontend
        add_filter('max_srcset_image_width', function() { return 1; } );    
    }
    
}
