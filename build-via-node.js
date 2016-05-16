//// Includes via RequireJS
var fs = require('fs.extra');
var sh = require('shelljs');
var ug = require('uglify-js');



// These ones are easy, since we just recursive copy the folders                                                                                                                                       
sh.cp( '-R', 'bower_components/ckeditor', 'js/lib/' );                                                                                  
sh.cp( '-R', 'bower_components/classify/dist/*', 'js/lib/classify/' );                                                                             
sh.cp( 'bower_components/requirejs/require.js', 'js/lib/requirejs/require.js' );                                                       
                                                                                                                                       


// A couple of them need to be manually minified, so, our script can do that
var minifiedRequire = ug.minify( 'bower_components/requirejs/require.js' );
fs.writeFileSync( 'js/lib/requirejs/require.min.js', minifiedRequire.code );
fs.writeFileSync( 'js/lib/requirejs/require.min.map', minifiedRequire.map );
sh.cp( 'bower_components/requirejs/require.js',  'js/lib/requirejs/require.js' );

var minifiedJquery = ug.minify( 'bower_components/jquery/dist/jquery.js' );
fs.writeFileSync( 'js/lib/jquery/jquery.min.js', minifiedJquery.code );
fs.writeFileSync( 'js/lib/jquery/jquery.min.map', minifiedJquery.map );
sh.cp( 'bower_components/jquery/dist/jquery.js',  'js/lib/jquery/jquery.js' );


var minifiedBootstrap = ug.minify( 'bower_components/bootstrap/dist/js/bootstrap.js' );
fs.writeFileSync( 'js/lib/bootstrap/bootstrap.min.js', minifiedBootstrap.code );
fs.writeFileSync( 'js/lib/bootstrap/bootstrap.min.map', minifiedBootstrap.map );
sh.cp( 'bower_components/bootstrap/dist/js/bootstrap.js', 'js/lib/bootstrap/bootstrap.js' );


sh.cp( 'bower_components/bootstrap/dist/css/bootstrap.min.css', 'css/bootstrap/bootstrap.min.css' );
sh.cp( 'bower_components/bootstrap/dist/css/bootstrap.min.css.map', 'css/bootstrap/bootstrap.min.css.map' );
sh.cp( 'bower_components/bootstrap/dist/css/bootstrap-theme.min.css', 'css/bootstrap/bootstrap-theme.min.css' );
sh.cp( 'bower_components/bootstrap/dist/css/bootstrap-theme.min.css.map', 'css/bootstrap/bootstrap-theme.min.css.map' );






//console.log( sh.pwd() );


//sh.echo( 'hello world' );

//sh.echo(  sh.pwd()  );

//sh.cp( 'bower_components/requirejs/require.js', 'js/requirejs/require.js' );

//fs.copy(
//	'./requi
//)
