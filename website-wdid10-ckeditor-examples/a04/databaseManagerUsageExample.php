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



// In this simple example, the constructor does everything we need
$host = 'localhost';
$dbName = 'website_wdid10_ckeditor_examples_``a04';
$user = 'root';
$pass = '';

$connectionInfo = new DatabaseConnectionInfo( $host , $dbName, $user, $pass );
$dbMan = new DatabaseManager( $connectionInfo );


