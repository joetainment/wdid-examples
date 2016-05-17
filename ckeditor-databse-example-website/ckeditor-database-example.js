//// main script for ckeditor-database-example.php//// Define classes using classify////   https://libraries.io/bower/classify////     it is included in this project////     from bower and the build-via-node.js script
var CkeditorDatabaseExample = Classify({    //// constructor first    init : function( ){        $( document ).ready( this.onReady );    },    //// Bound methods... this should be most of them    $$bind$$ : {        //// Event handler methods first, then all others alphabetical        onReady : function(){            this.ckeditorSetup();            this.bindEvents();        },        onResponseForCensorCkeditorText : function (response){                var r = JSON.parse( response );                var newData = r['ckeditorData'];                this.ckeditor.setData( newData )        },                onResponseForSaveCkeditorText : function (response){            //console.log( "saved" );            //console.log( response );        },          onResponseForRevertCkeditorText : function (response){            this.setCkEditorFromResponse( response );        },                onResponseForSetCkeditorToPresetText : function (response){            this.setCkEditorFromResponse( response );        },        
        onCkeditorChange : function(){
            var contents = this.ckeditor.getData();
            $( "#preview" ).html( contents );
        },        createCkeditorInstance : function( name ){            //// Sometimes the replace command can complain about an existing instance            //// even when no instance already exists.  A try and catch will fix it.            var ckeditor;            try {                ckeditor = CKEDITOR.replace( name, {lang:'en'}  );            }            catch(error){                ckeditor = CKEDITOR.instances[name];            }            return ckeditor;        },                setCkEditorFromResponse : function (response){                var r = JSON.parse( response );                var newData = r['ckeditorData'];                this.ckeditor.setData( newData )                    },                ckeditorSetup : function (){
            //// Create an instance of the ckeditor and set its contents
            this.ckeditor = this.createCkeditorInstance('ckeditor');
            this.ckeditor.setData( phpVars.ckeditorData );
            //// CSS won't match page, so eliminate it
            this.ckeditor.config.contentsCss = "";
            //// We could attach some css as well
            // ckeditor.addContentsCss( "you-css-here.css" )
        },                bindEvents: function(){            /////////////////////////////////            //// Binding of Events            
            //// On Editor Change - Real time preview
            this.ckeditor.on( 'change',  this.onCkeditorChange );            this.onCkeditorChange();                                    //// On button pushes            $('#ajaxExampleSaveCkeditorText').bind('click', {self:this}, function(ev){                var self = ev.data.self;                ev.preventDefault();                ev.stopPropagation();                console.log( 'clicked on save' );                $.ajax({                    url: "ckeditor-database-example.php",                    method: "POST",                    data: {'action':'SaveCkeditorText',                            'ckeditor':self.ckeditor.getData()                    },                    success: self.onResponseForSaveCkeditorText                });            });                        $('#ajaxExampleRevertCkeditorText').bind('click', {self:this}, function(ev){                var self = ev.data.self;                ev.preventDefault();                ev.stopPropagation();                console.log( 'clicked on save' );                $.ajax({                    url: "ckeditor-database-example.php",                    method: "POST",                    data: {'action':'RevertCkeditorText',                    },                    success: self.onResponseForRevertCkeditorText                });            });
    
            $('#ajaxExampleSetCkeditorToPresetText').bind('click',{self:this},function(ev){                var self = ev.data.self;
                ev.preventDefault();
                ev.stopPropagation();
                $.ajax({
                    url: "ckeditor-database-example.php",
                    method: "POST",
                    data: {'action':'SetCkeditorToPresetText'},
                    success: self.onResponseForSetCkeditorToPresetText
                });
            });

            $('#ajaxExampleCensorCkeditorText').bind('click', {self:this}, function(ev){
                var self = ev.data.self;                ev.preventDefault();
                ev.stopPropagation();
                $.ajax({
                    url: "ckeditor-database-example.php",
                    method: "POST",
                    data: {
                        'action':'CensorCkeditorText',
                        'ckeditor':self.ckeditor.getData()
                    },
                    success: self.onResponseForCensorCkeditorText
                });
            });        }, // end of bind events method                },  // end of $$bind$$ methods    Undefined:undefined});

var ckeditorDatabaseExample = new CkeditorDatabaseExample( );