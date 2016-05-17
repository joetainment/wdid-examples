<?php


namespace wdid;

require_once( 'Inclusion.class.php' );

class ConfigInclusion extends Inclusion {
    
    public $title;
    public $menu;
    
    public $doIncludePhpSelfDotCPage = true;
    public $doIncludeDefaultHeadStyles = true;
    public $doIncludeDefaultHeadScripts = true;
    
    public $defaultHeadScripts = 'default.head_scripts.php';
    public $defaultHeadStyles = 'default.head_styles.php';
    
   
    public function
    __construct($filename, $data=[]){
        parent::__construct($filename,$data);
    }
}

