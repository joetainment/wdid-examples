<?php
require_once('wdid_php_classes/include_all_wdid_classes.php');////  Keep in mind, using the R:: stuff won't work with multiple instances////  since it's just one facade.  You'd have to be stricter if you wanted////  to work with multiple R instances at once.$host = 'localhost';$dbName = 'ckeditor';$user = 'root';$pass = 'wdid00wdid';$conInfo = new wdid\DatabaseConnectionInfo( $host , $dbName, $user, $pass );$dbMan = new wdid\DatabaseManager( $conInfo );$dbMan->connect();$databases = $dbMan->getAllDatabases();echo '<br><br>Databases on server (available) are:<br>';foreach( $databases as $value ){    echo $value;    echo '<br>';}$d = $dbMan->getCurrentDatabase();echo '<br> connected to database: ' .   $d   .    '<br>';//////////////////////////////////////////////////  Deleting, Wiping, Nuking the Database////$doNuke = true;$doNuke = false;if ( $doNuke===true ){    R::nuke();    //$dbMan->writer->wipeAll();  //// nukes the entire database!    //$dbMan->writer->trashAll( 'pages' );}$type = 'page';$rnd = mt_rand(0,999999999);$title = 'CkEditorPage' . $rnd;$content = 'ck editor ' . $rnd . ' content goes here';$delay = 2323.352345;/////////////////////////////// Setting Values////$doSettingValues = true;if ($doSettingValues===true){        $page = $dbMan->rb->dispense( $type );
    $page->title = $title;
    $page->content = $content;    $dbMan->rb->store( $page );    //$page = $page->fresh();  //// get a fresh copy from the database!}//////////////////////////////////////////  Getting values//////$page = $dbMan->rb->load( 'page', $id );//$pagesFound = R::find( 'page', ' title = ? ', [ 'CkEditorPage' ] );////  Note that this find is not exactly the same as R::find////   the second argument is an array.$pagesFound = $dbMan->rb->find( $type, [], ' title = ? ', [ $title ] );//$pagesFound = $dbMan->rb->find( 'page', ['title'=>[  $title  ]] );if (  count($pagesFound)>0  ){    $page = array_pop( $pagesFound );    echo $page->title;}else echo "<br> No page data found <br>";echo "<br><br><br>All pages found are:  <br>";$pagesFound = $dbMan->rb->find( $type );foreach (  $pagesFound as $value  ){
    echo '<br>' . $value->title;
    echo '<br>' . $value->content;
}/*R::dispense 	RedBean_OODB : dispense 	Dispense a bean
R::load 	RedBean_OODB : load 	Load a bean
R::store 	RedBean_OODB : store 	Store a bean
R::trash 	RedBean_OODB : trash 	Delete a bean
R::find 	RedBean_Finder : find 	Finds a bean
R::exec 	RedBean_Adapter_DBAdapter[1] : exec	Executes SQL
R::getAll 	RedBean_Adapter_DBAdapter[1] : get	Query the database
R::dup 	RedBean_DuplicationManager : setFilters, dup	Duplicate a bean
R::exportAll 	RedBean_DuplicationManager : exportAll	Export beans
R::associate 	RedBean_AssociationManager[2] : associate	Associate two beans
R::tag 	RedBean_TagManager : tag	Tag a bean
R::related 	RedBean_AssociationManager : relatedSimple	Retrieve related beans
R::commit 	RedBean_Adapter_DBAdapter[3] : commit	Commits transaction
R::begin 	RedBean_Adapter_DBAdapter[3] : startTransaction	Begins transaction
R::rollback 	RedBean_Adapter_DBAdapter[3] : rollback	Rolls back a transaction
R::nuke 	RedBean_QueryWriter[4] : wipeAll	Destroys database
R::dependencies	RedBean_OODB : setDepList	Sets dependent beans
R::getColumns 	RedBean_QueryWriter : getColumns	List columns of a table
R::genSlots 	RedBean_SQLHelper[5] : genSlots	Generates slots
R::freeze 	RedBean_OODB : freeze	Freezes the schema*/