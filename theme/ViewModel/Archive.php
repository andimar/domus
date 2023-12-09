<?php

namespace Andimar\Theme\ViewModel;

use Andimar\Theme\ViewModel\Post\ContentTemplate;

abstract class Archive extends Base {

    protected ContentTemplate|null $postTemplate;

    const ARCHIVE_POSTS_PER_PAGE = 20;

    function __construct( string $postTemplate = '' ) {

        parent::__construct();

        // set the postTemplate       
        $this->postTemplate = $postTemplate == '' ? null : new $postTemplate();

        // add the articles to data
        $this->setArticles();

        // set the components list into property
        // $components
        $this->components = $this->initComponents();

        // add all the default components
        $this->setComponents();
	}

    /**
     * Writes the basic page informations
     */
    protected function setData(){       
        $this->data = [
            'type' => 'archive'
        ];
    }


    /**
     * set the posts list as articles array using 
     * the standard wp_query 
     * 
     * AND SET the total pages to data ( lo so qui bisognerebbe architettarlo un mo meglio)
     *      
     * @return void
     */
    protected function setArticles( string $listName = 'articles') {

        global $wp_query;

        // as an array of posts
		$posts = array_map( function ( $post )  {

			// structured as described by the current template
			return  empty( $this->postTemplate ) ? $post : $this->postTemplate->getData( $post );

		}, $wp_query->posts );
        
        $this->data[ $listName ]  = $posts;
        $this->data['tot_pages'] = ( int ) $wp_query->max_num_pages;

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

            $component_instance = (new $component() )->getData( $this->data );

            $this->data[$component_instance->name] = $component_instance->data;

        }
    }
}
