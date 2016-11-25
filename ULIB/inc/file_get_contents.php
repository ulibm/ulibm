<?php // พ
if (function_exists('file_get_contents')) {
   //echo "IMAP functions are available.<br />\n";
} else {
	function file_get_contents($filename) {
		$handle = fopen($filename, "rb");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
	}
}
?>