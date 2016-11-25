<?php 
;
include("./cfg.inc.php");

include("./_localfunc.php");


$ismanager=library_gotpermission("webpage-postarticle");

 $ID=trim($ID);
?><!-- <?php pathgen($ID);?> --><?php 
	if ($catedata[isshowtouser]!="yes" && $ismanager!=true) {
		die("you cannot post in this forum");
	}
$now=time();
//$topic=addslashes($topic);
//$text=addslashes($text);
if ($editing!="") {
	$sql ="update webpage_articles set
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
	$sql ="insert into webpage_articles set
	boardid='$ID',
	dt='$now',
	nestedid='$replying',
	topic='$topic',
	picalbum='$picalbum',
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

$mysqlinsertid=tmq_insert_id();
if ($editing=="") {
	tmq("delete from webpage_article_attatch where postid='$mysqlinsertid' ");
	tmq("update webpage_article_attatch set postid='$mysqlinsertid' where tmid='$useradminid' and postid=0");
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
	  tmq("update webpage_articles set lastactive='$now',viewers=',$useradminid,' where id='$replying' ");
	  $cateidtoupdate=$replying;
	  redir("viewtopic.php?TID=$replying&picalbum=$picalbum");
  } elseif ($editing!="") {
		$editingdb=tmq("select * from webpage_articles where id='$editing' ");
		if (tmq_num_rows($editingdb)==0) {
			die("no parent webpage_articles id $editing to redir to.");
		} else {
			$editingdb=tmq_fetch_array($editingdb);
		}

		tmq("update webpage_articles set lastactive='$now' where id='$editing' ");
		$cateidtoupdate=$editing;
		if ($editingdb[nestedid]!=0) {
			redir("viewtopic.php?TID=$editingdb[nestedid]&picalbum=$picalbum");
		} else {
			redir("viewtopic.php?TID=$editingdb[id]&picalbum=$picalbum");
		}
  } else { // add new
	  $cateidtoupdate=$mysqlinsertid;
	  if ($ishide!="yes") {
		  redir("viewtopic.php?TID=$mysqlinsertid&picalbum=$picalbum");
	  } else {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
			alert("ระบบได้รับข้อมูลแล้ว\n\nแต่ระบบจะยังไม่แสดงข้อความของคุณ จนกว่า บรรณารักษ์จะยืนยันข้อความของคุณเรียบร้อยแล้ว\n\nขอบคุณครับ");
		//-->
		</SCRIPT><?php 
		redir("viewforum.php?ID=$catedata[id]&picalbum=$picalbum");
	  }
  }
		//update cate unread data



	//end update
	echo"</font>";

 

       } else {

      echo"<font face ='ms sans serif'  size ='3'>";

		echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";

    	echo"</font>";

	}

?>