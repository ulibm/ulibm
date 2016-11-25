<?php  //พ
function tmq($q,$isshow = "",$link_identifier="none") {
	///$isshow=true;
	//ConnDB();
	//global $IPADDR; if ($IPADDR=="10.112.223.166") {$isshow=true;}
	global $_SESSION;
	global $_POST;
	global $_GET;
	global $dbname;
	global $dbmode;
	global $_autosave_dbsql;
	global $conn;
	if ($link_identifier=="none") {
		$link_identifier=$conn;
	}
	//echo $link_identifier;
	if ($dbmode="mysql") {
		$tmp=mysql_query( $q,$link_identifier);
	} 
	if ($dbmode="mysqli") {
		$tmp=mysqli_query( $q,$link_identifier);
	} 
	//$tmp=mysql_db_query($dbname, $q);
	$tmpe=tmq_error();
	if ($tmpe!="") {
		echo "<FONT COLOR=red>".$tmpe."</FONT><HR><PRE>$q</PRE>";
	}
	if ($isshow!="") {
		echo "<BLOCKQUOTE><PRE>$q</PRE></BLOCKQUOTE>";
	}

	return $tmp;
}
function tmq_error() {
	global $dbmode;
	if ($dbmode=="mysql") {
		return mysql_error();
	}
	if ($dbmode=="mysqli") {
		return mysqli_error();
	}
}

?>