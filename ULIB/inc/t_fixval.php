<?php // พ
function t_fixval($val,$field,$tb) {
	global $_TTBSTRUCTARR;
	global $dbmode;
	$tb=$tb["select"][0][a].$tb["insert"][0][a].$tb["update"][0][a].$tb["delete"][0][a];
	//echo "<br>t_fixval($val,$field,$tb)";
	if ($dbmode=="pgsql" && !is_array($_TTBSTRUCTARR[$tb])) {
		$_TTBSTRUCTARR[$tb]=Array();
		$res=tmq("SELECT * FROM $tb LIMIT 0");
		$i = pg_num_fields($res);
		for ($j = 0; $j < $i; $j++) 
		{
		   $_TTBSTRUCTARR[$tb][pg_field_name($res, $j)]=strtolower(pg_field_type($res, $j));
		}
		//printr($_TTBSTRUCTARR); die;
	}
	if ($dbmode=="mysql" || $dbmode=="mysqli") {
		$thesign="\"";
	}
	if ($dbmode=="pgsql") {
		$thesign="'";
	}
	if ($_TTBSTRUCTARR[$tb][$field]=="varchar" 
		||$_TTBSTRUCTARR[$tb][$field]=="text" 
		||$_TTBSTRUCTARR[$tb][$field]=="bpchar" 
		|| false) {
		if ($dbmode=="mysql" || $dbmode=="mysqli") {
			$val=mysql_escape_string($val);
		}
		if ($dbmode=="pgsql") {
			$val=pg_escape_string($val);
		}
		$val="$thesign$val$thesign";
	}
	if ($_TTBSTRUCTARR[$tb][$field]=="float8" 
		||$_TTBSTRUCTARR[$tb][$field]=="int8" 
		|| false) {
		if (trim($val)=="") {
			$val=0;
		}
		//$val="$thesign$val$thesign";
	}

	return $val;
}
?>