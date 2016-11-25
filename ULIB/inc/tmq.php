<?php  //พ
function tmq($q,$isshow = "",$link_identifier="none") {
	///$isshow=true;
	//ConnDB();
	//global $IPADDR; if ($IPADDR=="10.112.223.166") {$isshow=true;}
	$time_start = microtime(true); 
	global $_SESSION;
	global $_POST;
	global $_GET;
	global $dbname;
	global $tmq_autoconnect_collation;
	global $tmq_autoconnect_host;
	global $tmq_autoconnect_user;
	global $tmq_autoconnect_passwd;
	global $dbmode;
	global $_autosave_dbsql;
	global $conn;
	if ($link_identifier=="none" || $link_identifier=="-localdb-" || (!is_string($link_identifier) && $link_identifier==NULL) ) {
		//var_dump($conn);
		if ($conn==NULL) {
		    ConnDB();
		}
		$link_identifier=$conn;
		//echo "tmq($q); use old connection <br>";
	} else {
		//echo "tmq($q); use new connection [link_identifier=$link_identifier]<br>";
		if (is_string($link_identifier)==true && $link_identifier!="-localdb-" && ($tmq_autoconnect_host!="" && $tmq_autoconnect_user!="")) { // auto connect
			//echo "tmq(); create new connection using $tmq_autoconnect_host, $tmq_autoconnect_user, $tmq_autoconnect_passwd";
			global $host;
			global $user;
			global $passwd;
			
			$link_identifier_orig=$link_identifier;
			$link_identifier=tmq_connect($tmq_autoconnect_host, $tmq_autoconnect_user, $tmq_autoconnect_passwd,true);

			if (!$link_identifier) {
				echo 'Could not connect to mysql // auto connect';
			}
			if (!$link_identifier=tmq_select_db($link_identifier_orig,$link_identifier)) {
				echo "Could not use db $ui_dbname // auto connect";
			}
			if ($tmq_autoconnect_collation!="") {
				if ($dbmode=="mysql") {
					$tmp=mysql_query( "set names '$tmq_autoconnect_collation'; ",$link_identifier);
				}
				if ($dbmode=="mysqli") {
					$tmp = mysqli_query($link_identifier,"set names '$tmq_autoconnect_collation'; ") or ($tmpe=mysqli_error($link_identifier));
				}
			}
		}
      if (is_string($link_identifier)==true && $link_identifier="-localdb-" && ($tmq_autoconnect_host!="" && $tmq_autoconnect_user!="")) { // auto connect
      }
	}
	global $tmq_last_activelink;
	$tmq_last_activelink=$link_identifier;
	//echo $link_identifier;
	if ($dbmode=="mysql") {
	  //echo "mysql_query( $q,$link_identifier);";
		$tmp=mysql_query( $q,$link_identifier);
		$tmpe=tmq_error();
		if ($tmpe!="") {
		 //echo "HERE";
			echo "<FONT COLOR=red>$dbmode:".$tmpe."</FONT><HR><PRE>$q</PRE>";
		}
		if ($isshow!="") {
			echo "<BLOCKQUOTE><PRE>$dbmode:$q</PRE></BLOCKQUOTE>";
		}
	}
	if ($dbmode=="mysqli") {
//		echo "<pre>$q<HR>".var_dump($link_identifier)."</pre>";
		$tmp = mysqli_query($link_identifier,$q) ;
		//echo mysqli_error($link_identifier);
		$tmpe=mysqli_error($link_identifier);
		//echo("Error description: " . mysqli_error($link_identifier));
		if ($tmp) {
			//echo "yes";
		} else {
			//echo "no".$tmpe;
		}
		//$tmp=mysql_db_query($dbname, $q);
		//$tmpe=mysqli_error();
		//echo tmq_error();
		if ($tmpe!="") {
			echo "<FONT COLOR=red>$dbmode: ".$tmpe."</FONT><HR><PRE>$q</PRE>";
		}
		if ($isshow!="") {
			echo "<BLOCKQUOTE><PRE>$dbmode: $q</PRE></BLOCKQUOTE>";
		}
	}

	////////////////////////////startlog
	if ($_autosave_dbsql=="yes") {
		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start);
		$strsavestag = strtolower(substr(trim($q), 0,5));
		if ($execution_time>=0.2 || ($strsavestag == "delet" || $strsavestag=="updat" || $strsavestag=="inser")) {
			filelogs("tmq", '<b>Total Execution Time:</b> '.$execution_time.' secs<br>'."$q","autosave_dbsql-date-".date("d"));
			/*filelogs("tmq","SESSION=".print_r($_SESSION,true)."<HR>
			POST=".print_r($_POST,true)."<HR>
			GET=".print_r($_GET,true),"autosave_dbsql-date-".date("d"));*/
		} 
	}
	////////////////////////////endlog

	return $tmp;
}

?>