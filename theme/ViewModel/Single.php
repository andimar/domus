<?php

namespace Andimar\Theme\ViewModel;

use Andimar\Theme\ViewModel\Post\ContentTemplate;

abstract class Single extends Base {

    protected ContentTemplate $contentTemplate;

    /**
     * - Single ha un template per i contenuti 
     * - Single ha una serie di componenti e attributi che devono essere aggiunti ai dati
     */
    function __construct( private \WP_Post $post,  string $contentTemplate ) {

        parent::__construct();

        $this->contentTemplate = new $contentTemplate();

        $this->setPost();

        // set the components list into property
        // $components
        $this->components = $this->initComponents();

        $this->setComponents();

    }

    protected function setData() {

        $this->data = [
            'type' => 'single'
        ];
    }

    /**
     * Add the post info to data
     */
    protected function setPost() {    

        $this->data['post'] = $this->contentTemplate->getData( $this->post );
    }

    
    /**
     * set the list of the components
     * override this to add or remove components

     */
    abstract function initComponents() : array;
    // {
    //     return [
    //         //Components\Archive\Pagination::class,            
    //         //Components\Archive\Breadcrumbs::class,
    //     ];
    // }

  

    /**
     * Get data from all the components in the
     * $components list
     */
    protected function setComponents() {

        foreach($this->components as $component) {

            $component_instance = ( new $component() )->getData( $this->data );

            $this->data[$component_instance->name] = $component_instance->data;

        }
    }

}
