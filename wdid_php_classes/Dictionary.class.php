<?php
//// A namespace will keep us organized
////   http://php.net/manual/en/language.namespaces.php
namespace wdid;

require_once( 'Duck.class.php' );

class Dictionary extends ArrayObject {

    static function Wrapped( $a ){
        //// If given a WdidArray of subclass instance,
        //// return it unchanged
        if ( $a instanceof ArrayObject ){
            return $a;
        }    
        //// Otherwise, return a new WdidArray instance.
        return  new WdidArray( $a );
            //// note that this could be stricter, if we wanted to
            //// disallow wrapping certain types.
    }

    function getWithFallback( $key, $fallback ){
        if (  array_key_exists( $key, $this )  ){
            return $this[$key];
        }
        return $fallback;
    }
    //// Get safely, with a default fallback, from the instance
    ////  this one potential problem with this is it doesn't work when adding a null key.
    ////  it's getWFallback or GetWDefault
    public function 
    get( &$key, &$fallback=null ){
        return self::GetWDefault( $this->_arr, $key, $fallback );
        //// this will return null instead of causing an error,
        //// if $key doesn't exist;
    }
}//// Notes about keys in arrays
// the key can either be an integer or a string. The value can be of any type.
// Additionally the following key casts will occur:
//
// Strings containing valid integers will be cast to the integer type.
//    E.g. the key "8" will actually be stored under 8. On the other hand
//    "08" will not be cast, as it isn't a valid decimal integer.
// Floats are also cast to integers, which means that the fractional
//   part will be truncated. E.g. the key 8.7 will actually be stored
//   under 8
// Bools are cast to integers, too, i.e. the key true will actually
//   be stored under 1 and the key false under 0
// Null will be cast to the empty string, i.e. the key null will
//   actually be stored under "".
// Arrays and objects can not be used as keys. Doing so will
//   result in a warning: Illegal offset type  
  
}
