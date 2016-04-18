## Define classes and functions
##    these will be instantiated afterwards

class RestructionWebsite
    constructor: ->
        @name = "Restruction Website Main Class Instance"
        @doc = $(document)
        @win = $(window)
        @bg_image_org_width = 600
        @bg_image_org_height = 400
        @bottom_strip_height = 57
        @bg_image_mod_width = $("document").width()
        @bg_image_mod_height = $("document").height()
        @image_at_bottom_offset = 12
        @min_content_height = 450

        @doc.bind( "ready", {"self":this}, @onReady  ) 
        @win.bind( "resize", {"self":this}, @onWindowResize  )
        
        
    onWindowResize:(e)=>
        #alert("resizing")
        @fixElementsForWindowSize()
        
    fixElementsForWindowSize: =>
        @fixBgImgSize()
        @fixMenuWidth()
        @fixBottomStrip()
        
        

      
    fixBgImgSize: =>              
        w = $(window).width()
        h = $(window).height() - 100  ## Account for black bars
        ow = @bg_image_org_width
        oh = @bg_image_org_height

        if   (w/ow)  <  (h/oh)
            @bg_image_mod_height = h
            @bg_image_mod_width = h*(ow/oh)
        else
            @bg_image_mod_height = w*(oh/ow)
            @bg_image_mod_width = w

        $(".page_bg_img").css( "width": @bg_image_mod_width , "height": @bg_image_mod_height )
      
        #console.log( @bg_image_mod_width + "" )
    
    fixBottomStrip: =>
        bottom_height = @bottom_strip_height
        win_height = $(window).height()
        bottom_height = Math.min( bottom_height, (win_height*win_height) / 1400 )
        $("div.strips_bottom_overlay").css( "height": bottom_height )
        
    
    
    fixMenuWidth: =>
        width = 1000
        win_width = $(window).width()
        width = Math.min( width, win_width )
        
        ## Fix width of div around menu text
        $("div.menus_top").css( "width": width )
        
        ## Fix margin of logo beside menu
        if width > 800
            $("div.menus_top").css( "margin-left": "auto" )
        else
            $("div.menus_top").css( "margin-left": 0 )
        
        
        ## Fix menu text size 
        
        
        if width > 580
            $("div.menus_top").css( "font-size": 13+"px" )
            $("div.menus_top ul li").css( "margin-left": 20 )                        
        else if width > 440
            $("div.menus_top").css( "font-size": 10+"px" )    
            $("div.menus_top ul li").css( "margin-left": 10 )            
        else if width > 300
            $("div.menus_top").css( "font-size": 8+"px" )
            $("div.menus_top ul li").css( "margin-left": 5 )            
        else
            $("div.menus_top").css( "font-size": 5.5+"px" )
            $("div.menus_top ul li").css( "margin-left": 3 )            
            
        #console.log("width")

    
    
    onReady: (e)=>
        
        ## Fix Elements So They Work Well Based On The Window Size
        this.fixElementsForWindowSize()
        
        ## Start cycling the slideshow/animation of page bg images
        $(".slideshow").cycle( {'timeout':6000 , 'random':true } )
        
        
        ## Disabled test of the e function argument, the current event
        #alert( e )
        #alert( "test alert" )

        
        ## Hide any broken images in the projects listings
        $("div.projects_listing img").error(  (e)=>  $(e.target).hide() )
            ## currentTarget doesn't work here
        

        
        $(".ui__folding_next_subheading").click( (e)=> 
            $(e.target).next().toggle(0)
            #$(e.target).closest(".about_page__folding_content").toggle(800)
            #$(this).closest(".about_page__folding_content").toggle()
        )
        
        ##$(this).closest("div").find(".about_page__folding_content").slideToggle()
        
        
        

## Create an instance of the website,
## jquery 'ready' stuff is handled in the constructor

website = new RestructionWebsite









##########################################
##  Notes
###########################
##
##  todo:
##    move menu to the left it window is smaller size
##
##    rescale bg image
##  Run a method on something being cycled through by using the e
##    $(e.target).hide()  ## currentTarget doesn't work here