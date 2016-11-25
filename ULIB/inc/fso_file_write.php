<?php // พ
function fso_file_write($file,$mode,$ct) {
	$filename = $file;
	$somecontent = $ct;

	// Let's make sure the file exists and is writable first.

		// In our example we're opening $filename in append mode.
		// The file pointer is at the bottom of the file hence 
		// that's where $somecontent will go when we fwrite() it.
		if (!$handle = fopen($filename, $mode)) {
			 echo "Cannot open file ($filename)";
			 exit;
		}

		// Write $somecontent to our opened file.
		if (fwrite($handle, $somecontent) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
		
		//echo "Success, wrote ($somecontent) to file ($filename)";
		
		fclose($handle);

}
?>