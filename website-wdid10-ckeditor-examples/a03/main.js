class CKEditorSimpleExample {

	constructor(){
		//// what I want to do, if I'm using Jquery
		//// is I want to respond to Jquery's onReady
		//// event
		////
		//// This is a way of ensuring that our code
		//// doesn't run until the time that jquery is
		//// ready.
        //// Most event handlers should use bind(this) 
        //// or some form of this/that/self workaround
        //// so that they can continue to refer to this
        //// instance of this class        
		$(document).ready( this.ready.bind(this) );

	}

	ready(){

		//console.log( 'ready is running');
		//// CKEDITOR is a global variable made
		//// by the CKEditor script, so it's always
		//// available.
		////  We will get back an instance
		////  of the CKEditor.editor class,
        ////  which we will store on 'this'
		this.ckeditor = CKEDITOR.replace( 'editor1' );

        $('#clear').on(  'click', this.onClearButtonClicked.bind(this)  );

        $('#SimpleRequestButton').on( 'click',
            this.onSimpleRequestButtonClicked.bind(this)
        );
        
	}
    
    onClearButtonClicked(){
        this.ckeditor.setData('');
    }
    
    
    onSimpleRequestButtonClicked(){
        $.ajax({
            url: "",
            method: "POST",
            data: {
                'action':'SimpleRequest',
            },
            success: this.onSimpleRequestResponse.bind(this)
        });
    }
    
    onSimpleRequestResponse(response){
        var r = JSON.parse( response );
        var responseText = r['responseText'];
        $( "#SimpleRequestResponseDiv" ).html( responseText );
    }
    
    
}

//console.log( 'About to create ckeditor' );
var myCKEditorSimpleExample = new CKEditorSimpleExample();
