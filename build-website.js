//// Includes via RequireJSvar ChildProcess = require('child_process');var Sh = require('shelljs');var ckeditorExampleInfo = {    name:'ckeditor-database-example',    file:'build-website-ckeditor-database-example'};var args = process.argv;console.log( Sh.pwd() );switch (process.argv[2]) {    case ckeditorExampleInfo.name:        var command = 'coffee -c '+ ckeditorExampleInfo.file+'.coffee';        console.log( command );        ChildProcess.execSync( command )        ChildProcess.execSync( 'node '+ ckeditorExampleInfo.file+'.js' )        break;    default:        console.log( "available builds: \n"            + ckeditorStr        );    }