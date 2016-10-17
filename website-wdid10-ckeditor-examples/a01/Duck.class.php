<?php

namespace wdid;
//// I intend these, Duck and Utils to be used together
//// so I require from the same folder
require_once( __DIR__ . '/' . 'Utils.class.php' );


//// We'll make a "Duck" type
////  this is just a mostly empty type
////  but with some generic functions that we'd want
////  any of the other types we use to inherit
class Duck {
	//// Note that this function isn't static
	//// that means we can call it on any object
	//// of this type, of it's subtypes

	//// note also that this one starts lowercase, because
	//// it is not static

	public function
	getType(){
		return Utils::GetType( $this );
	}
}


