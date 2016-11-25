<?php 
include ("../inc/config.inc.php");
	if ($addcookieautologin=="yes") {
		$libraryautologincookie=trim($_COOKIE[LIBAUTHC]);
		if ($libraryautologincookie=="") {
			$libraryautologincookie=randid();
		}
		$now=time();
		setcookie("LIBAUTHC",$libraryautologincookie,time()+(60*60*24*30),"/$dcr"); // 30 days
		tmq("delete from library_cookielogin where dat='$libraryautologincookie' and loginid='$useradminid' ");
		tmq("insert into library_cookielogin set dat='$libraryautologincookie' , loginid='$useradminid',dt='$now' ,pcname='".addslashes($pcname)."'  ");
		redir("mainadmin.php");
		die;
	}
	if ($clearcookieautologin=="yes") {
		$libraryautologincookie=trim($_COOKIE[LIBAUTHC]);
		tmq("delete from library_cookielogin where dat='$libraryautologincookie' and loginid='$useradminid' ");
		setcookie("LIBAUTHC",""); // 30 days
		redir("mainadmin.php");
		die;
	}
		if ($switchlibsitesave=="yes" && library_gotpermission("switchownlibsite")) {
			$chk=tmq("select * from  library_site where code='$switchownlibsite_selected' ");
			$chk=tmq_fetch_array($chk);
			$chk=trim($chk[code]);
			if ($chk!="") {
				$LIBSITE=$switchownlibsite_selected;
				ulibsess_register("LIBSITE");
				//printr($_SESSION); die;
				redir($PHP_SELF); die;
				//$_SESSION[]=$
			}
		}

	head();
	$_REQPERM="mainmenu";
	mn_lib();
$warning_count=0;
$warning_str="";

if ($switchlibsite=="yes" && library_gotpermission("switchownlibsite")) {
?><BR><TABLE cellpadding=0 cellspacing=0 width=500 align=center class=table_border>
<FORM METHOD=POST ACTION="mainadmin.php">
<INPUT TYPE="hidden" NAME="switchlibsitesave" value="yes">
	<TR>
		<TD class=table_head colspan=2><?php  echo getlang("เลือกสาขาห้องสมุดที่กำลังปฏิบัติงาน::l::Switch current campus to work on");?></TD>
	</TR>
 <tr valign = "top">
  <td align=center><?php  
	frm_libsite("switchownlibsite_selected",$LIBSITE);
  ?></td>
 </tr>
	<TR>
		<TD class=table_td align=center><INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Save Changes"); ?>"> <INPUT TYPE="reset" value="<?php  echo getlang("ยกเลิก::l::Cancel");?>" onclick="self.location='mainadmin.php'"></TD>
	</TR>

</FORM>
	</TABLE><?php 
}
if ($savenewpassword=="yes" && getval("_SETTING","islibcanchangeownpassword")=="yes") {
	$pwdchk=tmq("select * from library where UserAdminID='$useradminid' ");
	$pwdchk=tmq_fetch_array($pwdchk);
	echo "<BR>";
	if ($pwdchk[Password]!=md5($currentpwd)) {
		html_dialog("ERROR",getlang("รหัสผ่านปัจจุบันที่ป้อนเข้ามาไม่ตรงกับรหัสผ่านปัจจุบันในฐานข้อมูล::l::Your current password enterd not match the data in system"));
	} else {
		tmq("update library set Password='".md5($newpwd1)."' where UserAdminID='$useradminid' limit 1  ");
		html_dialog("Success",getlang("การเปลี่ยนรหัสผ่านเรียบร้อย::l::Password Changed"));
	}
}
if ($editlibrarianmsgaction=="yes" && getval("_SETTING","uselibrarianmsgboard")=="yes") {
	viewdiffman_add("librarianmsg","librarianmsg",$librarianmsg);
	barcodeval_set("librarianmsg","$librarianmsg");
	barcodeval_set("librarianmsg-lastlib","$useradminid");
	barcodeval_set("librarianmsg-dt",time());
}
if ($editlibrarianmsg=="yes" && getval("_SETTING","uselibrarianmsgboard")=="yes") {
?><BR><TABLE cellpadding=0 cellspacing=0 width=500 align=center class=table_border>
<FORM METHOD=POST ACTION="mainadmin.php">
<INPUT TYPE="hidden" NAME="editlibrarianmsgaction" value="yes">
	<TR>
		<TD class=table_head colspan=2><?php  echo getlang("แก้ไขข้อความระหว่างเจ้าหน้าที่ห้องสมุด::l::Officer Message Box");?></TD>
	</TR>
 <tr valign = "top">
  <td align=center><?php  form_quickedit("librarianmsg",barcodeval_get("librarianmsg"),"html"); ?><BR>
    <?php 
	frm_globalupload("librarianmsg","librarianmsg");
  ?></td>
 </tr>
	<TR>
		<TD class=table_td><INPUT TYPE="submit" value="<?php  echo getlang("บันทึกการเปลี่ยนแปลง::l::Save Changes"); ?>"> <INPUT TYPE="reset" value="<?php  echo getlang("ยกเลิก::l::Cancel");?>" onclick="self.location='mainadmin.php'"></TD>
	</TR>

</FORM>
	</TABLE><?php 
}
if ($changepassword=="yes" && getval("_SETTING","islibcanchangeownpassword")=="yes") {
	?><BR><TABLE cellpadding=0 cellspacing=0 width=500 align=center class=table_border>
<FORM METHOD=POST ACTION="mainadmin.php" onsubmit="return chkpwd(this);">
<INPUT TYPE="hidden" NAME="savenewpassword" value="yes">
<SCRIPT LANGUAGE="JavaScript">
<!--
	function chkpwd(wh) {
		if (wh.currentpwd.value=="") {
			alert("<?php  echo getlang("กรุณาระบุรหัสผ่านปัจจุบัน::l::Please Enter your current password");?>");
			wh.currentpwd.focus();
			return false;
		}
		if (wh.newpwd1.value=="") {
			alert("<?php  echo getlang("กรุณาระบุรหัสผ่านใหม่::l::Please Enter your new password");?>");
			wh.newpwd1.focus();
			return false;
		}
		if (wh.newpwd1.value!=wh.newpwd2.value) {
			alert("<?php  echo getlang("รหัสผ่านใหม่ทั้งสองช่องไม่เหมือนกัน::l::Please verify your new password");?>");
			wh.newpwd1.focus();
			return false;
		}
		return true;
	}
//-->
</SCRIPT>
	<TR>
		<TD class=table_head colspan=2><?php  echo getlang("เปลี่ยนรหัสผ่าน::l::Change password");?></TD>
	</TR>
	<TR>
		<TD class=table_head2 colspan=2><?php  echo getlang("กรุณากรอกรหัสผ่านปัจจุบัน และรหัสผ่านใหม่ที่ต้องการ::l::Please enter your current password and desired password");?></TD>
	</TR>
	<TR>
		<TD class=table_head2 width=220><?php  echo getlang("รหัสผ่านปัจจุบัน::l::Current password");?></TD>
		<TD class=table_td><INPUT TYPE="password" NAME="currentpwd" autocomplete=off></TD>
	</TR>
	<TR>
		<TD class=table_head2 width=220><?php  echo getlang("รหัสผ่านใหม่::l::New password");?></TD>
		<TD class=table_td><INPUT TYPE="password" NAME="newpwd1" autocomplete=off></TD>
	</TR>
	<TR>
		<TD class=table_head2 width=220><?php  echo getlang("ยืนยันรหัสผ่านใหม่::l::Confirm New password");?></TD>
		<TD class=table_td><INPUT TYPE="password" NAME="newpwd2" autocomplete=off></TD>
	</TR>
	<TR>
		<TD class=table_head2 colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("เปลี่ยนรหัสผ่าน::l::Change Password"); ?>"> <INPUT TYPE="reset" value="<?php  echo getlang("ยกเลิก::l::Cancel");?>" onclick="self.location='mainadmin.php'"></TD>
	</TR>

</FORM>
	</TABLE><?php 
}

