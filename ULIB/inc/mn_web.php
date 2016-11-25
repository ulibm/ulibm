<?php 
function mn_web($_REQPERM="") {
	global $loginadmin;
	global $mn_web_evercalled; // ใช้ระงับการแสดงเมื่อแสดง topmenu ใน webbox ด้วย
	global $mn_web_nohomepage;
	global $dcr;
	global $dcrs;
	global $_memid;
	global $dcrURL;
	global $PHP_SELF;
	global $_TBWIDTH;
	if ($_REQPERM=="") {
		die("<B>mn_web()</B> error: require \$_REQPERM;");
	}
	if ($mn_web_evercalled!="") {
	$mn_web_evercalled="yes";
		return;
	}
	$mn_web_evercalled="yes";

	$_REQPERMDB["browse-browseftlist"]=getlang("รายการทรัพยากรสารสนเทศ::l::Material list");
	$_REQPERMDB[oss]=getlang(barcodeval_get("oss-o-name"));
	$_REQPERMDB[publicholdlist]=getlang("รายการค้างส่งทรัพยากร::l::Public Holding records");
	$_REQPERMDB[requestroom]=getlang("จองห้องใช้งาน::l::Request Service Room");
	$_REQPERMDB[usoundex]=getlang("รายละเอียดเกี่ยวกับ USOUNDEX::l::USOUNDEX Information");	
	$_REQPERMDB[about]=getlang("เกี่ยวกับระบบ::l::About Software");	
	$_REQPERMDB[memforgotpassword]=getlang("ลืมรหัสผ่าน::l::Forgot Password");	
	$_REQPERMDB[acq]=getlang("ระบบจัดหา::l::Acquisition");	
	$_REQPERMDB[advsearch]=getlang("สืบค้นข้อมูลชั้นสูง::l::Advance Searching");	
	$_REQPERMDB[search]=getlang("สืบค้นข้อมูล::l::Searching");	
	$_REQPERMDB[closeservice]=getlang("วันที่ห้องสมุดปิดทำการ::l::Close service days");	
	$_REQPERMDB[resource_type]=getlang("ข้อมูลประเภทวัสดุสารสนเทศ::l::Resource Type Information");	
	$_REQPERMDB[exportmarked]=getlang("ส่งออกข้อมูล::l::Export Data");	
	$_REQPERMDB["browse-title"]=getlang("แสดงข้อมูลทั้งหมดในฐานข้อมูลตามชื่อเรื่อง::l::Browse database by titles");	
	$_REQPERMDB["browse-auth"]=getlang("แสดงข้อมูลทั้งหมดในฐานข้อมูลตามชื่อผู้แต่ง::l::Browse database by Author");	
	$_REQPERMDB[contact]=getlang("ติดต่อเจ้าหน้าที่::l::Contact Librarian");	
	$_REQPERMDB[freedb]=getlang("ฐานข้อมูลใช้ฟรี::l::Free Databases");	
	$_REQPERMDB[collections]=getlang("เลือกคอลเล็กชั่นเพื่อสืบค้น::l::Select collections to search from");	
	$_REQPERMDB[member]=getlang("ตรวจสอบรายละเอียดส่วนตัว::l::Check personal record");	
	$_REQPERMDB[stopword]=getlang("เกี่ยวกับ Stop words::l::About Stop words");	
	//$_REQPERMDB[webboard]=getlang("ระบบกระดานข่าว (เว็บบอร์ด)::l::Webboard");	
	$_REQPERMDB[webpage]=getlang("หน้าหลักเว็บไซต์::l::Homepage");	
	$_REQPERMDB["webpage-article"]=getlang("หน้าหลักเว็บไซต์ห้องสมุด -- บทความ::l::Library's homepage -- articles");	
	$_REQPERMDB[itemplace]=getlang("สถานที่จัดเก็บวัสดุสารสนเทศ::l::Shelves and code");		
	$_REQPERMDB[usis]=getlang("ULIBM : Single search::l::ULIBM : Single search");		
	$_REQPERMDB["browse-subject"]=getlang("รายการหัวเรื่อง::l::Subjects");		
	$_REQPERMDB["browse-reservmat"]=getlang("รายการหนังสือสำรอง::l::Reserved Books");		
	$_REQPERMDB["dspbib"]=getlang("แสดงรายละเอียดบรรณานุกรม::l::Display Bibliograpic Detail");		
	$_REQPERMDB["memregist"]=getlang("สมัครสมาชิกออนไลน์::l::Online Registration");		
	$_REQPERMDB["indexphotonews"]=getlang("ข่าว::l::News");		
		


	$_REQPERMDB[xxx]=getlang("xxx::l::xxx");
	
		$tmp=$_REQPERMDB[$_REQPERM];
		if ($_REQPERM=="webboard") {
			$tmp=getlang(barcodeval_get("webboard-boardname"));
		}
		if ($_REQPERM=="answerpoint") {
			$tmp=getlang(barcodeval_get("answerpoint_name"));
		}
		if ($_REQPERM=="lostandfound") {
			$tmp=getlang(barcodeval_get("lostandfound_name"));
		}
	if ($tmp=="") {
		die("<B>mn_web()</B> error: require \$_REQPERM=$_REQPERM, <B>Not found description;</B>");
	}

?> 

<table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "0" cellpadding = "0" ID="WEBPAGE_MENU">
 <tr valign=top >
<td  style="padding-left: 0px; color: #000000; " class=smaller  align=left  background="<?php  echo $dcrURL?>neoimg/webbarbg.jpg"><img src="<?php  echo $dcrURL?>neoimg/webbarbg-head.jpg" align=absmiddle border=0 >&nbsp;<?php 
echo $tmp;
?></td>
<td align="right" background="<?php  echo $dcrURL?>neoimg/webbarbg.jpg">
<?php 
if (	$mn_web_nohomepage!="yes") {
	html_xpbtn(getlang("กลับหน้าหลัก::l::Back to Homepage").",$dcrURL"."index.php?rescanhp=yes&".randid().",blue");
}
?></td>
</tr><?php 
$htmlundertopmenu=trim(barcodeval_get("webpage-o-htmlundertopmenu")	);
$htmlundertopmenu=trim(stripslashes($htmlundertopmenu));
if ($htmlundertopmenu!="") {
?>
<TR>
	<TD colspan=2><?php  echo $htmlundertopmenu;?></TD>
</TR><?php 
}	
?>
</table><?php 
	if ($_memid!="") {
		 include($dcrs."/member/menuadmin.php");
	}
}
?>