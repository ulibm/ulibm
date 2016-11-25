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
	$s2=tmq("select * from acq_mediasent where media='$r[id]' ");
	if (tmq_num_rows($s2)==0) {
		addmedia($edit,$r[id]);
	}
}

	redir("mediaman.list.php?edit=$edit");
?>