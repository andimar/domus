<?php

namespace Andimar\Theme\ViewModel\Post;

interface ContentTemplate {

    function getData( \WP_Post $post ) : array;
}
