<?php // พ
function marc_meltin_item($mid) { 
	global $newline;
	$itemtag=getval("MARC","itemlocatetag");
	$s=tmq("select * from media_mid where pid='$mid' ");
	$str="";	
	//$sql_insert="insert into media_mid set price='$word[p]' ,libsite='$set_libsite', status='$set_status' , place='$set_itemplace' , adminnote='$v2' ";

	while ($r=tmq_fetch_array($s)) {
		$str.="  ^p".floor($r[price])."";
		$str.="^l".floor($r[RESOURCE_TYPE])."";
		$str.="^i".($r[bcode])."".$newline;
	}
	$str=rtrim($str);
	$str=addslashes($str);
	tmq("update media set $itemtag='$str' where ID='$mid' ",false);
}
?>