<?php

namespace wdid;
require_once( 'Duck.class.php' );
require_once( 'Indenter.class.php' );
require_once( 'Session.class.php' );
require_once( 'TagGenerator.class.php' );
require_once( 'PhpWrapperForServerSuperglobal.class.php' );
require_once( 'Inclusion.class.php' );
require_once( 'ConfigInclusion.class.php' );

class Website extends Duck{

    protected $_tagGenerator;
    protected $_indenter;
    // protected $_authenticator;  //// Authenticator not implemented yet
    //protected $_requestInfo;
    protected $_inclusions;
    protected $_serverSg;
    protected $_currentPageRequestFilenameNoExt;
    protected $_conf;

    public function
    __construct( $autorun=true ){
        //// Initialize some basic helper utilities
        ////
        //$this->_authenticator = new Authenticator();
            //// Authenticator not implemented yet        
        $this->_indenter = new Indenter();
        $this->_tagGenerator = new TagGenerator();
        $this->_serverSg = new PhpWrapperForServerSuperglobal();
        
        //// Initialize the 
        $this->_currentPageRequestFilenameNoExt =
            $this->_serverSg->PHP_SELF_FILENAME;
        
        //// Initialize the ConfigInclusion
        $this->initConf(  );
        
        //// Start a session and get all the relevant information from it
        $this->sessionLoad();
        

        //// Initialize the inclusions we will use in our site
        $this->initInclusions();


        if ($autorun) $this->run();
    }
    
    public function
    __destruct(){
        $this->sessionSave();
    }
    
    public function
    initConf( ){
        ////  note that we use a get function
        ////  here so that later on subclasses can
        ////  override it easily
        $confFilename = $this->getInitConfFilename();
        $defaultConfFileName = $this->getDefaultInitConfFilename();
        if ( file_exists( $confFilename )===true ){
            $this->_conf = new ConfigInclusion( $confFilename );
        }
        else {
            $this->_conf = new ConfigInclusion( $defaultConfFileName );
        }
    }
    
    
    public function
    initInclusions(){
        $this->_inclusions = [];
            //// once a dict class works better,
            //// we should use that ...   new Dict();

        if ( $this->_conf->doIncludeDefaultHeadScripts === true ){
            $this->_inclusions['head_scripts'] = $this->addInc(
                $this->_conf->defaultHeadScripts
            );
        }
        if ( $this->_conf->doIncludeDefaultHeadStyles === true ){
            $this->_inclusions['head_styles'] = $this->addInc(
                $this->_conf->defaultHeadStyles
            );
        }
        //echo $this->_currentPageRequestFilenameNoExt;
        if ( $this->_conf->doIncludePhpSelfDotCPage === true ){
            $this->_inclusions['content'] = $this->addInc(
                $this->_currentPageRequestFilenameNoExt . '.c.php'
            );
        }     
    }
    
    //// Override this to use a different ConfigInclusion filename
    public function
    getInitConfFilename(){
        return $this->_currentPageRequestFilenameNoExt . '.conf.php';        
    }
    //// Override this to use a different default ConfigInclusion filename
    public function
    getDefaultInitConfFilename(){
        return 'default.conf.php';        
    }
    
    public function
    run(){
        $this->session->counter++;
        //$this->_authenticator->authenticate( $username, $passwordHashed);
            //// Authenticator not implemented yet
        $this->draw();
        $this->sessionSave();
    }
    
    public function
    sessionLoad(){
        $loaded = Utils::SessionLoadByKey( 'wdid' );
        if ($loaded === NULL){
            $this->session = new Session;
        } else {
            $this->session = $loaded;
        }
    }
    public function
    sessionSave(){
        Utils::SessionSaveByKey( 'wdid', $this->session );
    }
    
    
    public function
    databaseLoad(){
        // this is the worst way to load from a database, only
        // here as a proxy, use a better way later!
        
    
    }
    
    public function
    databaseSave(){
        // this is the worst way to save to a database, only
        // here as a proxy, use a better way later!
        
    }
    
    public function
    draw(){
    
        $tg = $this->_tagGenerator;
    
        ob_start();
        
        {
            echo $tg->genTagDoctype();
            echo $tg->genTagHtmlOpen();
            echo $tg->genTagHeadOpen();
            echo '<title>' . $this->_conf->title . '</title>' . "\n" ;
            echo $this->_inclusions['head_scripts']->getText()  . "\n";
            echo $this->_inclusions['head_styles']->getText()  . "\n";
            echo $tg->genTagHeadClose()  ;
            echo $tg->genTagBodyOpen()  ;
            echo $this->_inclusions['content']->getText() . "\n";
            echo $tg->genTagBodyClose();
            echo $tg->genTagHtmlClose();
        }
        
        //// get contents with workaround for
        //// ob_get_clean and ob_clean errors
        $rendered = ob_get_contents();  echo " ";  ob_clean();
        
        //// Draw, with optional  "tidy"   drawing
        if ( array_key_exists( 'tidy', $_GET ) === true){
            $config = [
                       'indent'         => true,
                       'output-xhtml'   => true,
                       'wrap'           => 200
            ];

            ////  **** tidy not yet implemented ****
            ////   could use either php5-tidy
            ////   or html purifier
            ////   or htmLawed
            ////   or something else similar
            echo $rendered;
        }
        else {
            echo $rendered;
        }
    }
    
    public function
    addInc( $filename, $data=null ){
        return new Inclusion($filename, $data);
    }
  
}