<?php

require_once( __DIR__ . '/' .'Utils.class.php' );
require_once( __DIR__ . '/' .'Duck.class.php' );
require_once( __DIR__ . '/' .'Inclusion.class.php' );


use \wdid\Utils as Utils;
use \wdid\Duck as Duck;
use \wdid\Inclusion as Inclusion;


class CKEditorExamplesAWebsite extends Duck {
    
    public function __construct(){
        if ( $this->isPost() )  $this->respondToPost();
        else                   $this->respondToDefault();
        
    }
    
    public function isPost(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST')  return true;
        else return false;
    }
    
    public function respondToPost(){
        //// The following is taken directly from the ck editor example page
        $editor_data = $_POST[ 'editor1' ];
        echo $editor_data;
    }
    
    public function respondToDefault(){
        $inclusion = new Inclusion('respondToDefault.content.php');
        echo $inclusion->getText();
    }
}

// In this simple example, the constructor does everything we need
$website = new CKEditorExamplesAWebsite();