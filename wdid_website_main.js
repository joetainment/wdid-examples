// Generated by CoffeeScript 1.10.0
(function() {
  var WdidWebsite, website,
    bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  WdidWebsite = (function() {
    function WdidWebsite() {
      this.onReady = bind(this.onReady, this);
      this.fixBgImgSize = bind(this.fixBgImgSize, this);
      this.onWindowResize = bind(this.onWindowResize, this);
      this.name = "WDID Website";
      this.doc = $(document);
      this.win = $(window);
      this.bg_image_org_width = 600;
      this.bg_image_org_height = 400;
      this.bg_image_mod_width = $("document").width();
      this.bg_image_mod_height = $("document").height();
      this.min_content_height = 450;
      this.doc.bind("ready", {
        "self": this
      }, this.onReady);
      this.win.bind("resize", {
        "self": this
      }, this.onWindowResize);
    }

    WdidWebsite.prototype.onWindowResize = function(e) {};

    WdidWebsite.prototype.fixBgImgSize = function() {
      var classToFix, h, oh, ow, w;
      classToFix = ".page_bg_img";
      w = $(window).width();
      h = $(window).height();
      ow = this.bg_image_org_width;
      oh = this.bg_image_org_height;
      if ((w / ow) < (h / oh)) {
        this.bg_image_mod_height = h;
        this.bg_image_mod_width = h * (ow / oh);
      } else {
        this.bg_image_mod_height = w * (oh / ow);
        this.bg_image_mod_width = w;
      }
      return $(classToFix).css({
        "width": this.bg_image_mod_width,
        "height": this.bg_image_mod_height
      });
    };

    WdidWebsite.prototype.onReady = function(e) {};

    return WdidWebsite;

  })();

  website = new WdidWebsite;

}).call(this);
