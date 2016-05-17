<?php
//// A namespace will keep us organized
////   http://php.net/manual/en/language.namespaces.php
namespace wdid;

require_once( 'Utils.class.php' );

//// First we make a very generic class
////     the word 'Duck' comes from duck typing
////     everything else will inherit from Duck if possible

class Duck {
    public function
    getType(){
        return Utils::GetType( $this );   
    }
}