if ($_ISULIBMASTER!="yes" && barcodeval_get("activateulib-refcode")=="") {
		$warning_count++;
		$warning_str.=' <b style="color: #828282"> &bull; '.getlang("ยังไม่ได้ลงทะเบียนโปรแกรม ULibM::l::Please Register ULibM")."</b>";;
} 
if (library_gotpermission("rqroom_manage")) {
	$next2week=time()+(60*60*24*14);
	$now=time();
	$crq=tmq("select * from rqroom_timetbi where dt>$now and dt<=$next2week  ");
	if (tmq_num_rows($crq)!=0) {
		$crqexistc=0;
		while($crqr=tfa($crq)) {
			$crqexist=tmq("select * from rqroom_eventinfo where maintb='$crqr[maintb]' and keyid='$crqr[keyid]' and period='$crqr[period]' and text<>'' ",false);
			if (tnr($crqexist)>0) {
				$crqexistc++;
			}
		}
		if ($crqexistc>0) {
		
			$warning_count++;
			$warning_str.='';
			//$warning_str.='<div align = "center">';
			$warning_str.='<TABLE width = 600 border=0 align=center>
			   <TR>
							<TD width=150 align=right><IMG SRC="../neoimg/Warning-48.gif" WIDTH="48" HEIGHT="48" BORDER="0" ALT="" ></TD>
								<TD align = left>';
			$warning_str.='<FONT SIZE = "4" COLOR = "red">';
			$warning_str.= getlang("ขณะนี้ มีการแจ้งจองห้องที่อยู่ภายในกำหนด 2 สัปดาห์::l::Some room-request info. within 2 week"); 
			$warning_str.= "<br> <a href='../timetable/view/' class=a_btn>";
			$warning_str.= getlang("คลิกที่นี่เพื่อดูรายละเอียด::l::Click here to view detail.");
			$warning_str.= "</a>";
			$today=ymd_mkdt(date('d'),date('m'),date('Y'));
			$crq=tmq("select * from rqroom_timetbi where dt=$today");
			if (tmq_num_rows($crq)!=0) {
				$warning_str.= "<BR><B>";
				$warning_str.= getlang("มีการจองห้องที่มีกำหนดวันนี้ ::l::Some room-request for today "); 
				$warning_str.= tmq_num_rows($crq);
				$warning_str.= getlang(" รายการ ::l:: item ");
				$warning_str.= "</B>";
			}
			$tomorrow=ymd_mkdt(date('d')+1,date('m'),date('Y'));
			$crq=tmq("select * from rqroom_timetbi where dt=$tomorrow");
			if (tmq_num_rows($crq)!=0) {
				$warning_str.= "<BR><B style='color: #B00000'>";
				$warning_str.= getlang("มีการจองห้องที่มีกำหนดพรุ่งนี้ ::l::Some room-request for tomorrow "); 
				$warning_str.= tmq_num_rows($crq);
				$warning_str.= getlang(" รายการ ::l:: item ");
				$warning_str.= "</B>";
			}
			$warning_str.='</b></FONT>
								</TD>
							</TR>
						</TABLE>';
		}
	}
}
				
$backupremind=floor(getval("_SETTING","day_to_alert_librarian_to_backup"));
if ($backupremind!=0) {
	$lastbackup=floor(barcodeval_get("lastbackup-full-date"));
	$dt_to_remind=time()-($backupremind*(60*60*24));
	//echo "($dt_to_remind>$lastbackup) ";
	if ($dt_to_remind>$lastbackup) {
		$dt_to_remind_light=time()-($lightbackupremind*(60*60*24));
			$color="red";
			$imgsrc="Warning-48.gif";
			$warning_count++;

		$warning_str.='<TABLE width = 780 border=0 align=center>
                    <TR>
					<TD width=150 align=right><IMG SRC="../neoimg/'. $imgsrc.'" WIDTH="48" HEIGHT="48" BORDER="0" ALT="" ></TD>
                        <TD align = left>
                                <FONT SIZE = "4" COLOR = "'.$color.'" class=smaller> ';
								$warning_str.= getlang("ขณะนี้ ระบบไม่ได้ทำการสำรองข้อมูลมาเป็นระยะเวลาพอสมควร<BR> ตั้งแต่ ::l::This system not been full-backup for longtime, <BR>Since."); 
								$warning_str.= thaidatestr($lastbackup);
								$warning_str.= " <font class=smaller2>(".ymd_ago($lastbackup).")</font>";
								$warning_str.= "<BR>";
								$warning_str.= getlang("กรุณาไปที่ส่วนของ ระบบการสำรองข้อมูล และทำการสำรองข้อมูล<BR>เพื่อความปลอดภัยของระบบ::l::Please go to backup system then full-backup, for system statibility."); 
		$warning_str.='</b></FONT>
                            </TD>
                        </TR>';

		$warning_str.=' </TABLE>';
		}
}

if (library_gotpermission("rqroom_manage")) {
	$chkct=tmq("select * from webpage_memregist where granted='no' ",false); 
	if (tmq_num_rows($chkct)!=0) {
		$numct=tmq_num_rows($chkct);
		$warning_count++;
		$warning_str.='<br /><a href="../library.memregist/grant.php" class=smaller style="color:darkred">'.getlang("มีผู้สมัครออนไลน์ $numct รายการ::l::New member Registration $numct")."</a>";
	} 
}
if (library_gotpermission("marcincorrect-list")) {
	$chkct=tmq("select id from webpage_incorrectbib ",false); 
	if (tmq_num_rows($chkct)!=0) {
		$numct=tmq_num_rows($chkct);
		$warning_count++;
		$warning_str.='<br /><a href="../library.marcincorrect/list.php" class=smaller style="color:darkred">'.getlang("มีการแจ้งบรรณานุกรมผิดพลาด $numct รายการ::l::Incorrect Marc Reported: $numct")."</a>";
	} 
}

