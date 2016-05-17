<?php

namespace wdid;

require_once( 'Duck.class.php' );

class TagGenerator extends Duck {
    public function
    genTagDoctype(){
        return '<!DOCTYPE HTML>' . "\n";
    }
    
    public function
    genTagHeadOpen(  ){
        return '<head>' . "\n";
    } 
    public function
    genTagHeadClose( ){
        return '</head>' . "\n";
    }    
    
    public function
    genTagHtmlOpen( $lang='en' ){
        return '<html lang="' . $lang . '">' . "\n";
    }
    
    public function
    genTagHtmlClose(){
        return '</html>';
    }
    public function
    genTagBodyOpen(){
        return '<body>' . "\n";
    }
    
    public function
    genTagBodyClose(){
        return '</body>' . "\n";
    }   
}
