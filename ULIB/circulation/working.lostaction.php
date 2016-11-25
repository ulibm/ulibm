<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");


	$c=tmq("select * from media_mid where bcode='$damagebarcode' ");
	if (tmq_num_rows($c)==0) {
		echo "<CENTER><BR>";
		html_dialog("","ไม่พบบาร์โค้ดที่ระบุ");
		echo "<A HREF='working.lost.php'>".getlang("กลับ::l::Back")."</A></CENTER>";
		die;
	}
	$c=tmq_fetch_array($c);
   media_updatelastdt($c[pid],"item");
	$now=time();
	
	tmq("update media_mid set status='$newstatus',status_lastupdate='$now' where bcode='$damagebarcode' ");
	
	if ($includefine=="yes" && $memberbarcode!="") {
		tmq("delete from checkout where mediaId='$damagebarcode' and hold='$memberbarcode' ");
		$fine_topic=addslashes($fine_topic);
		$dt=time();
		tmq("insert into fine set
			lib='$useradminid',
			memberId='$memberbarcode',
			topic='$fine_topic',
			dt='$dt',
			fine='$fine_fine'
		");
	}
	
			echo "<CENTER><BR>";
		html_dialog("","ดำเนินการเรียบร้อย");
		echo "</CENTER>";

	?>