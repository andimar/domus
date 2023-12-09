<?php

namespace THEME\QueryFilters;

abstract class QueryFilter {

    function __construct() {

        add_action( 'pre_get_posts', [ $this, 'filter'] );
    }

        
    abstract function filter( $query ) : void;

}
