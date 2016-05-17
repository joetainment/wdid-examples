<?php

namespace wdid;

require_once( 'Duck.class.php' );

//// A simple class to make getting data from the 
class PhpWrapperForServerSuperglobal extends Duck{
    public function
    __get( $key ){
        switch( $key ){
            //// normally we'd use break, but return means we don't have to.
            case 'PHP_SELF_FILENAME':
                return pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME );
            case 'PHP_SELF_DIRNAME':
                return pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME );
            case 'PHP_SELF_BASENAME':
                return pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME );
            case 'PHP_SELF_EXTENSION':
                return pathinfo($_SERVER['PHP_SELF'],PATHINFO_EXTENSION );
            case 'PHP_SELF_PATHINFO':
                return pathinfo($_SERVER['PHP_SELF']);
            default:
                return $_SERVER[$key];
        }
    }
}