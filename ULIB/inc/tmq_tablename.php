<?php // พ
function tmq_tablename($tables, $i) {
	global $dbmode;
	if ($dbmode=="mysql") {
		return mysql_tablename($tables, $i);
	}
	if ($dbmode=="mysqli") {
		
		//$tmp=mysqli_data_seek($tables,$i-1);
     // $tmp2=mysqli_fetch_array($tables);
      //printr($tmp2);
      $tmp=$tables[$i];
		//echo "[$tmp]";
		return $tmp;
	}
}
?>