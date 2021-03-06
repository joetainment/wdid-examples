<?phperror_reporting( E_ALL );
require_once( 'wdid_php_classes/' . 'include_all_wdid_classes.php' );

use \wdid\DatabaseConnectionInfo as DatabaseConnectionInfo;
use \wdid\DatabaseManager as DatabaseManager;use \wdid\Inclusion as Inclusion;
use \wdid\Utils as Utils;
use \wdid\Duck as Duck;
class CkEditorExampleWebpage extends Duck {    public $ckeditorData = "";    public function __construct( $opts ){        //// info must be given, so correct to error if no key        $this->connectionInfo = $opts['connectionInfo'];        $this->headInclusion = new Inclusion( 'ckeditor-database-example.head.php' );        $this->headStylesInclusion = new Inclusion( 'ckeditor-database-example.head_styles.php' );                $this->headScriptsInclusion = new Inclusion( 'ckeditor-database-example.head_scripts.php' );        $this->bodyInclusion = new Inclusion( 'ckeditor-database-example.body.php' );                    }    public function initDatabase(){        $this->dbMan = new wdid\DatabaseManager( $this->connectionInfo );        $this->dbMan->connect();    }    
    public function    process(){        if (  Utils::IsAjax()  ){
            $this->processAjax();        }        else $this->processPage();    }    public function processAjax(){        $action = Utils::GetWDefaultNoRefKeyOrFallback( $_POST, 'action', '' );                        switch($action) {
            case 'SetCkeditorToPresetText':
                $this->respondToSetCkeditorToPresetText($action);
                break;            case 'CensorCkeditorText':                $this->respondToCensorCkeditorText($action);                break;            case 'SaveCkeditorText':                $this->respondToSaveCkeditorText($action);                break;            case 'RevertCkeditorText':                $this->respondToRevertCkeditorText($action);                break;            default:                echo "";        }    }
    public function
    respondToCensorCkeditorText($action){        $ckeditorData = Utils::GetWDefaultNoRefKeyOrFallback( $_POST, 'ckeditor', '' );
        $ckeditorData = str_replace( "hell", "heck", $ckeditorData );        $r = ['ckeditorData'=>$ckeditorData];
        $response = json_encode( $r );
        echo $response;
    }    public function    respondToSetCkeditorToPresetText($action){        $r = ['ckeditorData'=>'this was generated by ajax response'];        $response = json_encode( $r );        echo $response;    }        public function    respondToSaveCkeditorText($action){        $ckeditorData = Utils::GetWDefaultNoRefKeyOrFallback( $_POST, 'ckeditor', '' );        $this->ckeditorData = $ckeditorData;        $this->initDatabase();        $this->syncCkeditorDataToDatabase();        $r = [ 'ckeditorData'=>$this->ckeditorData ];        $response = json_encode( $r );        echo $response;    }        public function    respondToRevertCkeditorText($action){        $this->initDatabase();        $this->syncCkeditorDataToDatabase();        $r = [ 'ckeditorData'=>$this->ckeditorData ];        $response = json_encode( $r );        echo $response;    }    public function    processPage(){        /////////////////////        //// Continue default processing if not an ajax request        ////        //// We could do something to save to files, as shown in other        //// example.        //$this->syncCkeditorDataToFile();        $this->dbMan = new wdid\DatabaseManager( $this->connectionInfo );
        $this->dbMan->connect();        if (  array_key_exists( 'nuke', $_GET )  ){            $this->dbMan->writer->wipeAll();        }
        $this->syncCkeditorDataToDatabase();        $this->draw();    }    public function    syncCkeditorDataToDatabase(){
        //// Getting the data from $_POST
        //// and saving it, save vars as empty
        //// strings if no data
        //$sep = "\\";  //// remember to add code for posix platforms!
                //// posix support would need to go here
                //// a simple example is below
        $sep = DIRECTORY_SEPARATOR;
        $ckeditorName = 'ckeditor';
        $ckeditorData = $this->ckeditorData;

        //// This will track whether we need to store or retrieve the data
        $doStore = false;
        if (  array_key_exists($ckeditorName, $_POST)  ){
            $ckeditorData = $_POST[ $ckeditorName ];
            $doStore = true;
        }


        $typeOfRecord = 'page';
        $filenameForAddress = pathinfo(__FILE__)['filename'];
        $pagesFound = $this->dbMan->rb->find(            $typeOfRecord,            [  'address'=>[ $filenameForAddress ]  ]        );        
        $count = count($pagesFound);
        if (  $count<=0  ){
            //// Since we couldn't find it, if we have data, store it
            //// else ckeditor data will stay empty
            if ($doStore===true){
                $page = $this->dbMan->rb->dispense( $typeOfRecord );
                $page->address = $filenameForAddress;
                $page->content = $ckeditorData;
                $this->dbMan->rb->store( $page );               
            }
        }
        else {
            //// Since we found it in the array,
            //// pop the page out of the array
            $page = array_pop( $pagesFound );

            //// Store it to the page
            if ($doStore===true){
                $page->address = $filenameForAddress;
                $page->content = $ckeditorData;
                $this->dbMan->rb->store( $page );
            }
            //// Read it back only!
            else {
                $ckeditorData = $page->content;
            }
        }        $this->ckeditorData = $ckeditorData;    }    public function getPhpVarsScript(){        //// Now that we have the data
        //// JSON encode some data for javascript
        $phpVarsJson = json_encode([
            'ckeditorData' => $this->ckeditorData
        ]);        //// Script For Php Vars To Echo Into Html
        $script =                      "<script>"
                    . "var phpVars ="
                    . $phpVarsJson
                    . ";"
                    . "</script>"
        ;        return $script;    }
     
    public function    draw(){
        echo '<!DOCTYPE html>' . "\n";
        echo '<html>' . "\n";
        echo '<head>' . "\n";		echo $this->getPhpVarsScript();                echo $this->headInclusion->getText();        echo $this->headStylesInclusion->getText();                echo $this->headScriptsInclusion->getText();        echo '</head>';        echo '<body>';        echo $this->bodyInclusion->getText();        echo '</body>';        echo '</html>';
    }}
$host = 'localhost';
$dbName = 'ckeditor';
$user = 'root';
$pass = 'wdid00wdid';
$connectionInfo = new wdid\DatabaseConnectionInfo( $host , $dbName, $user, $pass );$opts = ["connectionInfo"=>$connectionInfo];$webpage = new CkeditorExampleWebpage( $opts );$webpage->process();