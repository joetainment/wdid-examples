## Remember to be sure this file is encoded either asci or utf-8-bom## utf-8 without bom causes coffeescript trouble!# Includes via RequireJSfs = require('fs')# Note that when requiring from a folder instead of a specific file# we use 'register' in coffeescript for node.jssh = require('node_modules/shelljs').register()console.log( sh.pwd() );# Setup vars for pathssep = '/'base = 'website-ckeditor-database-example'lib = 'js/lib'libPath = base + sep + lib# Ensure existance of libPathsh.mkdir( '-p', libPath )# copy ckeditor from bowersh.mkdir( '-p', libPath+'ckeditor' )sh.cp( '-R', 'bower_components/ckeditor', libPath+sep )# copy classify from bowersh.mkdir( '-p', newBase+sep+'js/lib/classify' )sh.cp( '-R', 'bower_components/classify/dist/*', libPath+'classify'+sep );# copy wdid-php-classessh.cp( '-R', 'wdid-php-classes', base+sep )