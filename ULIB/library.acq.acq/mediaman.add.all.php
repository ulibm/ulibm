<?php 
	;
	include ("../inc/config.inc.php");// พ
	include ("./local.inc.php");
if ($edit=="") {
	echo "var not found";
	die;
}

$s=tmq("select * from acq_media");
while ($r=tmq_fetch_array($s)) {
	addmedia($edit,$r[id]);
}

	redir("mediaman.list.php?edit=$edit");
?>