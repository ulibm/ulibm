<?php // พ
function tmq_error() {
	global $dbmode;
	global $tmq_last_activelink;
	global $conn;
	if ($dbmode=="mysql") {
		return mysql_error();
	}
	if ($dbmode=="mysqli") {
		//echo "tmq_last_activelink=$tmq_last_activelink;";
		return mysqli_error($tmq_last_activelink);
	}
}
?>