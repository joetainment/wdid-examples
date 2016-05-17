//// This script updates this entire repository to git\//// warning, it doesn't use a proper comment name//// so your should squash all the commits together//// if ever pushing this to a real repositor with several//// people working on it.  Either that or modify this//// script to prompt for a commit name.var child_process = require('child_process');//// Run the commands that actually control git////   add all, commit all, and push to origin master////   This function will later only run if we answer 'y' to the promptfunction runGit( ){        //// put all our commands in an array we can execute later        cmds = []
        cmds.push( 'git add --all' )
        cmds.push( 'git commit --all -m "edits"');
        cmds.push( 'git push origin master');
        //// Loop through our commands and execute each one
        for ( i in cmds ){
            child_process.execSync( cmds[i] );
        }
        //// Provide the user with some feedback
        console.log( 'done' );}//// Warn the user and prompt in order to run the function!console.log( "About to add all, commit, and push to origin master!");
console.log( "This is dangerous!");
console.log( "Are you sure? (y key and enter to continue, or n key and enter to quit" );//// This part actually handles the io//// we really just check for the first letter of the response to be//// yprocess.stdin.resume();
process.stdin.setEncoding('utf8');
var util = require('util');
process.stdin.on('data', function (text) {
    //console.log('received data:', util.inspect(text));
    if (text[0] === 'y') {
      runGit();
      process.exit();
    }
    if (text[0] === 'n') {
      process.exit();
    }
});
