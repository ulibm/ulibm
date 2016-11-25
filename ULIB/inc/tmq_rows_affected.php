<?php // พ
function tmq_rows_affected($s="") {
	global $_PREVIOUSLY_EXEC_SQL;
	global $conn;
	if ($s=="") {
		//echo "here";
		$tmp=mysql_affected_rows();
	} else {
		$tmp=mysql_affected_rows($s);
	}
	return $tmp;
	/*
	if ($tmp!=false) {
		return $tmp;
	} else {
		echo "<B>tmq_fetch_array</B> error <BR>_PREVIOUSLY_EXEC_SQL = <PRE>$_PREVIOUSLY_EXEC_SQL</PRE>";
		die;
	}
	*/
}
function tra($s="") {
	return tmq_rows_affected($s);
}
?>