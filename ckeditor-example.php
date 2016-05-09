<!DOCTYPE html>
<html>


<?php
	error_reporting( E_ALL );
	

	//// Getting the data from $_POST
	//// and saving it, save vars as empty
	//// strings if no data
			//$sep = "\\";  //// remember to add code for posix platforms!
					//// posix support would need to go here
					//// a simple example is below
	$sep = DIRECTORY_SEPARATOR;
	$ckeditorName = 'ckeditor';
	$ckeditorData = "";
	$ckeditorSaveFile = __DIR__ . $sep . 'ckeditor-save.html';
	////
	if (  array_key_exists($ckeditorName, $_POST)  ){
		$ckeditorData = $_POST[ $ckeditorName ];
		//// we could add data filters here
		//// since hackers could send bad data
		touch( $ckeditorSaveFile );
		file_put_contents( $ckeditorSaveFile, $ckeditorData );
	}
	else if (  file_exists($ckeditorSaveFile)  ){
		$ckeditorData = file_get_contents( $ckeditorSaveFile );
	}
	//// Now that we have the data
	//// JSON encode some data for javascript
	$phpVarsJson = json_encode([
		'ckeditorData' => $ckeditorData,
		'testKey' => 'testValue'
	]);
	//// Send the data to javascript in the head tag...
?>


<head>
	<meta charset="utf8">
	<title>
		CKEditor Simplified Example
	</title>
	<script src="ckeditor/ckeditor.js"></script>

	<?php
		//// Note to Joe, get this working with
		//// proper JSON parse command
		echo			
			"<script>"
			. "var phpVars ="
			. $phpVarsJson
			. ";"
			. "</script>"
		;
	?>

</head>
<body>

	<form
		action="ckeditor-example.php"
		method="post"
		>

		<textarea name="ckeditor">
		</textarea>
		<input type="submit">
	</form>
	<script>
		//// note, typically do this in OnReady
		//// or something like that, inside your
		//// main website class, this is just a // simple example!
		var ckeditor;
		//// Create an instance of the editor
		ckeditor = CKEDITOR.replace(
			'ckeditor', {lang:'en'}
		);
		ckeditor.setData( phpVars.ckeditorData );
		//// CSS won't match page, so eliminate it
		ckeditor.config.contentsCss = "";
		//// We could attach some css as well
		// ckeditor.addContentsCss( "you-css-here.css" )
	</script>

	<?php
		echo "<br><br><br><br>";
		echo $ckeditorData;
		echo "<br><br><br><br>";
		echo "File saved to was:  " . $ckeditorSaveFile;
		echo "<br><br><br><br>";
		echo file_get_contents( $ckeditorSaveFile );
	?>

	


</body>
</html>