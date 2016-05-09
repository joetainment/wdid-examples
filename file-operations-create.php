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

