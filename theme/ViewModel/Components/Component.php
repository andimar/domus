<?php

namespace Andimar\Theme\ViewModel\Components;

interface Component {

    function getData( array $contextData = [] ) : ComponentData;

}
