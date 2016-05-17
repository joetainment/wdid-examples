<?php

namespace wdid;

require_once( 'Duck.class.php' );

//// Inclusion class is used to include files that can easily set
//// properties etc by referring to "$this", where this will be
//// the include class itself.
////
//// It is helpful to automatically separate
class Inclusion extends Duck {
    
    protected $_text;
    protected $_data;
    
    public function
    __construct($filename, $data=[]){
        $this->_data = $data;
        if (  file_exists( $filename )  ){
            ob_start();
            include( $filename );
            $this->_text = ob_get_contents();
            //// workaround for errors/notices coming from empty clean.
            //// echo something, then immediate clean and close
            echo " ";  ob_end_clean();  // keep paired up for workaround!
        }
    }

    public function
    getText(){
        return $this->_text;
    }
    
    public function
    setDataByKey( $key, $value ){
        $this->data[$key] = $value;
    }
    public function
    getDataByKey( $key,$withDefault=false,$default=null ){
        if ($withDefault===true){
            return Utils::GetWDefault( $this->data, $key, $default );
        }
        else return $this->data[$key];
    }
}

