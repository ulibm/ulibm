<?php // พ
function tmq_select_db($ui_dbname,$link) {
	global $host;
	global $user;
	global $passwd;
	global $dbname;
	global $dbmode;
	global $dbcoll;

	//for mysqli, var from tmq_connect();
	global $tmq_connect_tthost;
	global $tmq_connect_ttuser;
	global $tmq_connect_ttpasswd;

	$tmpe="";
	if ($dbmode=="mysql") {
	  if ($ui_dbname=="-localdb-") {
	     $ui_dbname=$dbname;
	  }
		return mysql_select_db($ui_dbname,$link);
	}
	if ($dbmode=="mysqli") {
		if ($ui_dbname=="-localdb-") {
			global $conn;
			return $conn;
		}
		$conn=mysqli_connect($tmq_connect_tthost, $tmq_connect_ttuser, $tmq_connect_ttpasswd, $ui_dbname)or ($tmpe= mysqli_error($link));;
		if ($tmpe!="") {
			echo "<FONT COLOR=red>tmq_select_db:$dbmode:".$tmpe."</FONT><HR><PRE>$q</PRE>";
		}
		if ($dbcoll!="") {
			tmq("set names '$dbcoll';",false,$conn);
		}

		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		return $conn;
	}
}
?>