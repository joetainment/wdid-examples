<?php

	//// Get the current *working* folder
	$sep = "\\"; //// win only
				//// conditional logic for platform needed
	$cwd = getcwd();
	$magicVarDir = __DIR__;
	$fileNoPathStr = "file-operations.txt";
	$fileWithPathStr = $cwd . $sep . $fileNoPathStr;
	$exists = file_exists( $fileWithPathStr );


	//// Create the file if it doesn't exist!
	if (!$exists) touch( $fileWithPathStr );


	$dataToSave = [
		"schools" => [
			"Vanarts" => [
				'phone'=>6406822787,
				'address'=>[
					'suiteNumber'=>600,
					'streetNumber'=>570,
					'streetName'=>'Dunsmir',
					'streetType'=>'St.',
					'postalCode'=>'V6B1Y1',
					'country'
				],
				'email'=>'contact@vanarts.com'
			]
		]
	];
	$dataJson = json_encode($dataToSave);
	echo $dataJson;

	//// We will save the data into the
	//// Get a handle to the file
	//$fh = fopen( $fileWithPathStr, 'wb'  );
	//// Write to the file using the handle
	//fwrite( $fh, $dataJson );   // optional int for length
	//fclose( $fh );

	file_put_contents( $fileWithPathStr, $dataJson );

	echo "<br>  File saved!  <br>";

	//// Get a handle to the file to open
	//$fh = fopen( $fileWithPathStr, 'rb'  );
	//$fileSize = filesize( $fileWithPathStr );
	//// Read from the file using the handle
	//$read = fread( $fh, $fileSize );   // optional int for length

	//// The fast/easy/simple way to read a file
	$read = file_get_contents( $fileWithPathStr );





	//// Show the contents of the saved file
	echo "<br> Saved file raw contents: <br>";
	echo $read;


	//// Decode the data from json
	//// use true to get it back as nested arrays
	$dataFromJson = json_decode( $read, true );
	var_dump( $dataFromJson );
	var_dump(  $dataFromJson['schools']['Vanarts']  );






	//echo $cwd;
	//echo "<br>";
	//echo $magicVarDir;
	//echo "<br><br><br>";

	//echo "Check for file in CWD: " . $fileNoPathStr;
	
	//if ($exists) echo "<br> File exists!";
	//else  echo "<br> File does not exist!";
	//echo "<br><br><br>";
	//if ($exists) echo "<br> File exists!";
	//else  echo "<br> File does not exist!";
	//echo "<br><br><br>";



	




?>


