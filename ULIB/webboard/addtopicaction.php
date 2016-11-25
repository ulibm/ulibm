<?php 
;
include("./cfg.inc.php");
if ($_memid=="") {
	captcha_e();
}
include("./_localfunc.php");


$ismanager=loginchk_lib("check");

 $ID=trim($ID);
?><!-- <?php pathgen($ID);?> --><?php 
	if ($catedata[isshowtouser]!="yes"&& $ismanager!=true) {
		die("you cannot post in this forum");
	}
	 	$reqmemid= barcodeval_get("webboard-reqmemid");
  	if ($reqmemid=='yes' && $_memid=='' && $ismanager!=true) {
  	 die("you cannot post in this forum");
  	}
$now=time();
$topic=addslashes($topic);
$text=addslashes($text);
if ($editing!="") {
	$sql ="update webboard_posts set
	topic='$topic',
	text='$text',
	ispin='$ispin',
	iscan_ans='$iscan_ans',
	ishide='$ishide',
	viewers=',$useradminid,',
	postername='$postername',
	postermail='$postermail',
	lastactive='$now'
	where id='$editing'
	";

} else {
	if ($ishide=="") {
		$ishide="yes";
	}
	//echo $dbname;
	$inf_all=addslashes(print_r($_SERVER,true));
	$sql ="insert into webboard_posts set
	boardid='$ID',
	memid='$_memid',
	dt='$now',
	nestedid='$replying',
	topic='$topic',
	tmid='$useradminid',
	text='$text',
	ispin='$ispin',
	iscan_ans='$iscan_ans',
	ishide='$ishide',
	inf_ip='$REMOTE_ADDR',
	inf_all='$inf_all',

postername='$postername',
	postermail='$postermail',

	lastactive='$now',
	viewers=',$useradminid,'
	";
	
}
if(tmq($sql)) {
	//
	$mysqlinsertid=tmq_insert_id();
	if ($editing=="") {
		tmq("delete from webboard_post_attatch where postid='$mysqlinsertid' ");
		tmq("update webboard_post_attatch set postid='$mysqlinsertid' where tmid='$useradminid' and postid=0");
	}

	echo"<div align=center><br><b>ทำการเพิ่มข้อมูลเรียบร้อยแล้ว</b><br></div>";

//echo"<meta http-equiv='refresh' content='0;URL=viewforum.php?ID=$ID'>";
	  if ($ishide=="yes") {

			?><SCRIPT LANGUAGE="JavaScript">
		<!--
			alert("ระบบได้รับข้อมูลแล้ว\n\nแต่ระบบจะยังไม่แสดงข้อความของคุณ จนกว่า บรรณารักษ์จะยืนยันข้อความของคุณเรียบร้อยแล้ว\n\nขอบคุณครับ");
		//-->
		</SCRIPT><?php 
	 }
  if ($replying!="") {
	  tmq("update webboard_posts set lastactive='$now',viewers=',$useradminid,' where id='$replying' ");
	  $cateidtoupdate=$replying;
	  redir("viewtopic.php?TID=$replying");
  } elseif ($editing!="") {
		$editingdb=tmq("select * from webboard_posts where id='$editing' ");
		if (tmq_num_rows($editingdb)==0) {
			die("no parent webboard_posts id $editing to redir to.");
		} else {
			$editingdb=tmq_fetch_array($editingdb);
		}

		tmq("update webboard_posts set lastactive='$now' where id='$editing' ");
		$cateidtoupdate=$editing;
		if ($editingdb[nestedid]!=0) {
			redir("viewtopic.php?TID=$editingdb[nestedid]");
		} else {
			redir("viewtopic.php?TID=$editingdb[id]");
		}
  } else {
	  $cateidtoupdate=$mysqlinsertid;
	  if ($ishide!="yes") {
		  redir("viewtopic.php?TID=$mysqlinsertid");
	  } else {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
			alert("ระบบได้รับข้อมูลแล้ว\n\nแต่ระบบจะยังไม่แสดงข้อความของคุณ จนกว่า บรรณารักษ์จะยืนยันข้อความของคุณเรียบร้อยแล้ว\n\nขอบคุณครับ");
		//-->
		</SCRIPT><?php 
		redir("viewforum.php?ID=$catedata[id]");
	  }
  }
		//update cate unread data
	$cateidtoupdate=tmq("select * from webboard_posts where id='$cateidtoupdate' ");
	$cateidtoupdate=tmq_fetch_array($cateidtoupdate);
		tmq("update webboard_boardcate set viewers=',$useradminid,' where id='$cateidtoupdate[boardid]' ");


	//end update
	echo"</font>";

 

       } else {

      echo"<font face ='ms sans serif'  size ='3'>";

		echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";

    	echo"</font>";

	}

?>