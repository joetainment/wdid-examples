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
        //// in this simple example, the page is hardcoded,
        //// more full complete code would compute the page by url
        $this->page = 'index';
        
        
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
            case 'SaveRequest':
                $this->respondToAjaxSaveRequest($action);
                break;

            default:
                die();
        }
    }
    

    
    /*
    public function
    ckeditorFixDuplicateDatabaseRecords( &$dbRecords );  // note ref array
        //// something could be added here to repair broken databases

        //// if there's more then a single one,
        //// then something is broken and fixing is required
        //if ( count($dbRecords>1) )  $this->ckeditorFixDuplicateDatabaseRecords( $dbRecords );        
        
    }
    */
    
    public function
    ckeditorGetExistingBean( $page ){
        if (!$this->isConnected) $this->initDatabase();
        //// first we define the search and sql with standins like :page
        //// then the array maps the standins
        $dbRecord = null;
        ////  meaning here is     bean_type,  array of conditions
        ////   thus, and beans where the 'page' is $page  will be returned
        $dbRecords = $this->dbMan->rb->find( 'ckeditor', [ 'page' => [$page] ]  );
        
        //// Set our records to the last valid one in array,
        //// generally speaking we should also long term have something
        //// to deal with potentially having different versions with different
        //// timestamps        
        foreach( $dbRecords as $r ){
            if ( $r != null ) $dbRecord = $r;
        }

        return $dbRecord;
    }
    
    public function
    ckeditorGetOrCreateBean( $page ){
        if (!$this->isConnected) $this->initDatabase();
        $dbRecord = $this->ckeditorGetExistingBean( $page );
        //// Make a new bean, since one doesn't exist
		if  ( $dbRecord==null){
            $dbRecord = null;
			$dbRecord = $this->dbMan->rb->dispense( 'ckeditor' );
            $dbRecord->page = $page;
        }
        return $dbRecord;
    }
    
    
    
    
    public function
    ckeditorSaveDatabase( $page ){
        //// If we are not already connected to the database,\
        //// connect to it.
        if (!$this->isConnected) $this->initDatabase();
        
        //// If there's already an entry in the database,
        //// get that and update it, via 'find', otherwise, 
        //// make a new entry using 'dispense'
        $dbRecord = $this->ckeditorGetOrCreateBean( $page );
		
        //// At this point we are guaranteed to have a been that works,
        //// (assuming no errors/exceptions)
        //// set the beans text
        $dbRecord->text = $this->ckeditorData;
        //// sets a timestamp, using the currect microtime as a float
        $dbRecord->timeStamp = microtime( true );  
        $this->dbMan->rb->store( $dbRecord ); 
    }
    
    public function
    ckeditorLoadDatabase( $page ){
        if (!$this->isConnected) $this->initDatabase();
        //// If there's already an entry in the database,
        //// get that and update it, via 'find', otherwise, 
        //// make a new entry using 'dispense'
        $dbRecord = $this->ckeditorGetExistingBean( $this->page );
        if ($dbRecord!==null) $this->ckeditorData = $dbRecord->text;
    }
    
    
    public function
    respondToAjaxSaveRequest(){
		$oldText = Utils::GetWDefaultNoRefKeyOrFallback( $_POST, 'ckeditor', '' );
		$newText = str_replace( 'hell', 'heck', $oldText  );
        $this->ckeditorData = $newText;
        $this->ckeditorSaveDatabase( $this->page );
        $r = [
          'ckeditor' => $this->ckeditorData  
        ];
        $response = json_encode( $r );
        echo $response;
        die();
    }    
    
    public function
    respondToPost(){
        $this->ckeditorData = $_POST[ 'ckeditor' ];
        $this->ckeditorSaveDatabase( $this->page );
        $this->respondToDefault();
    }
    
    public function
    respondToDefault(){
        //// We will insert a script later, depending on data found
        //// By default, there's no script, but later, html for a 
        //// script tag could go here
        $script = '';
        
        if (!$this->isConnected) $this->initDatabase();
        $dbRecord = $this->ckeditorGetExistingBean( $this->page );

        
        
        //// In the event that we found data, insert this data
        //// into the html by inserting a script element in the
        //// header,  via text replacement.
        if ($dbRecord!=null){	
            
            $phpVarsJson = json_encode([
                'ckeditor' => $dbRecord->text
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
		}
		
		
		
		$inclusion = new Inclusion('respondToDefault.content.php');

        //// In this example, we replace an existing
        //// script tag, but this way is a bit hackish
        //// it would be better if built up the page
        //// in php rather than just including a fully
        //// formed html page, but that would complicate
        //// this example
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
$dbName = 'website_wdid10_ckeditor_examples_a05';
$user = 'root';
$pass = '';
$connectionInfo = new DatabaseConnectionInfo( $host , $dbName, $user, $pass );
$opts = ["connectionInfo"=>$connectionInfo];
$webpage = new CKEditorExamplesAWebsite( $opts );