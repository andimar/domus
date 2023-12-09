<?php

namespace Andimar\Theme\ViewModel;

use Timber\Timber;
use Andimar\Theme\ViewModel\Components;

/**
 * Serve ad inizializzare il funzionamento di base dei controller
 * 
 */
class Base {

    protected array $data;
    protected array $components;
    protected $context;

    function __construct() {

        $this->context = Timber::get_context();

        $this->setData();
        $this->setHeadAndFooterCore();
        $this->setIsMobile();

        $this->components = $this->initBasicComponents();
        
        $this->setBasicComponents();

    }


    function getData(){

        return $this->data;
    }


    protected function setData() {

        $this->data = [
            'type' => 'base'
        ];
    }

    protected function initBasicComponents() { 

        return [

            Components\Menu::class,
            Components\Mobile::class, 
            Components\FrontendDirSetup::class,         
        ];

    }

    protected function setBasicComponents() {

        foreach( $this->components as $component ) {

            $component_instance = ( new $component() )->getData();
            
            $this->data[ $component_instance->name ] = $component_instance->data;
        }
    }

    /**
     * Add wp_head and wp_footer to data 
     */
    protected function setHeadAndFooterCore() {

        
        $this->data["wp_head"]   = $this->context["wp_head"];
        $this->data["wp_footer"] = $this->context["wp_footer"];
    }

    protected function setIsMobile() {

        $this->data['mobile'] = wp_is_mobile();

    }

}
