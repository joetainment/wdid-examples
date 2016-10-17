<?php

require_once( __DIR__ . '/' .'Utils.class.php' );
require_once( __DIR__ . '/' .'Duck.class.php' );
require_once( __DIR__ . '/' .'Inclusion.class.php' );
require_once( __DIR__ . '/' .'DatabaseManager.class.php' );
require_once( __DIR__ . '/' .'DatabaseConnectionInfo.class.php' );


use \wdid\Utils as Utils;
use \wdid\Duck as Duck;
use \wdid\Inclusion as Inclusion;
use \wdid\DatabaseConnectionInfo as DatabaseConnectionInfo;
use \wdid\DatabaseManager as DatabaseManager;


class CKEditorExamplesAWebsite extends Duck {
    
    public function
    __construct( $opts ){
        
        $this->connectionInfo = $opts['connectionInfo'];
        $this->isConnected = false;
        
        
        if  ( $this->isAjax() )  $this->respondToAjax();
        elseif ( $this->isPost() )  $this->respondToPost();
        else                   $this->respondToDefault();
    }
    
    public function initDatabase(){
        $this->dbMan = new wdid\DatabaseManager( $this->connectionInfo );
        $this->dbMan->connect();
        $this->isConnected = true;
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
        $r = [
          'responseText' =>
            'This was generated in response to ajax, by function:'
            . '<br>' . 'respondToAjaxSimpleRequest'
        ];
        $response = json_encode( $r );
        echo $response;
        die();
    }
    
    public function
    respondToPost(){

        $this->ckeditorData = $_POST[ 'editor1' ];
        if (!$this->isConnected) $this->initDatabase();
        
        //// If there's already an entry in the database,
        //// get that and update it, via 'find', otherwise, 
        //// make a new entry using 'dispense'
        $dbRecords = $this->dbMan->rb->find( 'ckeditor', [ ] );
        if (  count($dbRecords)==0  ){
            $dbRecord = array_pop( $dbRecords );
        } else {
            $dbRecord = $this->dbMan->rb->dispense( 'ckeditor' );
        }
        
        $dbRecord->text = $this->ckeditorData;
        $this->dbMan->rb->store( $dbRecord );
        
        $this->respondToDefault();
        
    }
    
    public function
    respondToDefault(){
        

        if (!$this->isConnected) $this->initDatabase();
        
        $dbRecords = $this->dbMan->rb->find( 'ckeditor', [ ] );
        $dbRecord = array_pop( $dbRecords );
        
        
        //// In this example, we replace an existing
        //// script tag, but this way is a bit hackish
        //// it would be better if built up the page
        //// in php rather than just include a fully
        //// formed html page
        
        $phpVarsJson = json_encode([
            'ckeditorData' => $dbRecord->text
        ]);
        //// Script For Php Vars To Echo Into Html
        ////  note that the js version is captital,
        ////  since it has to be a global variable
        $script =
                      "<script>"
                    . "var PhpVars ="
                    . $phpVarsJson
                    . ";"
                    . "</script>"
        ;
        
        
        $inclusion = new Inclusion('respondToDefault.content.php');
        $withScript = str_replace(
            '<script id="phpGeneratedScript"></script>',
            $script,
            $inclusion->getText()            
        );
        echo $withScript;
        
        
        
    }
}

// In this simple example, the constructor does everything we need
$host = 'localhost';
$dbName = 'website_wdid10_ckeditor_examples_a04';
$user = 'root';
$pass = '';
$connectionInfo = new DatabaseConnectionInfo( $host , $dbName, $user, $pass );
$opts = ["connectionInfo"=>$connectionInfo];
$webpage = new CKEditorExamplesAWebsite( $opts );