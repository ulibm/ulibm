<?php // พ
function download_tofile($file_source,$fname) {
	global $dcrs;
	$file_target=$fname;
	$rh = fopen($file_source, 'rb');
	$wh = fopen($file_target, 'wb+');
        if ($rh===false) {
			//echo "download_tofile($file_source,$fname) error open source.";
			// error reading or opening file
           return false;
        }
        if ($wh===false) {
			//echo "download_tofile($file_source,$fname) error.open target for save";
			// error reading or opening file
           return false;
        }
        while (!feof($rh)) {
            if (fwrite($wh, fread($rh, 1024)) === FALSE) {
                   // 'Download error: Cannot write to file ('.$file_target.')';
                   return false;
		   }
        }
        fclose($rh);
        fclose($wh);
        // No error
        return true;
    }
    ?>