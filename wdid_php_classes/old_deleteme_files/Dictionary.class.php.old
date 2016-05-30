<?php
//// A namespace will keep us organized
////   http://php.net/manual/en/language.namespaces.php
namespace wdid;

require_once( 'Duck.class.php' );


//// PHP's Array functions are a bit of a mess and incomplete.
////   we will put useful array related functions into our own Arr class
class Dictionary extends Duck implements \ArrayAccess {
    
    
    //// Get safely, with a default fallback, from the instance
    ////  this one potential problem with this is it doesn't work when adding a null key.
    ////  it's getWFallback or GetWDefault
    public function 
    get( &$key, &$fallback=null ){
        return self::GetWDefault( $this->_arr, $key, $fallback );
        //// this will return null instead of causing an error,
        //// if $key doesn't exist;
    }
    
    //// This one forces the user to explicitly state a fallback
    public function
    getSafe( &$key, &$fallback ){
        return self::GetWDefault( $this->_arr, $key, $fallback );
    }
    
    //// This follows standard behavior for getting from array,
    //// with the same errors as usual
    public function
    getUnsafe( &$key ){
        return $this->_arr[$key];
    }
    
    //// Only set if not null
    public function
    set( &$key, &$value ){
        if ( $key!==null ){
            $this->_arr[$key] = $value;
        }
    }
    public function
    setUnsafe( &$key, &$value ){
        $this->_arr[$key] = $value;
    }
    
    //public function
    //removeNullKeys(){
    //    unset( 
    //}
    
    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value) {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->_arr[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->_arr[$offset]);
    }    
 
//// Notes about keys in arrays
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
