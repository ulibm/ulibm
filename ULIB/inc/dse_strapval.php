<?php // พ
function dse_strapval() {
	$x=barcodeval_get("DSE-versioncontrol");
	if (trim($x)=="") {
		barcodeval_set("DSE-versioncontrol",base64_encode("misscontrol"));
	}
}
?>