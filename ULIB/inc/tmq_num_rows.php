<?php // พ
function tmq_num_rows($t) {
	global $dbmode;
	//echo "[$dbmode]";
	/*if ($tmp == null) {
		return 0;
	}*/

	if ($dbmode=="mysql") {
		return mysql_num_rows($t);
	}
	if ($dbmode=="mysqli") {
		if (is_array($t)) {
			//echo "array";
			return count($t);
		}
		$tmp=mysqli_num_rows($t); 
		if ($tmp == false) {
			$tmp=0;
		}
		//echo "mysqli_num_rows=[$tmp];";
		return floor($tmp);
	}
}
function tnr($t) {
	global $dbmode;
	return tmq_num_rows($t);
}
?>