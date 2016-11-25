<?php // พ
function tmq_list_tables($dbname_local="") {
	////func("tmq_list_tables()");
	global $host;
	global $user;
	global $passwd;
	global $dbmode;
	global $dbname;
	if ($dbmode=="mysql") {
		if ($dbname_local=="") {
			$dbname_local=$dbname;
		}
		//echo "$dcr_dbname_local";
		//$result = mysql_list_tables($dbname_local);
		$result = tmq("show tables;");
		$rt=Array();
		while ($r=tfa($result)) {
			//printr($r);
			$rt[]=$r[0];
		}
		return $rt;
	}
	if ($dbmode=="mysqli") {
		if ($dbname_local=="") {
			$dbname_local=$dbname;
		}
		//echo "$dcr_dbname_local";
		//$result = mysql_list_tables($dbname_local);

		$link=tmq_connect($host,$user,$passwd,true);
		$link=tmq_select_db($dbname,$link);
		$result = tmq("show tables;",false,$link);
		$rt=Array();
		while ($r=tfa($result)) {
			//printr($r);
			$rt[]=$r[0];
		}
		return $rt;
	}
}
?>