<?php 
function aliceos_tmqs($sql,$tmp=false,$forcedbname="") {
	//func("aliceos_tmqs($sql,$tmp");
	global $_sv;
	global $svconn;
	global $aliceos_tmqs_called_aliceos_inival;

	global $_PREVIOUSLY_EXEC_SQL;
	$_PREVIOUSLY_EXEC_SQL="[aliceos_tmqs].".$sql;

		global $host;
		global $user;
		global $passwd;
		global $dbname;

	 $dcr_osdbhost=$host;
	 $dcr_osdbuser=$user;
	 $dcr_osdbpass=$passwd;
	 $dcr_osdbname=$dbname;



		$strsavestag = strtolower(substr(trim($sql), 0,5));
		if ($strsavestag == "delet" || $strsavestag=="updat" || $strsavestag=="inser") {
			filelogs("aliceos_tmqs","<B>$_tmid</B>-$sql");
		}

//logsornot
/*
$strsavestag = strtolower(substr(trim($sql), 0,5));
if ($strsavestag == "delet" || $strsavestag=="updat" || $strsavestag=="inser") {
		$_tmpinptb[]="charac";
		$_tmpinptb[]="aweb_member";
		$_tmpinptb[]="card_items";
		$_tmpinptb[]="char_config";
		$_tmpinptb[]="charac";
		$_tmpinptb[]="commercial_db";
		$_tmpinptb[]="gitem_items";
		$_tmpinptb[]="guild";
		$_tmpinptb[]="item_items";
		$_tmpinptb[]="npc_reseller";
		$_tmpinptb[]="pets_pets";
		$_tmpinptb[]="pvp";
		$_tmpinptb[]="skill_own";
		$_tmpinptb[]="users_friendlist";
		$_tmpinptb[]="users_message";
		$_tmpinptb[]="users_trade";
		$_tmpinptb[]="npc_gstore";
		foreach ($_tmpinptb as $v) {
			if (strpos($sql, $v)!==false ) {
				filelogs("aliceos_tmqs","$sql");
				continue;
			}
		}
	}
		*/
//logsornot/e

	if (trim("$dcr_osdbhost$dcr_osdbuser$dcr_osdbpass$dcr_osdbname")=="") {
		html_dialog("","ผิดพลาด ไม่พบค่าตัวแปรสำคัญในการติดต่เซิร์ฟเวอร์กลาง คุณอาจถูกตัดออกจากระบบ (ไม่ทราบสาเหตุการตัดออกจากระบบ)");
		die("ERROR ต้องเรียกฟังก์ขัน aliceos_inival ก่อนฟังก์ชัน aliceos_tmqs");
	}
	if ($tmp==true) {
		echo "<BLOCKQUOTE title='aliceos_tmqs Was ordered to echo these sql'><PRE>[$sql]</PRE></BLOCKQUOTE>";
	}

	if (!isset($svconn)) {
		////func("aliceos_tmqs have to reconnect svconn");
		$svconn =mysql_connect($dcr_osdbhost,$dcr_osdbuser,$dcr_osdbpass);
		if (!$svconn) {
			die("ไม่สามารถติดต่อกับ MYSQL ได้");
		}
	}
	 if ($forcedbname=="") {
		$db_selected = mysql_select_db($dcr_osdbname,$svconn);
	 } else {
		$db_selected = mysql_select_db($forcedbname,$svconn);
	 }
	if (!$db_selected) {
		die ('Can\'t use foo : ' . tmq_error());
	} else {
		//die ("Connected $dcr_osdbname");		
	}

	$s=mysql_query($sql,$svconn);

	if (tmq_error()!="") {
		echo "<BLOCKQUOTE>";
		echo "<B>aliceos_tmqs-sqlerror</B>: [".htmlspecialchars($sql) ."]<BR> $dcr_osdbhost.$dcr_osdbuser.$dcr_osdbpass.$dcr_osdbname";
			filelogs("aliceos_tmqsERROR","$sql<HR>".tmq_error());

		echo tmq_error();
		echo "</BLOCKQUOTE>";
	}

	return $s;
}
?>