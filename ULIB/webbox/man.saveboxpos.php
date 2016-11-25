<?php 
	include("../inc/config.inc.php");
	// พ 
	$tab=arr_filter_remnull($tab);
	//printr($tab);
	printr($_GET);
	@reset($tab);
	while (list($k,$v)=each($tab)) {
		$box=explode(",",$v);
		$box=arr_filter_remnull($box);
		$ordr=0;
		@reset($box);
		while (list($k2,$v2)=each($box)) {
			$boxid=str_replace("webbox","",$v2);
			$s="update webbox_box set tab='$curtab',ordr = '$ordr',col='$k' where id='$boxid' ";
			tmq( $s);
			$ordr=$ordr-1;
		}
	}
?>