if (library_gotpermission("answerpoint")) {
	$chkct=tmq("select * from webpage_answerpoint where cate='new' ",false); 
	if (tmq_num_rows($chkct)!=0) {
		$numct=tmq_num_rows($chkct);
		$answerpointname=getlang(barcodeval_get("answerpoint_name"));
		$warning_count++;
		$warning_str.="<br /><a href='../answerpoint' class=smaller style='color:darkred' target=_blank>".getlang("มีคำถามใหม่ในระบบ $answerpointname ($numct รายการ) ::l::New question in $answerpointname ($numct)")."</a>";
	} 
}
 $chkct=tmq("select * from contact where isread='no' ",false); 
 if (tmq_num_rows($chkct)!=0) {
	$numct=tmq_num_rows($chkct);
	$warning_count++;
	$warning_str.="<br /> <a href='../library.contact/' class=smaller style='color:darkred'>".getlang("มีข้อความติดต่อที่ยังไม่ได้อ่าน $numct รายการ::l::Unread contact $numct")."</a>";
 } else {
	//$warning_str.="<BR><BR><A HREF='../library.contact/'><FONT color=66666 class=smaller2>".getlang("ไม่มีข้อความติดต่อใหม่::l::No new contact.")."</FONT></A>";
 }

 	$chkct=tmq("select * from docdelivery_readrule where loginid='$useradminid' and deleted='no' and readed='no' ",false); 
	if (tmq_num_rows($chkct)!=0) {
		$numct=tmq_num_rows($chkct);
		$warning_count++;
		$warning_str.='<br /><br /><a href="../library.docdelivery/" class=smaller style="color:darkred">'.getlang("มีเอกสารเข้าในระบบเอกสาร $numct รายการ::l::New Document in Document System $numct")."</a>";
	} 


//reminderscalendar
$now=time();
//pre s 
$amonth=time()+(60*60*24*31);
$reminderscalendardisplayed=false;
$reminlink="";
if (library_gotpermission("reminderscalendar")==true) {
   $reminlink="<a href='$dcrURL"."/library.reminderscalendar/' class='smaller2 a_btn'>".getlang("จัดการการเตือน::l::Manager reminders")."</a>";
}

if (floor($reminderscal_mutepre)!=0) {
   tmq("delete from reminderscalendar_mutepre where loginid='$useradminid' and remindid='$reminderscal_mutepre' ");
   tmq("insert into reminderscalendar_mutepre set loginid='$useradminid' , remindid='$reminderscal_mutepre' ");
}
if (floor($reminderscal_unmutepre)!=0) {
   tmq("delete from reminderscalendar_mutepre where loginid='$useradminid' and remindid='$reminderscal_unmutepre' ");
}
if (floor($reminderscal_mutepast)!=0) {
   tmq("delete from reminderscalendar_mutepast where loginid='$useradminid' and remindid='$reminderscal_mutepast' ");
   tmq("insert into reminderscalendar_mutepast set loginid='$useradminid' , remindid='$reminderscal_mutepast' ");
}
if (floor($reminderscal_unmutepast)!=0) {
   tmq("delete from reminderscalendar_mutepast where loginid='$useradminid' and remindid='$reminderscal_unmutepast' ");
}
$remincal=tmq("select * from reminderscalendar where (lower(isglobal)='yes' or loginid='$useradminid') and dt<'$amonth' and dt>$now");
while ($remincalr=tfa($remincal)) {
   $isreminremin=tmq("select * from reminderscalendar_mutepre where loginid='$useradminid' and remindid='$remincalr[id]' ",false);
   if (tnr($isreminremin)==0) {
      $warning_count++;
      $warning_str.="<BR><b style='color: darkred;'>Reminder:".ymd_datestr($remincalr[dt],"shortd")." : ".stripslashes($remincalr[title])."</b><BR>
      ".      getlang("โดย::l::by")." ".get_library_name($remincalr[loginid])."
      <a href='$PHP_SELF?reminderscal_mutepre=$remincalr[id]#warning' onclick=\"return confirm('disable this reminder?');\" class='smaller a_btn'>".getlang("ปิดการเตือน::l::Mute")."</a>
      <BR>
      ".stripslashes($remincalr[descr]);;
   } else {
      $warning_str.="<BR><b style='color: #777777;' class='smaller'>Reminder:".ymd_datestr($remincalr[dt],"shortd")." : ".stripslashes($remincalr[title])."</b><BR>
      ".      getlang("โดย::l::by")." ".get_library_name($remincalr[loginid])."
      <a href='$PHP_SELF?reminderscal_unmutepre=$remincalr[id]#warning'class='smaller2 a_btn'>".getlang("เปิดการเตือน::l::Unmute")."</a>
      <BR>
      ".stripslashes($remincalr[descr]);
   }
   $reminderscalendardisplayed=true;
}
//pre e
//past s
$amonth=time()-(60*60*24*31);
$remincal=tmq("select * from reminderscalendar where (lower(isglobal)='yes' or loginid='$useradminid') and dt>'$amonth' and dt<$now");
while ($remincalr=tfa($remincal)) {
   $isreminremin=tmq("select * from reminderscalendar_mutepast where loginid='$useradminid' and remindid='$remincalr[id]' ",false);
   if (tnr($isreminremin)==0) {
      $warning_count++;
      $warning_str.="<BR><b style='color: #E01818;'>Reminder:".ymd_datestr($remincalr[dt],"shortd")." : ".stripslashes($remincalr[title])."</b><BR>
      ".      getlang("โดย::l::by")." ".get_library_name($remincalr[loginid])."
      <a href='$PHP_SELF?reminderscal_mutepast=$remincalr[id]#warning' onclick=\"return confirm('disable this reminder?');\" class='smaller a_btn'>".getlang("ปิดการเตือน::l::Mute")."</a>
      <BR>
      ".stripslashes($remincalr[descr]);;
      $reminderscalendardisplayed=true;
   } else {
      /*$warning_str.="<BR><b style='color: #777777;' class='smaller'>Reminder:".ymd_datestr($remincalr[dt],"shortd")." : ".stripslashes($remincalr[title])."</b><BR>
      ".      getlang("โดย::l::by")." ".get_library_name($remincalr[loginid])."
      <a href='$PHP_SELF?reminderscal_unmutepast=$remincalr[id]#warning'class='smaller2 a_btn'>".getlang("เปิดการเตือน::l::Unmute")."</a>
      <BR>
      ".stripslashes($remincalr[descr]);*/
   }
}
if ($reminderscalendardisplayed==true) {
   $warning_str.=$reminlink;
}
//past e

