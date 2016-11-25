<?php 
    ;
	include ("../inc/config.inc.php");
	mn_root("subjextractedimportid");

	if ($ID=="[EMPTY]") {
		$ID="";
	}
	$ID=urldecode($ID);
     $sql ="delete from index_subjextract where importid='$ID'" ;  

// พ
    

tmq($sql,false);
redir("index.php");
?>