<?php // พ
function tmq_fetch_array($s,$isshow=false) {
	global $_PREVIOUSLY_EXEC_SQL;
	global $conn;
	global $dbmode;
	//echo "[$dbmode]";
	if ($dbmode=="mysql") {
		$tmp=mysql_fetch_array($s);
		if ($isshow=="yes") {
			echo "tmq_fetch_array()<br>";
			var_dump($tmp);
		}
		return $tmp;
	}
	if ($dbmode=="mysqli") {
		$tmp=mysqli_fetch_array($s);
		//$tmp = mysqli_fetch_assoc($s);
		//echo "here";
		//printr($tmp);
		if ($isshow=="yes") {
			echo "tmq_fetch_array()<br>";
			var_dump($tmp);
		}
		return $tmp;
	}
	/*
	if ($tmp!=false) {
		return $tmp;
	} else {
		echo "<B>tmq_fetch_array</B> error <BR>_PREVIOUSLY_EXEC_SQL = <PRE>$_PREVIOUSLY_EXEC_SQL</PRE>";
		die;
	}
	*/
}
function tfa($s,$isshow=false) {
	return tmq_fetch_array($s,$isshow);
}
?>