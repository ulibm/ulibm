<?php 
	;
	include ("../inc/config.inc.php");// พ
	include ("./local.inc.php");
if ($edit=="") {
	echo "var not found";
	die;
}
tmq("delete from acq_mediasent where acq='$edit'  and status<>'available' ");
	redir("mediaman.list.php?edit=$edit");
?>