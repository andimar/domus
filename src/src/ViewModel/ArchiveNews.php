<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Archive as ArchiveBase;

class ArchiveNews extends ArchiveBase {

    function initComponents(): array
    {
        return [
            \Andimar\Theme\ViewModel\Archive\Components\Pagination::class,
        ];
    }
}
