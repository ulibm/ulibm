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
$sqlchk = "select * from checkout where mediaId='$media_id'  ";
$resultchk = tmq($sqlchk);
if (tmq_num_rows($resultchk)!=0) {
	 html_dialog("","เกิดข้อผิดพลาด กรุณาตรวจสอบหมายเลขทะเบียนหนังสืออีกครั้ง::l::Error , Please re-correct Media id");
	die;
}

	$place=tmq("select * from media_mid where bcode='$media_id' ");
	$place=tmq_fetch_array($place);
	$place=tmq("select * from media_place where code='$place[place]' ");
	$place=tmq_fetch_array($place);
	if ($place[isrq]!="yes") {
		 html_dialog("",getlang("เกิดข้อผิดพลาด ::l::Error ").getlang($place[name] ).getlang(" ไม่อนุญาตให้ทำการขอยืม::l::not allow to request"));
		die;
	}
	$cmid=tmq("select * from checkout where mediaId='$media_id' ");
	if (tmq_num_rows($cmid)!=0) {
	 html_dialog("","เกิดข้อผิดพลาด ถูกยืมออกไปแล้ว::l::Error , already checked out");
	die;
	}
	$cmid=tmq("select * from request_list where itemid='$media_id' ");
	if (tmq_num_rows($cmid)!=0) {
	 html_dialog("","เกิดข้อผิดพลาด ถูกขอยืมไปก่อนหน้านี้แล้ว::l::Error , already requested");
	die;
	}

tmq("delete from request_list where itemid='$media_id' ");
$now=time();
tmq("insert into request_list set itemid='$media_id' ,memberid='$useradminidx',dt=$now ");
	html_dialog("","ทำการเพิ่มข้อมูลเรียบร้อยแล้ว::l::Request recorded");

?><SCRIPT LANGUAGE="JavaScript">
<!--
alert("<?php echo getlang("บันทึกการจองเรียบร้อย::l::Request sent!"); ?>\n");
//-->
</SCRIPT><?php  
	redir ($dcrURL);

foot();?>