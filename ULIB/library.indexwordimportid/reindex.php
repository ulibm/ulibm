<?php 
ini_set("max_execution_time",600);

    ;// พ
	include ("../inc/config.inc.php");
	$_REQPERM="indexwordimportid";
	html_start();
	$tmp=mn_lib();
	pagesection($tmp);

 if($ID!='')  

    {  

	if ($ID=="[EMPTY]") {
		$ID="";
	}
	$s=tmq("select * from indexword where importdt='$ID' ");
	while ($r=tmq_fetch_array($s)) {
		tmq("update indexword set usoundex='".usoundex_get($r[word1])."' where id='$r[id]' ");
	}
/////////////////////////////////////////////

}
//die;
redir("index.php");
?> 