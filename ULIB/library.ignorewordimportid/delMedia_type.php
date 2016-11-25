<?php 
    ;
	include ("../inc/config.inc.php");
	$_REQPERM="ignorewordimportid";
	$tmp=mn_lib();// พ

	if ($ID=="[EMPTY]") {
		$ID="";
	}
     $sql ="delete from ignoreword where importdt='$ID'" ;  


    

 tmq($sql);
 redir("index.php");
?>