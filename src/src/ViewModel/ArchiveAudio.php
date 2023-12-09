<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Archive as ArchiveBase;

const ARCHIVE_POSTS_PER_PAGE = 20;

class ArchiveAudio extends ArchiveBase {

    
    function initComponents(): array {

        return [
            \Andimar\Theme\ViewModel\Archive\Components\Pagination::class,
            Archive\Components\Breadcrumbs::class,
            Archive\Components\Audio\Contents::class,
            Archive\Components\Audio\Teachers::class,
        ];
    }
    
}
