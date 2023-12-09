<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Archive as ArchiveBase;



class Home extends ArchiveBase
{

    function initComponents() : array {

        return [

            Archive\Components\Home\Hero::class,
            Archive\Components\Home\About::class,            
            Archive\Components\Home\Events::class,
            Archive\Components\Home\Magazine::class,
            Archive\Components\Home\Audio::class,

            Archive\Components\News::class,
        ];
    }

    protected function setData() {

        $this->data['type']    = 'home';
        
        
        global $posts;
        $this->data['home_post_id'] = $posts[0]->ID;
        
    }

    protected function setArticles( string $listName = '') {
        return;
    }

}