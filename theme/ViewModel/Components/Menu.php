<?php

namespace Andimar\Theme\ViewModel\Components;

class Menu {

    function getData( array $contextData = []) {

        $menus = wp_get_nav_menus();

        $data = array_reduce( $menus, function( $recursive_menus, $menu ) {

            $menu_map = ['mainmenu' => 'main'];

            $slug = isset($menu_map[$menu->slug]) ? $menu_map[$menu->slug] : $menu->slug;

            $recursive_menus[ $slug ] = $this->getMenuData( $menu->slug ); 

            return $recursive_menus;

        },[]);

        return new ComponentData( $name = 'menu', $data );
    }

 
    /**
     * Ritorna tutti tutte le voci di menu figlie di un certo parent_id
     *
     * @param int $parent_id
     * @param mixed $menu
     * @return array
     */
    private function setChildren( $parent_id, $menu ) {

        return array_map( function( $item ) use ( $menu )  {

            $data = [
                'title' => $item->title,
                'url'   => $item->url,
                'class' => implode(" ", $item->classes),
                'id' => $item->ID
            ];

            $children = $this->setChildren( $item->ID, $menu );

            if( !empty( $children ) ) {
                $data['childs'] = $children;
            }

            return $data;

        }, array_values( array_filter( $menu, function ( $item )  use ( $parent_id ) {

            return $item->menu_item_parent == $parent_id;
        })));

    }
 
    /**
     * Writes the basic menu informations
     */
    private function getMenuData( $menuSlug ) {
 
         $menu = wp_get_nav_menu_items( $menuSlug );
 
         return ( $menu ) ? $this->setChildren( 0, $menu ) : [];           
    }

}
