var child_process = require('child_process');//// This function will run if we answer 'y' to the promptfunction runGit( ){        cmds = []
        cmds.push( 'git add --all' )
        cmds.push( 'git commit --all -m "edits"');
        cmds.push( 'git push origin master');

        for ( i in cmds ){
            child_process.execSync( cmds[i] );
        }

        console.log( 'done' );}//// Warn the user and prompt in order to run the function!console.log( "About to add all, commit, and push to origin master!");
console.log( "This is dangerous!");
console.log( "Are you sure?" );process.stdin.resume();
process.stdin.setEncoding('utf8');
var util = require('util');
process.stdin.on('data', function (text) {
    console.log('received data:', util.inspect(text));
    if (text[0] === 'y') {
      runGit();
      process.exit();
    }
});
