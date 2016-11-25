<?php 
@include_once("../inc/config.inc.php");// พ


	$_ss=tmq("select * from acqn_stat");
	while ($_sr=tfa($_ss)) {
		$_s[$_sr[code]]=Array();
		$_s[$_sr[code]][name]=$_sr[name];
		$_s[$_sr[code]][color]=$_sr[color];
		$_s[$_sr[code]][bg]=$_sr[bg];
	}

?>