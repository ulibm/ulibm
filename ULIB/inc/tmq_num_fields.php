<?php // พ
function tmq_num_fields($s) {
	global $conn;
	global $dbmode;
	if ($dbmode=="mysql") {
		return mysql_num_fields($s);
	}
	if ($dbmode=="mysqli") {
		return mysqli_num_fields($s);
	}
}
?>