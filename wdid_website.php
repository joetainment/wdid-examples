<?php
//// If you installed via composer, or another system using autoload
//// just use this code to requrie autoloader on the top of your projects
//require 'vendor/autoload.php';


//// Add requires for custom code and non autoloading classes
////   remember to add use directives if you don't want to have
////   to continually specify namespaces
require_once( 'wdid_php_classes/' . 'include_all_wdid_classes.php' );

use \wdid\Utils as Utils;
use \wdid\Duck as Duck;
use \wdid\Dictionary as Dictionary;
use \wdid\Inclusion as Inclusion;
use \wdid\ConfigInclusion as ConfigInclusion;
use \wdid\Session as Session;
use \wdid\PhpWrapperServerSuperglobal as PhpWrapperServerSuperglobal;
use \wdid\TagGenerator as TagGenerator;
use \wdid\Website as Website;




//// Here is where we could override methods etc
class WdidExampleWebsite extends Website {

}
//// Create an actual instance of the WdidExampleWebsite class
$wdidExampleWebsiteInstance = new WdidExampleWebsite();


