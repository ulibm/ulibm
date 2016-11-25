<?php 
    ;// พ
	include ("../inc/config.inc.php");
		if ($ID=="[EMPTY]") {
		 $ID="";
	}
if ($issave=="yes") {

	tmq("delete from member_bin

	where libsite ='$ID'
	");
	redir("media_type.php");
	die;
}
?>