<?php


//// In case the cli script is running
////  from a separate current working directory
require_once( __DIR__ . '/wdid_php_classes/' . 'Utils.class.php' );
require_once( __DIR__ . '/wdid_php_classes/' . 'Duck.class.php' );

use \wdid\Utils as Utils;
use \wdid\Duck as Duck;


echo 'Hello World!' . "\n";



$dirContents = scandir(__DIR__);

$files = [];
$dirs = [];

foreach ($dirContents  as  $key=>$value ){
    if ($value!=='..' && $value!=='.'){
        if (  is_dir( __DIR__ . '/' . $value )!==true ){
            array_push( $files, $value );
        }
        else {
            array_push( $dirs, $value );
        }
    }  
}

echo "\n" . "\n" . "Files:" . "\n";
foreach ( $files  as  $key=>$value ){
    echo $value . "\n";
}

echo "\n" . "\n" . "Folders:" . "\n";
foreach ( $dirs  as  $key=>$value ){
    echo $value . "\n";
}