?>
<style>
.vtabh {
	display:block;
	float: left;
	width: 100; height: 60;
	border: 1px solid #b6bacd;
	background-color: #e8eaee;
	border-bottom: 0px;
	position:relative;
	z-index:10;
	font-size: 13px;
	margin-left:3px; 
	border-top-left-radius: 3px 3px;
	border-top-right-radius: 3px 3px;
}
.menubody {
	display: none;
	width: <?php  echo $_TBWIDTH;?>; 
   min-height: 500px;
	/*border: 1px solid #b6bacd;*/
	background-color: white;
}
.vtabhimg {
	margin-top: 3px;
	margin-bottom: 3px;
}
</style>
<script type="text/javascript">
<!--
forcedtabstop=false;
var vtabdescrdb=Array();
vtabdescrdb[1]=Array();
vtabdescrdb[1]["name"]="<?php  echo getlang("ระบบจัดหา::l::Acquisition");?>"
vtabdescrdb[1]["descr"]="<?php  echo getlang("ระบบจัดหา จัดการงบประมาณ ส่งรายการให้ผู้ใช้เลือกซื้อทรัพยากร::l::Acquisition Manage budgets Online suggestion");?>"
vtabdescrdb[2]=Array();
vtabdescrdb[2]["name"]="<?php  echo getlang("ระบบลงรายการ::l::Catalogging");?>"
vtabdescrdb[2]["descr"]="<?php  echo getlang("ระบบลงรายการ นำเข้าข้อมูลทรัพยากร อัพเดทฐานข้อมูล OAI Havester ระบบ Collection::l::Catalogging Import data Update database OAI Havester Collection options");?>"
vtabdescrdb[3]=Array();
vtabdescrdb[3]["name"]="<?php  echo getlang("บริการยืมคืน::l::Circulation");?>"
vtabdescrdb[3]["descr"]="<?php  echo getlang("บริการยืมคืน นำส่งทรัพยากรข้ามสาขา จัดการข้อมูลสมาชิก นำเข้าข้อมูลสมาชิก ตั้งค่าสำหรับระบบสมาชิก::l::Circulation Item transis Member management Member import Member Settings");?>"
vtabdescrdb[4]=Array();
vtabdescrdb[4]["name"]="<?php  echo getlang("งานวารสาร::l::Serials");?>"
vtabdescrdb[4]["descr"]="<?php  echo getlang("งานวารสาร บอกรับวารสาร ดรรชนีวารสาร::l::Serials Serial control Journal index");?>"
vtabdescrdb[5]=Array();
vtabdescrdb[5]["name"]="<?php  echo getlang("จัดการเว็บไซต์::l::Webpage");?>"
vtabdescrdb[5]["descr"]="<?php  echo getlang("จัดการเว็บไซต์ Mobile Website จัดการโค้ด HTML Metadata  ULibM Borrow Lane สมัครสมาชิกออนไลน์ ตัวเลือกเว็บเพจ::l::Webpage Mobile Website Manage HTML Metadata ULibM Borrow Lane Online registration Webpage options");?>"
vtabdescrdb[6]=Array();
vtabdescrdb[6]["name"]="<?php  echo getlang("ระบบเสริม::l::Modules");?>"
vtabdescrdb[6]["descr"]="<?php  echo getlang("ระบบเสริม จัดการส่วนเสริมที่ติดตั้ง และฟังก์ชันอื่น ๆ::l::Modules Install module and more functions");?>"
vtabdescrdb[7]=Array();
vtabdescrdb[7]["name"]="<?php  echo getlang("สถิติ::l::Statistics");?>"
vtabdescrdb[7]["descr"]="<?php  echo getlang("ระบบสถิติ สถิติระบบ สถิติกำหนดเอง เคลียร์สถิติ::l::Statistics System statistics Clear old statistics");?>"
vtabdescrdb[8]=Array();
vtabdescrdb[8]["name"]="<?php  echo getlang("ตั้งค่าระบบ::l::Configuration");?>"
vtabdescrdb[8]["descr"]="<?php  echo getlang("ตั้งค่าระบบ ค่าตัวแปรระบบ ข้อมูลพื้นฐานของระบบ การตั้งค่าส่วนบุคคล::l::Configuration System settings Personal settings");?>"
vtabdescrdb[9]=Array();
vtabdescrdb[9]["name"]="<?php  echo getlang("Warning");?>"
vtabdescrdb[9]["descr"]="<?php  echo getlang("การเตือน::l::Warning and notification");?>"
	function vtabclick(tabid) {
		forcedtabstop=true;
		setcookie("ulib_libmaintab",tabid);
		vtabforceclibktab(tabid);
	}
	function vtabovertab(tabid) {
		if (forcedtabstop==true) {
			return;
		}
		vtabforceclibktab(tabid);
	}
	function vtabforceclibktab(tabid) {
		descrobj=getobj("vtabdescr");
		descrobj.style.backgroundImage="url(<?php  echo $dcrURL;?>/library/vtabbg.png)";
		descrobj.style.backgroundPosition=((-2100-1050)+(tabid*103))+" 0px";
		descrobj.innerHTML="<b>&nbsp;"+vtabdescrdb[tabid]["name"]+"</b><br><font style='color: #6D6D6D; font-size: 12px;'>&nbsp;&nbsp;"+vtabdescrdb[tabid]["descr"]+"</font>";
		for (vtabhi=1;vtabhi<=9 ;vtabhi++ ) 	{
			tabbodyobj=getobj("menubody"+vtabhi);
			tabbodyobj.style.display="none";
			tabheadobj=getobj("vtabhead"+vtabhi);
			tabheadobj.style.backgroundColor="#EDEEF3";
			tabheadobj.style.zIndex=0;
			tabheadobj.style.borderColor="#b6bacd";
		}
		tabbodyobj=getobj("menubody"+tabid);
		tabbodyobj.style.display="inline";
		tabheadobj=getobj("vtabhead"+tabid);
		tabheadobj.style.backgroundColor="#e2e4eb";
		tabheadobj.style.borderColor="#505876";
		tabheadobj.style.zIndex=10;
	}

	function vtabouttab(tabid) {
		//tabheadobj=getobj("vtabhead"+tabid);
		//tabheadobj.className="vtabh";
	}

//-->
</script>
<div style="width:100%; text-align: center;display:block; height:100;clear:both; position: relative; padding-top: 5px;" ID="LIBMAINADMINTABWRAPPER">
<center><div style="width:<?php echo $_TBWIDTH;?>; height: 100; display:block;border: 0px solid #505876;clear:both;"  ID="LIBMAINADMINTABWRAPPER2">
<div style="width:<?php echo $_TBWIDTH;?>; height: 40; display:block;border: 1px solid #505876;clear:both; margin-top:60px; position:absolute; z-index: 1; text-align:left;	background-color: #e2e4eb;

" ID="vtabdescr"></div>
<div class=vtabh onmouseover="vtabovertab(1)" onmouseout="vtabouttab(1)" onclick="vtabclick(1)" ID="vtabhead1" style="margin-left:30px;"><img src="1.png" border=0 hspace=0 vspace=0 width=32 height=32 class=vtabhimg><BR>Acquisition</div>
<div class=vtabh onmouseover="vtabovertab(2)" onmouseout="vtabouttab(2)" onclick="vtabclick(2)" ID="vtabhead2"><img src="2.png" border=0 hspace=0 vspace=0 width=32 height=32 class=vtabhimg><BR>Catalogging</div>
<div class=vtabh onmouseover="vtabovertab(3)" onmouseout="vtabouttab(3)" onclick="vtabclick(3)" ID="vtabhead3"><img src="3.png" border=0 hspace=0 vspace=0 width=32 height=32 class=vtabhimg><BR>Circulation</div>
<div class=vtabh onmouseover="vtabovertab(4)" onmouseout="vtabouttab(4)" onclick="vtabclick(4)" ID="vtabhead4"><img src="4.png" border=0 hspace=0 vspace=0 width=32 height=32 class=vtabhimg><BR>Serials</div>
<div class=vtabh onmouseover="vtabovertab(5)" onmouseout="vtabouttab(5)" onclick="vtabclick(5)" ID="vtabhead5"><img src="5.png" border=0 hspace=0 vspace=0 width=32 height=32 class=vtabhimg><BR>Webpage</div>
<div class=vtabh onmouseover="vtabovertab(6)" onmouseout="vtabouttab(6)" onclick="vtabclick(6)" ID="vtabhead6"><img src="6.png" border=0 hspace=0 vspace=0 width=32 height=32 class=vtabhimg><BR>Modules</div>
<div class=vtabh onmouseover="vtabovertab(7)" onmouseout="vtabouttab(7)" onclick="vtabclick(7)" ID="vtabhead7"><img src="7.png" border=0 hspace=0 vspace=0 width=32 height=32 class=vtabhimg><BR>Statistics</div>
<div class=vtabh onmouseover="vtabovertab(8)" onmouseout="vtabouttab(8)" onclick="vtabclick(8)" ID="vtabhead8"><img src="8.png" border=0 hspace=0 vspace=0 width=32 height=32 class=vtabhimg><BR>Configuration</div>
<div class=vtabh onmouseover="vtabovertab(9)" onmouseout="vtabouttab(9)" onclick="vtabclick(9)" ID="vtabhead9" style="width: 55px;"><img src="<?php 
if ($warning_count==0) {
	echo "9g";
} else {
	echo "9r";
}
?>.png" border=0 hspace=0 vspace=0 width=16 height=16 class=vtabhimg style="padding-top:16px;" align=absmiddle><font style="font-size: 10px;" color="red"><?php  echo $warning_count;?></font><BR>Warning</div>
</div>


