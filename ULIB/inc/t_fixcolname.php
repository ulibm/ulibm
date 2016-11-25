<?php  //พ

function t_fixcolname($wh) {
	//echo "<br>t_fixcolname($wh)";
	if (trim(strtolower($wh))=="random()"
	|| trim(strtolower($wh))=="rand()"
	|| trim(strtolower($wh))=="*") {
		return trim($wh);
	}
	$chk=substr($wh,0,1);
	if ($chk=="(") {
		return trim($wh);
	}
	/*if (strtolower(trim($wh))=="and (") {
		return "AND (";
	}*/
	if ($wh=="") {
		return;
	}
	global $dbmode;
	if ($dbmode=="mysql" || $dbmode=="mysqli") {
		$thesign="`";
	}
	if ($dbmode=="pgsql") {
		$thesign="\"";
	}
	$addsign="yes";
	//
	$chkpos = strpos("  ".$wh, "floor(");
	if ($chkpos === false) { } else {
		if ($dbmode=="mysql" || $dbmode=="mysqli") {
			$wh=str_replace("floor(","floor($thesign",$wh);
			$wh=str_replace(")","$thesign)",$wh);
		}
		if ($dbmode=="pgsql") {
			$wh=str_replace("floor(","floor(CAST($thesign",$wh);
			$wh=str_replace(")","$thesign AS decimal))",$wh);
		}
		$addsign="no";
	}
	$chk=strtolower(substr($wh,0,4));
	if ($chk=="and ") {
		$colsname=substr($wh,4);
		$colsname=trim($colsname);
		$colsname=trim($colsname,'"');
		$colsname=trim($colsname,"'");
		if ($addsign=="yes") {
			$wh=" AND $thesign".$colsname."$thesign";
		} else {
			$wh=" AND ".$colsname."";
		}
		return $wh;
	}
	$chk=strtolower(substr($wh,0,3));
	if ($chk=="or ") {
		$colsname=substr($wh,3);
		$colsname=trim($colsname);
		$colsname=trim($colsname,'"');
		$colsname=trim($colsname,"'");
		if ($addsign=="yes") {
			$wh=" OR $thesign".$colsname."$thesign";
		} else {
			$wh=" OR ".$colsname."";
		}
		return $wh;
	}
	$colsname=trim($wh);
	$colsname=trim($colsname,'"');
	$colsname=trim($colsname,"'");
	$colsname="$thesign".$colsname."$thesign";

	return $colsname;
}
?>