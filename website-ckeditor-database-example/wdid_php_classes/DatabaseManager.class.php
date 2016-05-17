<?php

namespace wdid;
require_once( __DIR__ . '/' . 'redBeanPhp/rb.php');
require_once( __DIR__ . '/' . 'DatabaseConnectionInfo.class.php');


class DatabaseManager {

    public $toolbox = null;
    public $adapter = null;
    public $rb = null;
    public $connectionInfo;

    
    public function
    __construct( $connectionInfo, $autoConnect=true ){
        $this->connectionInfo = $connectionInfo;
        //if ($autoConnect===true){
        //    $this->connectToOrCreateDb( );
        //    $this->notOrm = new NotORM( $this->pdo );
        //}
    }

    public function
    connect( $connectionInfo = null,
             $autoCreateDatabase=true,
             $connectOnlyToServerNotDatabase=false
        ){
        if ($connectionInfo!==null) $c = $connectionInfo;
        else $c = $this->connectionInfo;

        //// Setup some variables to put together strings with
        $space = ' ';

        $flagProtocol = ':';
        $flagEquals = '=';
        $flagSep = ';';
        $flagDbType = 'mysql';  //could support others later
        $flagHost = 'host';
        $flagName = 'dbname';
        $flagCharset = 'charset';

        //// Build connect strings, one with a name, one without
        $c1 = $flagDbType . $flagProtocol
            . $flagHost . $flagEquals . $c->host . $flagSep
        ;
        $c2 = $flagCharset . $flagEquals . $c->charset;
        $cName = $flagName . $flagEquals . $c->name . $flagSep;
        $connectStrWithName = $c1 . $cName . $c2;
        $connectStrNoName = $c1 . $c2;
        
        
        if ($connectOnlyToServerNotDatabase===true){
            \R::setup( $connectStrNoName, $c->user, $c->pass );
            $this->toolbox = \R::getToolBox();
        }
        else if ($autoCreateDatabase=false){
            \R::setup( $connectStrWithName, $c->user, $c->pass );
            $this->toolbox = \R::getToolBox();
        }
        else if ($autoCreateDatabase=true){
            $pdo =  new \PDO( $connectStrNoName, $c->user, $c->pass );
            $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $nameFixedSyntax = "`" . str_replace("`","``",$c->name) . "`";
            $pdo->query('CREATE DATABASE IF NOT EXISTS ' . $c->name);
            $pdo->query('use' . $space . $nameFixedSyntax );
            $pdo->query(  "SET @@global.sql_mode= '';"  );
            $pdo = null;

            \R::setup( $connectStrWithName, $c->user, $c->pass );
            $this->toolbox = \R::getToolBox();
        }

        $this->adapter = $this->toolbox->getDatabaseAdapter();
        $this->writer = $this->toolbox->getWriter();
        $this->rb = $this->toolbox->getRedBean();

        return $this->toolbox;
    }


    public function
    getCurrentDatabase(){
        $q = $this->adapter->get(  'SELECT DATABASE();'  );
        ////  The result we get back looks like:
        //// 0 : array(1) { ["DATABASE()"]=> string(9) "ckeditor2" } 
        //// So we grab our result back!
        $arr1 = $q;
        $arr2 = $arr1[0];
        $r = $arr2["DATABASE()"];
        return $r;
    }

    public function
    getAllDatabases(){
        $q = $this->adapter->get(  'SHOW DATABASES;'  );
        $r = [];
        ////  The result we get back looks like:
        //// 0 : array(1) { ["DATABASE()"]=> string(9) "ckeditor2" } 
        //// So we grab our result back!
        foreach( $q as $key=>$value ){
            array_push( $r,  $value["Database"] );
        }
        return $r;
    }
}