</center>
</div>
<?php 
$subtablehtml_tbw=floor((($_TBWIDTH-200))-10);
	$subtablehtml=" width='".$subtablehtml_tbw."' cellpadding=0 cellspacing=30";
	$subtablehtmltd=" width='".floor((($_TBWIDTH-200)/2)-20)."'";
?>
<table align=center width=<?php echo $_TBWIDTH;?> style="border: 1px solid #505876">
<tr valign=top>
	<td width="<?php echo floor($_TBWIDTH-200);?>">

<div class="menubody" ID="menubody1"><TABLE <?php  echo $subtablehtml;?>>
<TR valign=top>
	<TD width=50% <?php  echo $subtablehtmltd;?>><?php 
//Acquisition
html_librarymenu("acqxls");
echo "<br>";
html_librarymenu("acqxls_setting");
if (library_gotpermission("acq-setting")) {
	?>
	 <TABLE width=100%>
	<TR>
	<TD class=table_td style="padding-left: 15px;">
<?php  echo getlang("URL สำหรับผู้ใช้::l::URLs for members"); ?> : <br>
<IMG SRC="../image/arrow.gif" WIDTH="14" HEIGHT="9" BORDER="0" ALT="" align=absmiddle>  <a href="../acqxls/req/" target=_blank>เลือกหนังสือโดยรายการ</a><br>
<IMG SRC="../image/arrow.gif" WIDTH="14" HEIGHT="9" BORDER="0" ALT="" align=absmiddle>  <a href="../acqxls/req/suggest.php" target=_blank>แนะนำรายการใหม่</a><br>
<IMG SRC="../image/arrow.gif" WIDTH="14" HEIGHT="9" BORDER="0" ALT="" align=absmiddle>  <a href="../acqxls/req/listbystatus.php?mode=reject" target=_blank>หนังสือขาดตลาด/ไม่จัดพิมพ์</a><br>
<IMG SRC="../image/arrow.gif" WIDTH="14" HEIGHT="9" BORDER="0" ALT="" align=absmiddle>  <a href="../acqxls/req/listbystatus.php?mode=ordering" target=_blank>กำลังดำเนินการสั่งซื้อ</a>

	</TD>
	</TR>
	</TABLE>
	<?php 
}
?></TD>
	<TD <?php  echo $subtablehtmltd;?>><?php 
//Acquisition v.1
html_librarymenu("acqmenu_main");
html_librarymenu("acqmenu_Edittext");
function local_acqset($item,$title) {
?><IMG SRC="../image/arrow.gif" WIDTH="14" HEIGHT="9" BORDER="0" ALT="" align=absmiddle> <A HREF="../library.acq/index.php?item=<?php  echo $item?>"><?php echo $title?></A><BR>
<?php 	
}
if (library_gotpermission("acq-setting")) {
	?>
	 <TABLE width=100%>
	<TR>
	<TD class=table_td style="padding-left: 15px;">
	<?php 
		local_acqset("send-head2","".getlang("แก้ไขที่อยู่ห้องสมุด::l::Edit library's address")."");
	?>
	<B><?php  echo getlang("ใบสั่งซื้อ::l::Ordering");?></B><BR>
	<?php 
		local_acqset("send-head","".getlang("แก้ไขข้อความส่วนหัว::l::Edit heading text")."");
		local_acqset("send-body","".getlang("แก้ไขข้อความ::l::Edit text")."");
	?>
	<B><?php  echo getlang("ใบสอบราคา::l::Request info.");?></B><BR>
	<?php 
		local_acqset("sob-head","".getlang("แก้ไขข้อความส่วนหัว::l::Edit heading text")."");
		local_acqset("sob-body","".getlang("แก้ไขข้อความ::l::Edit text")."");
	?>
	<B><?php  echo getlang("รายการหนังสือ::l::Material lists");?></B><BR>
	<?php 
		local_acqset("list-body","".getlang("แก้ไขข้อความแนะนำ::l::Edit suggestion text")."");
	?>

	</TD>
	</TR>
	</TABLE>
	<?php 
}
html_librarymenu("acqmenu_setting");
?></TD>
</TR>
</TABLE></div>
<div class="menubody" ID="menubody2"><TABLE <?php  echo $subtablehtml;?>>
<TR valign=top>
	<TD width=50%  <?php  echo $subtablehtmltd;?>><?php 
//Catalogging
html_librarymenu("mediadb"); 
echo "<br>";
html_librarymenu("addmediadb"); 
echo "<br>";
html_librarymenu("dbfulltextmenu"); 
?></TD>
	<TD <?php  echo $subtablehtmltd;?>><?php 
html_librarymenu("searchassist"); 
echo "<br>";
html_librarymenu("bibimporter"); 
echo "<br>";
html_librarymenu("collections"); 
echo "<br>";
html_librarymenu("oaiman"); 


?></TD>
</TR>
</TABLE></div>
<div class="menubody" ID="menubody3"><TABLE <?php  echo $subtablehtml;?>>
<TR valign=top>
	<TD width=50%  <?php  echo $subtablehtmltd;?>><?php 
//Circulation
html_librarymenu("service");
echo "<br>";
html_librarymenu("itemtransit");
echo "<br>";
html_librarymenu("oss");
?></TD>
	<TD <?php  echo $subtablehtmltd;?>><?php 
html_librarymenu("serviceadd");
echo "<br>";
html_librarymenu("membersetting");
?></TD>
</TR>
</TABLE></div>
<div class="menubody" ID="menubody4"><?php 
//Serials
?><TABLE <?php  echo $subtablehtml;?>>
<TR valign=top>
	<TD width=50%  <?php  echo $subtablehtmltd;?>><?php 
	html_librarymenu("serialmenu");
	?></TD>
	<TD <?php  echo $subtablehtmltd;?> ><?php 
	if (library_gotpermission("serialsmodule-manageserial")) {
		?>		<a href="<?php  echo $dcrURL; ?>/library.serials/mainmenuif.expect.php" class="a_btn smaller" target=serialiframe><?php  echo getlang("วารสารที่ถึงกำหนดรับ::l::Expected Serials");?></a>
		<br>

<center>
		<iframe style="width:98%;height: 500px;;" name="serialiframe" ID="serialiframe"></iframe></center><?php 
	}
	?></TD>
</TR>
</TABLE></div>
<div class="menubody" ID="menubody5"><?php 
//Webpage
?><TABLE <?php  echo $subtablehtml;?>>
<TR valign=top>
	<TD width=50%  <?php  echo $subtablehtmltd;?>><?php 
