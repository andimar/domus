<?php

namespace THEME\ViewModel\Archive\Components\Home;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

class Hero implements Component {

    function getData(array $contextData = []): ComponentData {
        

        return new ComponentData( 'slider', $this->getSlides( $contextData['home_post_id'] ) );
    }


    protected function getSlides( $post_id ) : array {

        $rows = get_field('home_slideshow', $post_id);

        return array_map( fn( $row ) => [

            'title'    => $row['slide_payoff'],
            'subtitle' => '',
            'excerpt'  => $row['slide_text'],
            'image'    => $row['slide_image'],
            'button' => $row['slide_button_cta'] != '' ? [
                'cta'   => $row['slide_button_cta'],
                'icon'  => $row['slide_button_icon'],
                'class' => '',
                'link'  => $row['slide_button_link']
            ] : ''
        ], $rows );

    }

}
