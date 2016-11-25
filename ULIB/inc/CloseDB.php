<?php // พ
function CloseDB() {
	global $conn;
	if ($dbmode=="mysql") {
		mysql_close($conn);
	}
	if ($dbmode=="mysqli") {
		mysqli_close($conn);
	}
}
?>