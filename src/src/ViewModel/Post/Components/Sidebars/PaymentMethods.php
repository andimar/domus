<?php

namespace THEME\ViewModel\Post\Components\Audio;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;


class PaymentMethods implements Component {



    function getData(array $contextData = []) : ComponentData {

        return new ComponentData( 'sidebar_payment_methods', [] );
    }
}
