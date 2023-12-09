<?php

namespace Andimar\Theme\ViewModel\Components;

interface PostComponent {

    function getData( int $postID, array $contextData = [] ) : ComponentData;

}
