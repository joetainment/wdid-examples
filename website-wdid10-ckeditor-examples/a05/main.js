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
		this.ckeditor = CKEDITOR.replace( 'ckeditor' );
        if (  window.hasOwnProperty('PhpVars')  ){
            if (  PhpVars.hasOwnProperty('ckeditor')  ){
                this.ckeditor.setData( PhpVars.ckeditor )        
            }
        }
        //// Optionally, here, you could setup CSS for the editor
        /* Look into: 
        CKEDITOR.config.contentsCss
        CKEDITOR.config.bodyClass
        CKEDITOR.config.bodyId
        config.contentsCss = '/css/mystyles.css';
        or
        config.contentsCss = ['/css/mysitestyles.css', '/css/anotherfile.css'];
        */
        
        
        
        // or, try this.ckeditor.setData( PhpVars.ckeditorData );
        //     catch (Exception e ) console.log( e.message );
        $('#clear').on(  'click', this.onClearButtonClicked.bind(this)  );

        $('#SaveRequestButton').on( 'click',
            this.onSaveRequestButtonClicked.bind(this)
        );
        
        
        
        
        
        
        
	}
    
    onClearButtonClicked(){
        this.ckeditor.setData('');
    }
    
    
    onSaveRequestButtonClicked(){
        $.ajax({
            url: "",
            method: "POST",
            data: {
                'action':'SaveRequest',
                'ckeditor': this.ckeditor.getData()
            },
            success: this.onSaveRequestResponse.bind(this)
        });
    }
    
    onSaveRequestResponse(response){
        var r = JSON.parse( response );
        var ckeditor = r['ckeditor'];
        $( "#SaveRequestResponseDiv" ).html( ckeditor );
    }
    
    
}

//console.log( 'About to create ckeditor' );
var myCKEditorSimpleExample = new CKEditorSimpleExample();
