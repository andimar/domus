<?php

namespace THEME\ViewModel;

use Andimar\Theme\ViewModel\Archive as ArchiveBase;

class ArchiveTeachers extends ArchiveBase {

    const ARCHIVE_POSTS_PER_PAGE = -1;

    function __construct( string $postTemplate ) {

        parent::__construct( $postTemplate );

        $this->data['featured_teachers'] = $this->getFeaturedTeachers();
        $this->data['teachers'] = $this->getTeachers();

        unset($this->data['articles']);       
    }


    function getFeaturedTeachersIDS() {
        
        return get_posts([

            'post_type' => 'insegnanti',
            'post_name__in' => [ 'corrado-pensa', 'neva-papachristou'  ],
            'orderby' => 'ID','order' => 'DESC',
            'fields' => 'ids'
        ]);

    }

    function getFeaturedTeachers() {
        
        $posts = get_posts([

            'post_type' => 'insegnanti', 'post_name__in' => [ 'corrado-pensa', 'neva-papachristou'  ], 'orderby' => 'ID','order' => 'DESC'
        ]);

        return array_map( fn($post) =>  $this->postTemplate->getData($post), $posts );
    }

    function getTeachers() {

        $posts = get_posts([

            'post_type' => 'insegnanti', 'posts_per_page' => -1,
            'post__not_in' => [],
            'meta_key' => 'order',
            'orderby'  => 'meta_value',
            'order'    => 'ASC'
        ]);


        $posts = array_filter( $posts, fn($post) => !str_contains( $post->post_name, '-2') );

        return  array_map( fn($post) =>  $this->postTemplate->getData($post), $posts );
    }

    function initComponents(): array
    {
        return [];
    }
    
}
