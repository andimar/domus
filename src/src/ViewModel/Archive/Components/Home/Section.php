<?php

namespace THEME\ViewModel\Archive\Components\Home;

use Andimar\Theme\ViewModel\Components\Component;
use Andimar\Theme\ViewModel\Components\ComponentData;

abstract class Section implements Component {
    
    protected string $customFieldsPrefix;
    protected string $cardPostType;

    protected int $cardsNumber = 6;

    protected array $fields;

    function __construct() {

        $customFieldPrefix =  $this->getCustomFieldsPrefix();

        $fieldsGroup = get_field( $customFieldPrefix );

        $this->fields =  array_shift( $fieldsGroup ) ;
    }

    abstract protected function getCustomFieldsPrefix() : string;
    abstract protected function getCardTemplate()       : string;
    abstract protected function getCardPostType()       : string;
    abstract protected function getName()               : string;
    
    function getData(array $contextData = []): ComponentData {

        return new ComponentData( $this->getName(), [ 
            'title' => $this->getField('title'),
            'text'  => $this->getField('text'),
            'cards' => $this->getCards(),
            'btn1'  => $this->getBtn(1),
            'btn2'  => $this->getBtn(2)
        ] );
        
    }

    
    protected function getCards() : array {

        if( $this->getCardTemplate() == '') return [];

        $cardTemplate = new ( $this->getCardTemplate() );

        $cards = get_posts([
            'post_type' => $this->getCardPostType(),
            'posts_per_page' => $this->cardsNumber
        ]);

        return array_map( fn( $event ) => $cardTemplate->getData( $event ), $cards );
    }


    protected function getField( $field ) : string {

        $field = $this->getCustomFieldsPrefix(). '_' . $field;

        return isset($this->fields[$field]) ? $this->fields[$field] : '';
    }
    

    protected function getBtn( int $index ) {
        return [
            "url" => $this->getField( "btn_{$index}_url" ),
            "cta"  => $this->getField( "btn_{$index}_cta" )
        ];
    }
}
