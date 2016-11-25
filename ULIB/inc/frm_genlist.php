<?php // พ
function frm_genlist($formname,$sql,$kid,$vid,$localdbname="-localdb-",$allowblank="no",$defval="none",$emponk="",$enponv="non") {
	global $host;
	global $user;
	global $dbname;
	global $passwd;

	if ($localdbname=="") {
		$localdbname="-localdb-";
	}
	//echo "[frm_genlist($formname,$sql,$kid,$vid,$dbname,$allowblank,$defval,$emponk,$enponv)]";

	$s=tmq($sql,false,$localdbname);
	echo "<SELECT NAME='$formname' ID='$formname'>";
	if ($allowblank=="yes") {
		echo "<OPTION VALUE=\"\" >";		
	}
	
	while ($r=tmq_fetch_array($s)) {// printr($r);
		$sl="";
		if ($r[$kid]==$defval) {
			$sl=" selected ";
		}
			echo "<OPTION VALUE=\"$r[$kid]\" $sl ";
			if ($r[$emponk]==$enponv) {
				echo " style='background-color: #DDDDDD; font-weight: bold;' ";
			}
			echo ">".getlang($r[$vid])."</option>";		
	}
	echo "</SELECT>";
}
?>