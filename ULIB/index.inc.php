<?php 
	$setforcehpmode=trim($setforcehpmode);
	if ($setforcehpmode!="") {
		$forcehpmode=$setforcehpmode;
		ulibsess_register("forcehpmode");
		//printr($_SESSION);
		//พ
		redir("$dcrURL"."index.php");
		die;
	}
?>