if (getval("_SETTING","form_at_hp")=="webbox") {
	echo "<TABLE cellpadding=10 cellspacing=1 border=0 bgcolor=aaaaaa width=350>
	<TR>
		<TD bgcolor=f0f0f0>";
	html_librarymenu("webbox");
	echo "</TD>
	</TR>
	</TABLE><BR>";
} elseif (getval("_SETTING","form_at_hp")=="Wiki") {
	echo "<TABLE cellpadding=10 cellspacing=1 border=0 bgcolor=aaaaaa width=350>
	<TR>
		<TD bgcolor=f0f0f0>";
	html_librarymenu("webmenu-webpage");
	echo "</TD>
	</TR>
	</TABLE><BR>";
} elseif (getval("_SETTING","form_at_hp")=="webpage") {
	echo "<TABLE cellpadding=10 cellspacing=1 border=0 bgcolor=aaaaaa width=350>
	<TR>
		<TD bgcolor=f0f0f0 align=right>";
	html_librarymenu("webmenu-webpage");
	echo "<BR>";
	html_librarymenu("webmenu");
	echo "<A HREF='$dcrURL' target=_blank class=smaller2><BR>".getlang("ไปยังหน้าโฮมเพจ::l::Open Homepage")."</A>";
	echo "</TD>
	</TR>
	</TABLE><BR>";
} else {
?>
<TABLE width=100% align=center class=table_border>
	<TR>
		<TD class=table_head style="color: #7F7F7F"><?php  echo getlang("ข้อความ::l::Message");?></TD>
	</TR>
	<TR>
		<TD class=table_td><?php  echo getlang("ตัวเลือกของการจัดการโฮมเพจ ถูกระงับไว้ เนื่องจากไม่ได้ใช้หน้าหลักแบบเว็บเพจ::l::Homepage options was disabled because homepage type is not 'webpage'.");?></TD>
	</TR>
	</TABLE><BR><?php 
}
html_librarymenu("borrowlane");
?><BR><?php 
html_librarymenu("ulibecard");
?><BR><?php 
html_librarymenu("webmenu_webboard");
?><BR><?php 
html_librarymenu("webmenu_bibrating");
?><BR><?php 
html_librarymenu("webmenu_bibtag");
?><BR><?php 
html_librarymenu("editfilesource");
 ?><BR><?php 
html_librarymenu("webicon");

?></TD>
	<TD <?php  echo $subtablehtmltd;?>><?php 
html_librarymenu("webmenu_web");
?><BR><?php 
html_librarymenu("webmenu_marcincorrect");
?><BR><?php 
html_librarymenu("webmenu_memfavbook");
?><BR><?php 
html_librarymenu("bookcommentmenu");
 $del=tmq("select * from webpage_bookcomment where reportdelete>0");
 if (tmq_num_rows($del)>0) {
	 $del=tmq_num_rows($del);
	echo "<FONT class=smaller2 color=darkred>&nbsp;&nbsp;".getlang("มีรายการถูกแจ้งลบ $del รายการ::l::Report for delete $del")."</FONT>";
 }
?><BR><?php 
html_librarymenu("webmenu-memregist");

?></TD>
</TR>
</TABLE></div>
<div class="menubody" ID="menubody6"><?php 
//Modules
?><TABLE <?php  echo $subtablehtml;?>>
<TR valign=top>
	<TD width=50%  <?php  echo $subtablehtmltd;?>><?php 
html_librarymenu("additionalsys");

?></TD>
	<TD <?php  echo $subtablehtmltd;?>><?php 
include("../_addons/man.php");
?></TD>
</TR>
</TABLE></div>
<div class="menubody" ID="menubody7"><?php 
//Statistics
?>
<TABLE <?php  echo $subtablehtml;?>>
<TR valign=top>
<TD width=50%  <?php  echo $subtablehtmltd;?>>
<?php 
html_librarymenu("definablestat");
echo "<br>";
html_librarymenu("statmenu-cir");
echo "<br>";
html_librarymenu("bookusestat");
echo "<br>";
html_librarymenu("statmenu-servspottimetable");?></TD>
	<TD <?php  echo $subtablehtmltd;?>><?php 
	html_librarymenu("statmenu-login");
echo "<br>";
html_librarymenu("statmenu-res");
echo "<br>";
html_librarymenu("statmenu-search");
echo "<br>";
html_librarymenu("statmenu-insidelib");
echo "<br>";
html_librarymenu("statmenu");?></TD>
</TR>
</TABLE><TABLE <?php echo $subtablehtml_tbw;?> >
<style>
.localstattab {
	width: 100%;
	background-color: #f9fcff;
}
</style>
<TR valign=top>
	<TD width=150><B>
	<A HREF="../library.stats/calendar.parent.php" target="stat_quickdetail" class="smaller localstattab">&bull; <?php  echo getlang("ทั่วไป::l::General");?></A><BR>
	<A HREF="../library.stats/daterangestat.php" target="stat_quickdetail" class="smaller localstattab">&bull; <?php  echo getlang("กิจกรรมห้องสมุด::l::Library Activity");?></A><BR>
	<A HREF="../library.stats/quickstat.php?mode=mats" target="stat_quickdetail" class="smaller localstattab">&bull; <?php  echo getlang("จำนวนทรัพยากร::l::Materials");?></A><BR>
	<A HREF="../library.stats/quickstat.php?mode=mem" target="stat_quickdetail" class="smaller localstattab">&bull; <?php  echo getlang("สมาชิก::l::Member");?></A><BR>
	</B>
	</TD>
	<TD><iframe src="" width="<?php  echo floor($subtablehtml_tbw-(150)); ?>" height=300 FRAMEBORDER="no" BORDER=0 name=stat_quickdetail
 id="stat_quickdetail" SCROLLING=YES style="border-color: #AAAAAA;border-style: solid;border-width: 1"></iframe></TD>
</TR>
</TABLE></div>
<div class="menubody" ID="menubody8">
<TABLE <?php  echo $subtablehtml;?>>
<TR valign=top>
	<TD width=50%  <?php  echo $subtablehtmltd;?>><?php 
//Configuration
html_librarymenu("basesetting");
echo "<br>";
html_librarymenu("marcstruct");
echo "<br>";
html_librarymenu("setting");
echo "<br>";
html_librarymenu("miscconfig");
echo "<br>";
html_libmann("mainadmin_config_tab");
?></TD>
	<TD <?php  echo $subtablehtmltd;?>><?php 
