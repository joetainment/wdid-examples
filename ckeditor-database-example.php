<?phperror_reporting( E_ALL );
require_once( 'wdid_php_classes/' . 'include_all_wdid_classes.php' );

use \wdid\DatabaseConnectionInfo as DatabaseConnectionInfo;
use \wdid\DatabaseManager as DatabaseManager;
use \wdid\Utils as Utils;
use \wdid\Duck as Duck;
//////////////////////////////////////  Html for $open_from_obfunction globalGetBody(){ob_start();?></head>
<body>

	<form
		action="ckeditor-database-example.php"
		method="post"
		>

		<textarea name="ckeditor">
		</textarea>
		<input type="submit" value="Save">
	</form>
    <p id="ajaxExampleSetEditorToPresetText" >Ajax Example - Set Editor To Preset Text</p>
    <p id="ajaxExampleCensorTextInEditor" >Ajax Example - Censor Text In Editor</p>    <a href="ckeditor-database-example.php?nuke=1">        Nuke the entire database!    </a>
	<script>
		//// note, typically do this in OnReady
		//// or something like that, inside your
		//// main website class, this is just a // simple example!
		var ckeditor;
		//// Create an instance of the editor
		ckeditor = CKEDITOR.replace(
			'ckeditor', {lang:'en'}
		);
		ckeditor.setData( phpVars.ckeditorData );
		//// CSS won't match page, so eliminate it
		ckeditor.config.contentsCss = "";
		//// We could attach some css as well
		// ckeditor.addContentsCss( "you-css-here.css" )        
        $('#ajaxExampleSetEditorToPresetText').click( function(){
            $.ajax({
                url: "ckeditor-database-example.php",
                method: "POST",
                data: {'action':'SetEditorToPresetText'},
                success: function(response){
                    var r = JSON.parse( response );
                    var newData = r['ckeditorReplacement'];
                    ckeditor.setData( newData )
                }
            });
        });
        $('#ajaxExampleCensorTextInEditor').click( function(){
            $.ajax({
                url: "ckeditor-database-example.php",
                method: "POST",
                data: {                    'action':'CensorTextInEditor',                    'ckeditorData':ckeditor.getData()                },
                success: function(response){
                    var r = JSON.parse( response );
                    var newData = r['ckeditorData'];
                    ckeditor.setData( newData )
                }
            });
        });
	</script>    <br>    <?php$body_from_ob = ob_get_contents();echo " ";ob_end_clean();return $body_from_ob;}class CkEditorExampleWebpage extends Duck {    public $ckeditorData = "";    public function __construct( $opts ){        //// info must be given, so correct to error if no key        $this->connectionInfo = $opts['connectionInfo'];    }
    public function    process(){        if (  Utils::IsAjax()  ){
            $this->processAjax();        }        else $this->processPage();    }    public function processAjax(){        $action = Utils::GetWDefaultNoRefKeyOrFallback( $_POST, 'action', '' );        switch($action) {
            case 'SetEditorToPresetText':
                $this->respondToSetEditorToPresetText($action);
                break;
            case 'CensorTextInEditor':
                $this->respondToCensorTextInEditor($action);
                break;            default:                echo "";        }    }
    public function
    respondToCensorTextInEditor($action){        $ckeditorData = Utils::GetWDefaultNoRefKeyOrFallback( $_POST, 'ckeditorData', '' );
        $ckeditorData = str_replace( "hell", "heck", $ckeditorData );        $r = ['ckeditorData'=>$ckeditorData];
        $response = json_encode( $r );
        echo $response;
    }
    public function
    respondToSetEditorToPresetText($action){
        $r = ['ckeditorReplacement'=>'this was generated by ajax response'];
        $response = json_encode( $r );
        echo $response;
    }    public function    processPage(){        /////////////////////        //// Continue default processing if not an ajax request        ////        //// We could do something to save to files, as shown in other        //// example.        //$this->syncCkeditorDataToFile();        $this->dbMan = new wdid\DatabaseManager( $this->connectionInfo );
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
        echo '<head>' . "\n";
        echo '<meta charset="utf8">' . "\n";
        echo '<title> CKEditor Simplified Example	</title>' . "\n";
        echo '<script src="ckeditor/ckeditor.js"></script>' . "\n";
        echo '<script src="js/jquery/jquery.js"></script>' . "\n";

		echo $this->getPhpVarsScript();        echo '</head>';        echo globalGetBody();        echo '</html>';
    }}
$host = 'localhost';
$dbName = 'ckeditor';
$user = 'root';
$pass = 'wdid00wdid';
$connectionInfo = new wdid\DatabaseConnectionInfo( $host , $dbName, $user, $pass );$opts = ["connectionInfo"=>$connectionInfo];$webpage = new CkeditorExampleWebpage( $opts );$webpage->process();