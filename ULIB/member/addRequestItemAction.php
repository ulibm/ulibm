<?php  
;
     include("../inc/config.inc.php");;
head();

if(empty($useradminidx) || empty($media_id)) { 
	 html_dialog("","กรุณาตรวจสอบรหัสล็อกอินและรหัสผ่าน::l::Please re-correct yout login and password");
	 die;
}
	 $user_id=ChkLoginAdminmember($useradminidx, $passwordadminx);
	if ($user_id == false)
		{
				 html_dialog("","กรุณาตรวจสอบรหัสล็อกอินและรหัสผ่าน::l::Please re-correct yout login and password");
				die;
		}
$sqlchk = "select * from checkout where mediaId='$media_id' and request='' ";
$resultchk = tmq($sqlchk);
if (tmq_num_rows($resultchk)==0) {
	 html_dialog("","เกิดข้อผิดพลาด กรุณาตรวจสอบหมายเลขทะเบียนหนังสืออีกครั้ง::l::Error , Please re-correct Media id");
	die;
}

$sqlchk = "select * from checkout where mediaId='$media_id' ";

$resultchk = tmq($sqlchk);
$Numchk = tmq_num_rows($resultchk);
if (tmq_num_rows($resultchk)==0) {
	 html_dialog("","วัสดุสารสนเทศชิ้นนี้ไม่ได้ถูกยืมอยู่::l::Media not checked out");
	die();
}
$Numchk=tmq_fetch_array($resultchk);
if ($Numchk[hold]==$useradminidx) {
	html_dialog("","ไม่สามารถจองรายการที่ท่านเป็นผู้ยืมได้::l::Could not request your checked out item");
	die;
}
     $sql ="update checkout set request='$useradminidx' where mediaId='$media_id' and request='' "; 
tmq($sql);
	html_dialog("","ทำการเพิ่มข้อมูลเรียบร้อยแล้ว::l::Request recorded");

?><SCRIPT LANGUAGE="JavaScript">
<!--
alert("<?php echo getlang("บันทึกการจองเรียบร้อย::l::Request sent!"); ?>\n");
//-->
</SCRIPT><?php  
	redir ($dcrURL);

foot();?>