html_librarymenu("systemvar");
echo "<br>";
//printr($_COOKIE);
if (getval("_SETTING","islibcanusecookielogin")=="yes") {
	$libraryautologincookie=trim($_COOKIE[LIBAUTHC]);
	 ?><div  style=';font-size:11;' ID="LIBAUTHCOOKIEDIV"><table width=315>
	 <tr valign=top>
		<td width=32><img src="../neoimg/icon_secure_50x50.png" width="32" height="32" border="0" alt="" style=""></td>
		<td style=';font-size:11;'><?php 
		$libraryautologincookies=tmq("select * from library_cookielogin where dat='$libraryautologincookie' and loginid='$useradminid' ");
		if (tnr($libraryautologincookies)!=0) {
			$libraryautologincookiers=tfa($libraryautologincookies);
			echo "<B  style='color:red;font-size:11;' >คำเตือน!</B><BR>".getlang("คุณได้ตั้งคอมพิวเตอร์เครื่องนี้สำหรับการล็อกอินอัตโนมัติ::l::You allow this PC to Autologin")."<BR>
			<b class=smaller2>".getlang("ชื่อเครื่อง::l::PC Name").":".$libraryautologincookiers[pcname]."</b><br><A HREF='mainadmin.php?clearcookieautologin=yes' style=';font-size:11;'>".getlang("คลิกที่นี่เพื่อยกเลิกการล็อกอินอัตโนมัติ::l::Click here to cancel Autologin ")."</A>";
		} else {
			echo "<span  style='color:darkgreen;font-size:11;'>".getlang("คุณสามารถอนุญาตให้เครื่องปัจจุบันที่กำลังใช้งานล็อกอินอัตโนมัติ::l::You can allow this PC to Autologin")."</span><BR>
			<img border=0 src='../neoimg/misc/errsm.gif' align=absmiddle width=10 height=10> <A HREF='javascript:void(null);'  
			onclick=\"tmp=getobj('cookieautologinsetting'); tmp.style.display='block';\"
			style=';font-size:11;'>".getlang("คลิกที่นี่เพื่อให้เครื่องนี้ล็อกอินอัตโนมัติด้วย Cookie::l::Click here to allow this PC to Autologin")."</A>";
			?> <div id="cookieautologinsetting" style="display:none">
				<form method="post" action="<?php  echo $PHP_SELF?>" style="display:inline">
			<input type="hidden" name="addcookieautologin" value="yes">
				<?php  echo getlang("กำหนดชื่อเครื่อง::l::Set Computer Name"); ?><br><input type="text" name="pcname" placeholder="<?php  echo getlang("ใส่ชื่อเครื่องที่นี่::l::Set PC name here");?>"> <input type="submit" value="save">
			</form> 
			</div><?php 
		}
	 ?><br><a href="mancookie.php" class="smaller2 a_btn"><?php  echo getlang("จัดการเครื่องที่บันทึกการล็อกอินอัตโนมัติไว้::l::Manage auto login");?></a></td>
	 </tr>
	 </table></div><?php 
}

if (getval("_SETTING","islibchangeautologin")=="yes") {
	if ($clearautologin=="yes") {
		tmq("update library set ipautologin='' where UserAdminID='$useradminid' ");
	}
	if ($setthisipautologin=="yes") {
		tmq("update library set ipautologin='$IPADDR' where UserAdminID='$useradminid' ");
	}
	 ?><div  style=';font-size:11;'><?php 
	 $chkip=tmq("select * from library where UserAdminID='$useradminid' ",false); 
	 $chkip=tmq_fetch_array($chkip);
		if 	(trim($chkip[ipautologin])!="") {
			?><img border=0 src="../neoimg/ipicon.png" align=left width=32 height=32> <?php 
			if ( "$chkip[ipautologin]"!="$IPADDR") {
				echo "<B  style='color:red;font-size:11;' >คำเตือน!</B><BR>".getlang("ขณะนี้ คุณได้ใช้เครื่องที่มีหมายเลข IP ไม่ตรงกับหมายเลข IP สำหรับล็อกอินอัตโนมัติ!::l::Current IP does no match with your Autologin IP!")."<BR> <A HREF='mainadmin.php?clearautologin=yes' style=';font-size:11;'>".getlang("คลิกที่นี่เพื่อยกเลิกการล็อกอินอัตโนมัติด้วยไอพี::l::Click here to cancel Autologin IP")."</A><BR>";
				echo "<FONT class=smaller2 COLOR=#8F8F8F>ip:$IPADDR</FONT>";
			} else {
				echo "<span  style='color:darkgreen;font-size:11;'>".getlang("ขณะนี้ คุณได้ตั้งหมายเลข IP สำหรับล็อกอิน<BR> เป็น $IPADDR (เครื่องปัจจุบันที่กำลังใช้งาน)::l::Your Autologin IP is $IPADDR<BR> (Current IP)")."</span><BR>
				<img border=0 src='../neoimg/misc/errsm.gif' align=absmiddle width=10 height=10> <A HREF='mainadmin.php?clearautologin=yes'  style=';font-size:11;'>".getlang("คลิกที่นี่เพื่อยกเลิกการล็อกอินอัตโนมัติด้วยไอพี::l::Click here to cancel Autologin IP")."</A>";
			}
		} else {
		?>	<img border=0 src="../neoimg/misc/errsm.gif" align=absmiddle width=10 height=10> <A HREF='mainadmin.php?setthisipautologin=yes' style=';font-size:11;'><?php  echo getlang("คลิกที่นี่เพื่อกำหนด ล็อกอินอัตโนมัติด้วยไอพี:::l::Click here to set this Autologin IP to:");?> <?php  echo $IPADDR?></A><BR>
<?php 
		}
		?></div><BR><?php 
}
if (getval("_SETTING","islibcanchangeownpassword")=="yes") {
	 ?><div  style=';font-size:11;  '><br><?php 
			?><img border=0 src="../neoimg/password.png" align=absmiddle width=16 height=16> <?php 
				echo "<A HREF='mainadmin.php?changepassword=yes' style=';font-size:11; color: #804040'>".getlang("คลิกที่นี่ เพื่อเปลี่ยนรหัสผ่านของคุณ::l::Click here to change password.")."</A>";
		?></div><?php 
}

if ($deletelibrarianava=="yes") {
	@unlink($dcrs."_tmp/_librarianava/$useradminid.jpg");
}
if ($updatelibrarianava=="yes") {
	if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
		@unlink($dcrs."_tmp/_librarianava/$useradminid.jpg");
		if (copy($_FILES['userfile']['tmp_name'], $dcrs."_tmp/_librarianava/$useradminid.jpg")) {
			fso_image_fixsize($dcrs."_tmp/_librarianava/$useradminid.jpg","jpg",450);
		} else {
			echo "ไม่สามารถเคลื่อนย้ายไฟล์ไปยังที่จัดเก็บได้\n";
			echo( "error");
		}
	} else {
	   echo "กรุณาเลือกไฟล์";
	}
}
		?>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100% class=table_border ID="MAINADMIN_CHAVARTARTABLE">
		<TR valign=top>
			<TD width=106><IMG SRC="<?php  echo get_library_pic($useradminid);?>" hspace=3 vspace=3 WIDTH="100" BORDER="0" ALT=""></TD>
			<TD><A HREF="javascript:void(null)" onclick="tmp=getobj('formuploadlibrarianava');tmp.style.display='block'" class="smaller a_btn"><?php  echo getlang("แก้ไขภาพประจำตัว::l::Edit avartar");?></A><BR>
			<?php 	
				if (file_exists($dcrs."_tmp/_librarianava/$useradminid.jpg")) {
				?>
			<A HREF="mainadmin.php?deletelibrarianava=yes" class="smaller a_btn" onclick="return confirm('Delete avatar?');"><?php  echo getlang("ลบภาพประจำตัว::l::Delete avartar");?></A><?php 
				}	
		?></TD>
		</TR>
		</TABLE>
<div ID=formuploadlibrarianava style="display:none">
<FORM METHOD=POST ACTION="mainadmin.php" enctype="multipart/form-data">
	<INPUT TYPE="hidden" NAME="updatelibrarianava" value="yes">
