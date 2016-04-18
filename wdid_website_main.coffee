## Define classes and functions
##    these will be instantiated afterwards

class WdidWebsite
    ## constructor is basically a magic name coffeescript uses
    constructor: ->
    
        ##   @.  in coffeescript is like   $this->   in php
        @name = "WDID Website"
        @doc = $(document)
        @win = $(window)
        @bg_image_org_width = 600
        @bg_image_org_height = 400
        @bg_image_mod_width = $("document").width()
        @bg_image_mod_height = $("document").height()
        @min_content_height = 450

        #### Because Jquery often gives troubles with
        #### 'this' var, bind a 'self' bar to mean current this.
        #### (closure style)
        @doc.bind( "ready", {"self":this}, @onReady  ) 
        @win.bind( "resize", {"self":this}, @onWindowResize  )
        
    ## Most methods should use => for definition, ensuring that
    ##   "this" works properly in them
    onWindowResize:(e)=>
        #alert("resizing")
        ##
        ## On window resize, we could potentially run functions to handle
        ##    the resizing
        #@fixBgImgSize()

      
    fixBgImgSize: =>
        #alert( "fixBgImgSize" )
        ## Fix a css class to have it's bg width/height matched to window
        classToFix = ".page_bg_img"
        w = $(window).width()
        h = $(window).height()  #### - 100  ## eg. Account for black bars
        ow = @bg_image_org_width
        oh = @bg_image_org_height

        if   (w/ow)  <  (h/oh)
            @bg_image_mod_height = h
            @bg_image_mod_width = h*(ow/oh)
        else
            @bg_image_mod_height = w*(oh/ow)
            @bg_image_mod_width = w

        $( classToFix ).css( "width": @bg_image_mod_width , "height": @bg_image_mod_height )
    
    
    onReady: (e)=>
        #alert("onReady")
        
        ######## Here's a bunch of currently disabled examples ########
        
        ## Fix Elements So They Work Well Based On The Window Size
        #this.fixElementsForWindowSize()
        
        ## Start cycling the slideshow/animation of page bg images
        #$(".slideshow").cycle( {'timeout':6000 , 'random':true } )
        
        
        ## Disabled test of the e function argument, the current event
        #alert( e )
        #alert( "test alert" )


        #### Here, eventually you could Add more event handlers etc
        #$(".ui__folding_next_subheading").click( (e)=> 
        #    $(e.target).next().toggle(0)
        #    #$(e.target).closest(".about_page__folding_content").toggle(800)
        #    #$(this).closest(".about_page__folding_content").toggle()
        #)
        

## Create an instance of the website,
## jquery 'ready' stuff is handled in the constructor
#console.log("test")
#alert( "test" )
website = new WdidWebsite
