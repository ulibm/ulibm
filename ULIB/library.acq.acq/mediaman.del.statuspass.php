<?php 
	;
	include ("../inc/config.inc.php");
	include ("./local.inc.php");
if ($edit=="") {
	echo "var not found";
	die;
}
tmq("delete from acq_mediasent where acq='$edit'  and status='ได้แล้ว' ");
	redir("mediaman.list.php?edit=$edit");
?>