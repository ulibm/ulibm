<?php 
ini_set("max_execution_time",600);

    ;
	include ("../inc/config.inc.php");
	mn_root("subjextractedimportid");
// พ
 if($ID!='')  

    {  

	if ($ID=="[EMPTY]") {
		$ID="";
	}
	$s=tmq("select * from index_subjextract where importdt='$ID' ");
	while ($r=tmq_fetch_array($s)) {
		tmq("update index_subjextract set usoundex='".usoundex_get($r[word1])."' where id='$r[id]' ");
	}
/////////////////////////////////////////////

}
//die;
redir("index.php");
?> 