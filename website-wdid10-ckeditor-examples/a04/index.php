<?php

require_once( __DIR__ . '/' .'Utils.class.php' );
require_once( __DIR__ . '/' .'Duck.class.php' );
require_once( __DIR__ . '/' .'Inclusion.class.php' );


use \wdid\Utils as Utils;
use \wdid\Duck as Duck;
use \wdid\Inclusion as Inclusion;


class CKEditorExamplesAWebsite extends Duck {
    
    public function
    __construct(){
        if  ( $this->isAjax() )  $this->respondToAjax();
        elseif ( $this->isPost() )  $this->respondToPost();
        else                   $this->respondToDefault();
    }
    
    public function
    isPost(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST')  return true;
        else return false;
    }
    
    public static function
    isAjax(){
        //// This isAjax test is specifically designed
        //// to work with requests made via jquery
        $x = 'HTTP_X_REQUESTED_WITH';
        $test = false;
        
        if (  isset($_SERVER[$x])  ){
            $httpXRequestedWith = strtolower($_SERVER[$x]);          
            if ( $httpXRequestedWith == 'xmlhttprequest' ){
                $test = true;
            }
        }

        return $test;
    }    

    public function
    respondToAjax(){
        //// The following is taken directly from the ck editor example page

        $action = Utils::GetWDefaultNoRefKeyOrFallback( $_POST, 'action', '' );
        switch($action) {
            case 'SimpleRequest':
                $this->respondToAjaxSimpleRequest($action);
                break;

            default:
                die();
        }
    }
    
    
    
    public function
    respondToAjaxSimpleRequest(){
		$oldText = Utils::GetWDefaultNoRefKeyOrFallback( $_POST, 'ckeditor', '' );
		$newText = str_replace( 'hell', 'heck', $oldText  );
		$newText = $newText . '<br><br> This Data came from PHP';
        $r = [
          'ckeditor' =>
          $newText  
        ];
        $response = json_encode( $r );
        echo $response;
        die();
    }
    
    public function
    respondToPost(){
        //// The following is taken directly from the ck editor example page
        $editor_data = $_POST[ 'editor1' ];
        echo $editor_data;
    }
    
    public function
    respondToDefault(){
        $inclusion = new Inclusion('respondToDefault.content.php');
        echo $inclusion->getText();
    }
}

// In this simple example, the constructor does everything we need
$website = new CKEditorExamplesAWebsite();