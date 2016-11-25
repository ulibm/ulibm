<?php // พ
function tmq_insert_id() {
	global $dbmode;
	if ($dbmode=="mysql") {
		$tmpnewid=tmq("select LAST_INSERT_ID() as xx");
		$tmpnewid=tmq_fetch_array($tmpnewid);
		//printr($tmpnewid);
		return floor($tmpnewid[xx]);
	}
	if ($dbmode=="mysqli") {
		global $tmq_last_activelink;
		return mysqli_insert_id($tmq_last_activelink);
	}
}
?>