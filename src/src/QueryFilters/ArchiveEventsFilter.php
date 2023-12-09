<?php

namespace THEME\QueryFilters;

use THEME\ViewModel\ArchiveAudio;
use \THEME\ViewModel\ArchiveEvents;

class ArchiveEventsFilter extends QueryFilter {

    function filter( $query ) : void {

        if ( ! is_admin() && $query->is_main_query() ) {
            // Not a query for an admin page.
            // It's the main query for a front end page of your site.

            if ( is_tax( 'attivita' ) || is_post_type_archive( 'iniziativa' ) ) {
                // It's the main query for a category archive.

                // Let's change the query for category archives.
                $query->set( 'posts_per_page', ArchiveEvents::ARCHIVE_POSTS_PER_PAGE );
            }

            if ( is_tax( 'conduttori' ) || is_post_type_archive( 'audio' ) ) {
                // It's the main query for a category archive.

                // Let's change the query for category archives.
                $query->set( 'posts_per_page', ArchiveAudio::ARCHIVE_POSTS_PER_PAGE);                
            }

        }
    }


}
