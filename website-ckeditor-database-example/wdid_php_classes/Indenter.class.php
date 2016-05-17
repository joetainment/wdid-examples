<?php

namespace wdid;

//// This is a very primitive example of a utility to
////   echo code that is automatically indented
////   it's really only a very simple example
////   and doesn't even handle multiple lines yet
////    however, it could be improved with minimal effort
////   so it's a nice stand in for now.
////

class Indenter extends Duck {
    protected $_indentCount = 0;
    
    public function
    at( $text ){
        return Utils::TabTextWithNewline( $text, $this->_indentCount );
    }
    public function
    in( $text ){
        $r = Utils::TabTextWithNewline( $text, $this->_indentCount);
        $this->_indentCount++;
        return $r;
    }
    public function
    out( $text ){
        $this->_indentCount--;
        return Utils::TabTextWithNewline( $text, $this->_indentCount );
    }
    public function
    reset(){
        $_indentCount = 0;
        return $this;
    }
    
    public function
    setIndentCount( $count ){
        assert( 'integer'==gettype($count) );
        $this->_indentCount = $count;
        return $this;
    }
    
    public function
    getIndentCount( ){
        return $this->_indentCount;
    }
}
