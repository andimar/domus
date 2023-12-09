<?php

namespace Andimar\Theme\ViewModel\Components;

class ComponentData {

    public function __construct( 

        public string $name,
        public string|array  $data
    ) {}

}
