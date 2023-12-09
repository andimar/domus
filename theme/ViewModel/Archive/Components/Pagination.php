<?php

namespace Andimar\Theme\ViewModel\Archive\Components;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

class Pagination implements Component{

    protected $totPages;
    
    protected $name = 'pagination';

    protected $pagesToShow = 4;

    

    function getData(array $contextData = []): ComponentData {

        $this->totPages = $contextData['tot_pages'];

        return new ComponentData( $this->name, $this->getPagination() );
    }


    /**
     * Find posts related to the model
     */
    function getPagination() : array {

        $links = [];

        // no pagination
        if($this->totPages <= 1) return $links;

        global $paged;

        if(empty($paged)) $paged = 1;

        $extension = $this->pagesToShow;

        $items_to_show = ($extension * 2) + 1;

        $start = $paged > $extension ? $paged - $extension : 1;
        $end   = ($start + $items_to_show) < $this->totPages ? $start + $items_to_show : $this->totPages;


        // set the previous link
        if($start > 1)
            $links[] = [
                "class" => "previous",
                "link" => \get_pagenum_link($start - 1),
                "text" => '<i class="fas fa-angle-double-left"></i>'
            ];

        // set the numbers
        for ($i = $start; $i <= $end; $i++)
            $links[] = [
                'text'  => $i,
                'class' => ($paged == $i) ? 'current' : '',
                'link'  => ($paged == $i) ? '' : \get_pagenum_link($i)
            ];

        // set the next link
        if($end < $this->totPages)
            $links[] = [
                "class" => "next",
                "link" => \get_pagenum_link($end + 1),
                "text" => '<i class="fas fa-angle-double-right"></i>'
            ];


        return $links;
    }


}
