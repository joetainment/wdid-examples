<?php

// Note that php class files should be
// called  *.class.php
// Ideally, the class name is
// UpperCamelCase

// Generally speaking, have one class
// per file, and have classname match
// filename.

////  Put your classes in a namespace
////  define a new namespace using
////  the namespace keyword
namespace wdid;

//// note that if you want to use
//// other things from
//// from other namespaces you'd need
//// the 'using' keyword.
//// we don't need that so we'll skip it.
//// but it would be something like:
//  using some_namespace;


//// This class, will basically just
//// be used for organization
//// it will be all "static"
//// meaning we won't have any reason
//// to give it methods/members
//// nor instantiate it
class Utils {


	//// Repeat Text As Lines
	// public
	  	//// this means anyone can access it
		//// note this is not for security
		//// just usage patterns
	// static
		//// this means it's not an instance
		//// function, which means we can
		//// call it at any time without
		//// requiring an instance
		////  note the use of a default value for $sep arg
	public static function
	RepeatTextAsLines( $text, $repeats, $sep='<br>'){
		$output = '';
		for ( $i=0; $i<$repeats; $i++ ){
			$output = $output . $text . $sep;
		}
		return $output;
	}

	//// We'll make a function to echo line breaks with <br>
	public static function
	RepeatBr( $repeats=1, $newLineAtEnd=false ){
		//  self:: refers to the current class
		//  and is used for calling static function and vars
		$output = self::RepeatTextAsLines(
			'',  // text
			$repeats,  // repeats
			'<br>',  // sep
			true  // newLineAtEnd
		);
		return $output;
	}

	//// We'll make a function to echo line breaks with <br>
	public static function
	EchoBr( $repeats=1, $newLineAtEnd=false ){
		echo self::RepeatBr($repeats );
	}


	//// Have a couple functions for getting
	//// type and value
	//// and for easy echoing of that info
	public static function
	GetType( $v ){
		//// use php's built in gettype (which works badly)
		//// to get an initial type
		$type_stage_one = gettype( $v );
		$type_final = $type_stage_one;
        //// if it's an object, we need to find
        //// what specific class it is
        if ($type_stage_one === 'object'){
        	//// code to get complex class goes here
        	//// try lets us do something safely
        	//// that might fail and throw an error
        	try {
        		//// get_class is a built in php
        		//// function, that gets the class type
        		$type_stage_two = get_class($v);
        		//// only do the next 'if' part
        		//// when $v is an object
        		//// (we'd get false if it wasn't)
        		if ($type_stage_two!==false){
        			$type_final = $type_stage_two;
        		}
        	}
        	//catch (){}
        	//// Finally runs whether or not
        	//// there was an error
        	finally {
        		return $type_final;
        	}
        }
		return $type_final;
	}


}