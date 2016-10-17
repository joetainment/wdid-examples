<?php

namespace wdid;

require_once( __DIR__ . '/' .'Utils.class.php' );
require_once( __DIR__ . '/' .'Duck.class.php' );


class Inclusion extends Duck {

	protected $_filename;
	protected $_text;
	protected $_data;

	public function
	__construct( $filename, $data=[ ] ){
		$this->_filename = $filename;
		$this->_data = $data;

		if  (  file_exists($filename)  ) {
			ob_start();  //starts the output buffer
			include( $filename );
			// the included file, could have echoed
			// a bunch of output, we want to get that
			// as a string
			$this->_text = ob_get_contents();
			echo " "; // ensure there is something to clean
			ob_end_clean(); // stop the output buffer and clean it
		}
	}

	public function
	getText(){
		return $this->_text;
	}

	public function
	getData( $key ){
		return $this->_data[ $key ];
	}
	public function
	getDataWDefault( $key, $default ){
		if ( array_key_exists($key, $this->_data) ){
			return $this->_data[ $key ];
		} else return $default;
	}
	public function
	setData( $key, $val ){
		$this->_data[$key] = $val;
	}



}
