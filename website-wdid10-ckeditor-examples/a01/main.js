class CKEditorSimpleExample {

	constructor(){
		//// what I want to do, if I'm using Jquery
		//// is I want to respond to Jquery's onReady
		//// event
		////
		//// This is a way of ensuring that our code
		//// doesn't run until the time that jquery is
		//// ready.
		$(document).ready( this.ready );
                               //// later, to work around a bug, we'll use:  $(document).ready( this.ready.bind(this) );
                               //// this is an excellent method to use whenever we need methods as event handlers 

	}

	ready(){

		//console.log( 'ready is running');
		//// CKEDITOR is a global variable made
		//// by the CKEditor script, so it's always
		//// available.
		////  We will get back an instance
		////  of the CKEditor.editor class
		var ckeditor = CKEDITOR.replace( 'editor1' );

		//// Later on we will store ckeditor into
		//// a field on this instance of the... we will add that next week
	}
}

//console.log( 'About to create ckeditor' );
var myCKEditorSimpleExample = new CKEditorSimpleExample();
