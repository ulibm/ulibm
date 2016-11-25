<?php 
// พ
function get_library_pic($wh) {
	//echo "[get_library_pic($wh)]";
	global $dcrs;
	global $dcrURL;
	$pics=$dcrs."_tmp/_librarianava/$wh.jpg";
	if (file_exists($pics)) {
		return $dcrURL."_tmp/_librarianava/$wh.jpg";
	} else {
		return $dcrURL."_tmp/_librarianava/default.png";
	}
}

?>