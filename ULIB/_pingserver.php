<?php 
	; 
	include ("inc/config.inc.php");
	$tg=stripslashes($tg);
	$tg=trim(str_remspecialsign($tg));
	if ($tg=="") {
		$tg="pinger.".$_SERVER[REMOTE_ADDR];
	} else {
		$tg="svping.$tg";
	}
	filelogs("LIBLOGIN REPORTED",urldecode($_SERVER[QUERY_STRING]),"$tg");
	// พ 
?>