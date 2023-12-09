<?php

namespace Andimar\Theme\Utils;

use Timber\Timber as TimberRender;

class Timber {

    /**
     * Render Page
     * and return the result lowering capital letters
     */
    static function render( $template, $data ) {

        if( self::isProductionEnv() ) {

            TimberRender::render( $template, $data );

        } else {

            switch( self::getRenderType() ) {

                case 'json'    : self::printJSON( $data );
                case 'objects' : self::printObjects( $data );
                default : TimberRender::render( $template, $data );
            }
        }
    }

    private static function getRenderType() : string {

        if ( isset($_GET['is_json']) ) return 'json';
        if ( isset($_GET['is_obj']) )  return 'objects';
        return 'timber';
    }

    private static function printJSON( $data ) {

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_PRETTY_PRINT);
        
    }

    private static function printObjects( $data ) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    private static function isProductionEnv() {

        return false;
    }

    public static function get_context() { 
        
        return TimberRender::get_context();
    }

}
