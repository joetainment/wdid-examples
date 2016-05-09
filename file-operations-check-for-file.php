<?php

	//// Get the current *working* folder
	$sep = "\\"; //// win only
				//// conditional logic for platform needed
	$cwd = getcwd();
	$magicVarDir = __DIR__;
	$fileNoPathStr = "file-operations.txt";
	$fileWithPathStr = $cwd . $sep . $fileNoPathStr;
	$exists = file_exists( $fileWithPathStr );

	echo "Check for file in CWD: " . $fileNoPathStr;
	
	if ($exists) echo "<br> File exists!";
	else  echo "<br> File does not exist!";
	echo "<br><br><br>";
	if ($exists) echo "<br> File exists!";
	else  echo "<br> File does not exist!";
	echo "<br><br><br>";