<INPUT TYPE="file" NAME="userfile"><BR><?php  echo getlang("ไฟล์ประเภท jpg เท่านั้น");?> <BR><INPUT TYPE="submit" value="อัพโหลด">
</FORM>
</div>
<?php 
echo "<br>";
html_librarymenu("personalsettings");

?>
</TD>
</TR>
</TABLE>
</div>
<div class="menubody" ID="menubody9">
   <div  style="padding-left: 13px!important; min-height: 500px;">
      <?php  echo stripslashes($warning_str);?>
   </div>
</div>
</td>

	<td ID=libmannlibrarianmsg>
<?php 
if (getval("_SETTING","uselibrarianmsgboard")=="yes") {
?>   <div ID=librarianmsg style="width: 98% ;height: 18; border: 1px solid #E9E9E9; background-color: #EAEAEE; text-align: center; font-size: 13;padding: 2 2 2 2; vertical-align: middle;">

   <?php  echo getlang("ข้อความระหว่างเจ้าหน้าที่ห้องสมุด::l::Officer message box");?>

   </div>
   <div ID=librarianmsg style="width: 98% ; overflow: visible; border: 1px solid #E9E9E9; background-color: #F8F8F8; text-align: left; font-size: 13;padding: 10 2 10 2;" >
   <?php  echo barcodeval_get("librarianmsg");?><BR>
   - - - - - - - - - - - - - - <BR>
   <?php 
   echo getlang("แก้ไขล่าสุด::l::Last update:")." ";
   echo ymd_datestr(barcodeval_get("librarianmsg-dt"),"shortdt");
   echo "<BR>".get_library_name(barcodeval_get("librarianmsg-lastlib"));
   echo "<BR>(".ymd_ago(barcodeval_get("librarianmsg-dt")).")";
   ?>
   </div>
   <A HREF="mainadmin.php?editlibrarianmsg=yes" class="a_btn smaller2"><?php  echo getlang("แก้ไขข้อความ::l::Edit message");?></A> <?php 
   viewdiffman("librarianmsg","librarianmsg");
   ?>
   <?php 
   $libfile=tmq("select * from globalupload where keyid='librarianmsg' order by filename");
   if (tmq_num_rows($libfile)!=0) {
   	echo "<div ID=librarianmsg style=\"width: 98% ; overflow: visible; border: 1px solid #E9E9E9; background-color: #F8F8F8; text-align: left; font-size: 13;padding: 10 2 10 2;\" ><FONT class=smaller style='font-weight: bold'>".getlang("ไฟล์ที่แนบมาด้วย::l::Attatched file(s)")."</FONT><BR>";
   	while ($libfiler=tmq_fetch_array($libfile)) {
   		echo "<A HREF='$dcrURL/_globalupload/librarianmsg/$libfiler[hidename]' target=_blank class=smaller2>&bull; ".stripslashes($libfiler[filename])."</A><BR>";
   	}
   	echo "</div>";
   }
   echo "<HR>";
}
?><div ID="MAINADMINLIBQUICKLINKTABLE"><?php 
if(library_gotpermission("quicklink")) {
?>
<TABLE width=100%>
<TR>
<TD class=mnhead colspan=2><?php  echo getlang("ลิงค์ด่วน::l::Quick links"); ?></TD>
</TR>
<TR>
<TD class=table_td colspan=2><A HREF="../root/" class=smaller2><?php  echo getlang("ระบบเจ้าหน้าที่สูงสุด::l::Administrator system"); ?></A>
<A HREF="../root/"  target=_blank><IMG SRC="../neoimg/newwin.gif" WIDTH="13" HEIGHT="13" BORDER="0" ALT=""></A>
</TD>
</TR>
<TR>
<TD class=table_td colspan=2><A HREF="../"  class=smaller2><?php  echo getlang("หน้าหลักโปรแกรม ::l::Homepage "); ?></A>
<A HREF="../"  target=_blank><IMG SRC="../neoimg/newwin.gif" WIDTH="13" HEIGHT="13" BORDER="0" ALT=""></A>
</TD>
</TR>
<TR>
<TD class=table_td colspan=2><A HREF="./sound/" class=smaller2><?php  echo getlang("ประกาศ ::l::Sounds "); ?></A></TD>
</TR>
<!--
<TR>
<TD class=table_td  colspan=2><A HREF="../webboard/index.php" class=smaller2><?php  echo getlang("ไปหน้าเว็บบอร์ด::l::Webboard"); ?></A>
<A HREF="../webboard/index.php"  target=_blank><IMG SRC="../neoimg/newwin.gif" WIDTH="13" HEIGHT="13" BORDER="0" ALT=""></A>
-->

</TD>
</TR>
<TR>
<TD class=table_td colspan=2 align=right><B>
<A HREF="../link/index.php" class=smaller2><?php  echo getlang("ลิงค์อื่น ๆ::l::Other Links"); ?> .. &nbsp;</A>
</B></TD>
</TR>
</TABLE>
<?php }?></div>
<div style="display:inline; font-size: 11px; color: #333;" ID='mainadminserverclock'></div>

<script type="text/javascript">
var serverTime = <?php  echo time() * 1000; ?>; //this would come from the server
var localTime = +Date.now();
var timeDiff = serverTime - localTime;

setInterval(function () {
    var realtime = +Date.now() + timeDiff;
    var date = new Date(realtime);
    // hours part from the timestamp
    var hours = date.getHours();
    // minutes part from the timestamp
    var minutes = date.getMinutes();
    // seconds part from the timestamp
    var seconds = date.getSeconds();

    var months = date.getMonth()+1;
    var dates = date.getDate();
    var years = date.getFullYear();

    // will display time in 10:30:23 format
    var formattedTime ="Server Time: "+dates+"/"+months+"/"+years+ " "+hours + ':' + minutes + ':' + seconds;
	tmp=getobj("mainadminserverclock");
    tmp.innerHTML=formattedTime; 
}, 1000);
</script>
	</td>
</table>
</td>
</tr>
</table>
<script type="text/javascript">
<!--
	deftab=getcookie("ulib_libmaintab");
	deftab=Math.floor(deftab);
	if (deftab==0) {
		deftab=8; //config
	}
	if(window.location.hash) {
		  // Fragment exists
		 // alert(window.location.hash);
		 if (window.location.hash=="#acq") {
			deftab=1;
		 }
		 if (window.location.hash=="#cat") {
			deftab=2;
		 }
		 if (window.location.hash=="#cir") {
			deftab=3;
		 }
		 if (window.location.hash=="#ser") {
			deftab=4;
		 }
		 if (window.location.hash=="#web") {
			deftab=5;
		 }
		 if (window.location.hash=="#mod") {
			deftab=6;
		 }
		 if (window.location.hash=="#stat") {
			deftab=7;
		 }
		 if (window.location.hash=="#conf") {
			deftab=8;
		 }
		 if (window.location.hash=="#warning") {
			deftab=9;
		 }
	}
	vtabovertab(deftab);

		<?php 
	if (barcodeval_get("personalsetting-o-mainmenuswitchtabmode-$useradminid")=="Click") {
		?>
			forcedtabstop=true;
		<?php 
	}
	?>
//-->
</script>

<?php 

if ($firsttimemenu!="") {
?><?php 
}
				foot();
?>