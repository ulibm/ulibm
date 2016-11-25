<?php 
//    ;

//	print_r($_SESSION);
include("../inc/config.inc.php");
head();
mn_root("mainadmin");
function local_menu($text,$url,$descr,$img="") {
	global $dcr;
	?><table width = "550" align=center border = "0" cellspacing = "0" cellpadding = "0">
		<tr>
			<td rowspan = "2" valign=middle width=35><?php 
	if ($img!="") {
		echo "<img src='../neoimg/misc/$img'>";	
	}
	?>&nbsp;</td>
			<td width = "525">
				<a class = stupidmenu href = "<?php  echo $url;?>">
				<font size = "5" class = stupidmenu style="font-size: 18px;"><?php  echo $text;?></font></a></font></td>
		</tr>
		<tr>
			<td width = "525">
				<font  size = "2" style="font-size: 12px;">&nbsp;<?php  echo $descr;?></font></td>
		</tr>
		<tr>
			<td colspan = "2" height = "2">
				<font size = "2" >
				<img src = "/<?php echo "$dcr"; ?>/images/spacer.gif" width = "1" height = "5"></font></td>
		</tr>
	</table>
<?php 
}


?><CENTER><BR>
<?php 
	  if (strpos($dcrURL,"localhost")>1 || strpos($dcrURL,"127.0.0")>1  ) {
		echo "<FONT class=smaller color=red style='display:block; width: 600;'>".getlang("<B class=smaller >คำเตือน</B>: หากคุณติดตั้ง ULibM ตัวนี้โดยใช้ชื่อเซิร์ฟเวอร์เป็น localhost หรือ 127.0.0._ แสดงว่าคุณติดตั้งเซิร์ฟเวอร์บนเน็ทเวิร์คภายใน ทำให้<U>ไม่</U>สามารถออนไลน์ได้ในทุกกรณี หากเซิร์ฟเวอร์ของคุณสามารถเชื่อมต่ออินเทอร์เน็ทได้ แนะนำให้ติดตั้ง ULibM โดยใช้หมายเลขไอพีจริง หรือชื่อโดเมน::l::<B class=smaller >Warning</B>: If this copy of ULibM install with domain 'localhost' or 127.0.0._ , means this copy can online in <U>local network only,</U> if possible please install ULibM with external IP (real ip) or domain name.")."</FONT><BR>";
	  }

?></CENTER>
<TABLE width=650 align=center>
<TR>
	<TD>
<?php 



if ($_ISULIBHAVESTER=="yes") {
	 ?><FIELDSET style="background-color: #ffd1c1;">
<LEGEND style="color: #f00"><b>ULIB Havester Server mode</b></LEGEND>
	<?php
local_menu(getlang("Clients list"),"../_havester/sv/clientlist.php",getlang("Registered Clients"),"CATLG.GIF");
local_menu(getlang("Setting"),"../_havester/sv/setting.php",getlang("Options"),"CATLG.GIF");
?>
</FIELDSET><?php
}


if ($rootallowlibrarianlogin!="") {
	barcodeval_set("rootallowlibrarianlogin","$rootallowlibrarianlogin");
}

$ise=barcodeval_get("rootallowlibrarianlogin");

if ($ise=="no") {
	 ?><FIELDSET style="background-color: #ffd1c1;">
	<LEGEND style="color: #f00"><b>Block mode</b></LEGEND>
		<CENTER><?php 
echo getlang("ขณะนี้ ไม่อนุญาตให้เจ้าหน้าที่ห้องสมุดล็อกอินเข้าระบบ<BR>แต่เจ้าหน้าที่ที่ล็อกอินเข้ามาแล้ว อาจจะกำลังทำงานอยู่ <BR> สามารถตรวจสอบการตั้งค่าได้ที่แบบฟอร์มส่วนล่างสุดของเพจนี้::l::Currently disallow librarian to login to system,<BR> the already-login librarian may working.<BR>Please check this option at foot of this page.");	?></CENTER>
	</FIELDSET><?php 
}
if ($_ISULIBMASTER=="yes") {
	 ?><FIELDSET style="background-color: #ffd1c1;">
<LEGEND style="color: #f00"><b>ULIB Master server mode</b></LEGEND>
	<?php 
local_menu(getlang("Clients list"),"../activateulib/sv/clientlist.php",getlang("Registered Clients"),"CATLG.GIF");
local_menu(getlang("User's logins"),"../activateulib/sv/clientlogins.php",getlang("Registered Clients - logins to UUG"),"CATLG.GIF");
?>
</FIELDSET><?php 
}

?>
<FIELDSET>
<LEGEND style="color: #484F84"><?php  echo getlang("สิทธิ์การเข้าใช้งาน::l::Authenticate Control");?></LEGEND>
<?php 
local_menu(getlang("จัดการรายชื่อเจ้าหน้าที่ระบบ::l::Administrator login"),"../root.userroot/",getlang("จัดการรายชื่อเจ้าหน้าที่สูงสุด::l::Manage administrator login"),"LTWORKSP.GIF");

local_menu(getlang("จัดการรายชื่อเจ้าหน้าที่ห้องสมุด::l::Librarian's login"),"../root.userlibrary/",getlang("จัดการรายชื่อและการอนุญาตของเจ้าหน้าที่ที่จะล็อกอินเข้ามาทำงาน::l::Manage librtarian's login"),"LTWORKSP.GIF");
?>
</FIELDSET>
<CENTER>
<?php 
   
	  if (tnr(tmq("select  * from useradmin where UserAdminID='root' and Password=md5('ulibm123') "))!=0) {
		echo "<FONT class=smaller color=red style='display:block; width: 600;'>".getlang("<B class=smaller >คำเตือน</B>: ยังไม่ได้เปลี่ยนล็อกอินรหัสผ่านเริ่มต้นของเจ้าหน้าที่สูงสุด::l::<B class=smaller >Warning</B>: You are using default login&password for Adminstrator</FONT><BR>");
	  }
	  if (tnr(tmq("select  * from library where UserAdminID='full' and Password=md5('ulibm123') "))!=0 ) {
		echo "<FONT class=smaller color=red style='display:block; width: 600;'>".getlang("<B class=smaller >คำเตือน</B>: ยังไม่ได้เปลี่ยนล็อกอินรหัสผ่านเริ่มต้นของเจ้าหน้าที่ห้องสมุด::l::<B class=smaller >Warning</B>: You are using default login&password for Librarian</FONT><BR>");
	  }

?></CENTER>
<?php 
local_menu(getlang("สำรองข้อมูล::l::Backup"),"../root.backup/index.php",getlang("ทำการสำรองข้อมูลทั้งหมดในฐานข้อมูล::l::Backup entire database"),"ITDLP.GIF");
?>


</TD>
</TR>
</TABLE><?php 
function local_smallmenucss($text,$url) {
	global $dcr;
	?><li><a href="<?php  echo $url;?>" ><?php  echo $text;?></a></li><?php 
}
function local_smallmenu($text,$url) {
	global $dcr;
	?><a  href = "<?php  echo $url;?>"> <IMG SRC="../neoimg/Burn.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle>
				<font size = "5" class = stupidmenu style="font-size: 14px;"><?php  echo $text;?></font></a></font><BR>
<?php 
}

?><BR>
<style type="text/css">

/*Credits: Dynamic Drive CSS Library */
/*URL: http://www.dynamicdrive.com/style/ */

.markermenu{
width: 100%; /*width of menu*/
}

.markermenu ul{
list-style-type: none;
margin: 5px 0;
padding: 0;
border: 1px solid #9A9A9A;
}

.markermenu ul li a{
background: white url(./arrow-list.gif) no-repeat 2px center;
font: bold 14px Tahoma;
color: #800000;
display: block;
width: auto;
padding: 3px 0;
padding-left: 20px;
text-decoration: none;
border-bottom: 1px solid #B5B5B5;
}


* html .markermenu ul li a{ /*IE only. Actual menu width minus left padding of LINK (20px) */
width: 100%;
}

.markermenu ul li a:visited, .markermenu ul li a:active{
color: #800000;
}

.markermenu ul li a:hover{
color: black;
background-color: #ffffcb;
background-image:url(./arrow-list-red.gif); /*onMouseover image change. Remove if none*/
}

</style>


<?php  $submenubg="#39629F";?>
<TABLE width=600 align=center border=0 cellpadding=10 cellspacing=1 bgcolor=000000>


<TR bgcolor="<?php  echo $submenubg?>">
	<TD  align=center><B style="color: white"><?php  echo getlang("การตั้งค่าระบบเสริม::l::Additional Modules Setting"); ?></B></TD>
	<TD  align=center><B style="color: white"><?php  echo getlang("Tools::l::Tools"); ?></B></TD>
</TR>
<TR valign=top>
	<TD bgcolor=white width=50%><div class="markermenu">
<ul><?php  
	local_smallmenucss(getlang("ตรวจสอบความต้องการของระบบ::l::System requirement"),"./function_req.php");
	local_smallmenucss(getlang("รายชื่อเซิร์ฟเวอร์ Z39.50::l::Z39.50 Server list"),"../root.yaz_server/");
	local_smallmenucss(getlang("ปิด/รีบูทเซิร์ฟเวอร์::l::Shutdown/reboot server"),"../root.svboot/");
	local_smallmenucss("Log files","../root.logbrowser/");
	local_smallmenucss("Log Enter module","../root.logentermodule/");

	?></ul>
</div></TD>
	<TD bgcolor=white width=50%><div class="markermenu">
<ul><?php  
 local_smallmenucss(getlang("บำรุงรักษาฐานข้อมูล::l::DB miantainience "),"../root.dbmantain/index.php","","ITDLP.GIF");
 local_smallmenucss(getlang("ไฟล์เครื่องมืออื่น ๆ::l::Utility file"),"../root.utils/");
 //local_smallmenucss(getlang("นำเข้าข้อมูลวัสดุฯ::l::Media Importer"),"../root.importer_book/index.php","","ITDLP.GIF");
 local_smallmenucss(getlang("กระดาษเตือนความจำ::l::Reminder sheet"),"./remindersheet.php");
	?></ul>
</div></TD></TR>
<TR bgcolor="<?php  echo $submenubg?>">
	<TD  align=center><B style="color: white"><?php  echo getlang("การ extract หัวเรื่อง::l::Subject extracting"); ?></B></TD>
	<TD  align=center><B style="color: white"><?php  //echo getlang("ระบบ Collections::l::Collections Configurations"); ?></B></TD>
</TR>

<TR valign=top>
	<TD bgcolor=white width=50%><div class="markermenu">
<ul><?php  
	local_smallmenucss(getlang("รายการหัวเรื่อง::l::Subject Heading list"),"../root.subjextracted/");
	local_smallmenucss(getlang("สร้างรายการหัวเรื่อง::l::Create Subject Heading list"),"../root.subjextract/");
	local_smallmenucss(getlang("รายการหัวเรื่องที่ Extract เข้ามาแล้ว::l::Extracted Subject Heading"),"../root.subjextractedimportid/");

	?></ul>
</div></TD>
	<TD bgcolor=white width=50% align=left valign=middle style="font-size:10px; padding-left: 65px; color: #755755">
	<?php 
	echo getval("SYSCONFIG","credits");
	?>
<BR>
<BR>
<?php 
 	html_guidebtn(getlang("License Information").",../activateulib/,green,_self");

?>
</TD>
	
</TABLE>




<CENTER><A HREF="javascript:void(0)" onclick="loadMyMenu_NotYou();" style="color: #FFC980; font-size: 10px;">Expanded Configuration and tools </a></CENTER>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		
	function loadMyMenu_NotYou() {
		tmp=getobj('MyMenu_NotYou');
		if (tmp.style.display=="block")
		{
			tmp.style.display="none"
		} else {
			tmp.style.display="block"
		}
	}
	//-->
	</SCRIPT>
<span id="MyMenu_NotYou" style="display: none; ">
<TABLE width=600 align=center border=0 cellpadding=2 cellspacing=1 bgcolor=000000>


	<TR bgcolor=#800000>
	<TD  align=center><B style="color: white"><?php  echo getlang("เครื่องมือสำหรับเจ้าหน้าที่ระบบ::l::Super Administrative Mod."); ?></B></TD>
	<TD  align=center><B style="color: white"><?php  echo getlang("เครื่องมือดูแลรักษาระบบ::l::System maintainience"); ?></B></TD>
</TR>
<TR valign=top>
	<TD bgcolor=white width=50% style="font-size:10px; padding-left: 15px; color: #484848" valign=middle align=left>

These tools are commonly used by Ulibm's Developer team only. 
And use once at first time to setup  (or re-install) Ulibm.
All customers has no any neccessary to use these functions.
Because some function can destroy your databas easily, and all damanage done by customers won't be any resiponsible to Ulibm's Developer team
</TD>
	<TD bgcolor=white width=50%><?php  
	local_smallmenu(getlang("ค่าตัวแปรทั้งหมดของระบบ::l::All System variables"),"../root.val/media_type.php","","LTSURVEY.GIF");
	local_smallmenu(getlang("เคลียร์แคช ค่าตัวแปร::l::Clear Variables cache"),"../root/clearcache.php","","LTSURVEY.GIF");

	local_smallmenu("phpinfo();","phpinfo.php");
	local_smallmenu(getlang("ข้อมูลเซิร์ฟเวอร์::l::Server Information"),"../root.shellinfo/index.php");
	local_smallmenu(getlang("การตั้งค่าทั่วไปของระบบ::l::Base system configuration"),"../root/configinfo.php");
	local_smallmenu(getlang("ตัวจัดการฐานข้อมูล::l::DB Manager"),"../admin.tb_editor/list.php");
	local_smallmenu(getlang("File Browser"),"../root.filebrowser/index.php");
	local_smallmenu(getlang("Chmod/Chown"),"chmodchown.php");

	?></TD></TR>
	
	<TR bgcolor=#800000>
	<TD  align=center><B style="color: white"><B><?php  echo getlang("Database & Upgrade Tools"); ?></B></B></TD>
	<TD  align=center><B style="color: white"><?php  echo getlang("ปรับแต่งค่าแสดงผลสำหรับผู้ดูแลระบบ::l::Administration Display Setting"); ?></B></TD>
</TR>
<TR valign=top>
		<TD bgcolor=white width=50%>
<?php 
  
	local_smallmenu(getlang("เคลียร์ (รีเซ็ท) ฐานข้อมูล::l::Clear (reset) database"),"../root.cleardb/index.php","","ITDLP.GIF");
	local_smallmenu(getlang("ตัวทำคำสั่ง SQL::l::SQL Executor"),"../root.sqlexec/index.php","","ITDLP.GIF");
//	local_smallmenu(getlang("นำเข้าข้อมูลไอเทม(โยงกับวัสดุ)::l::Items Importer (Relate with media)"),"../root.importer_bookitem/index.php","","ITDLP.GIF");
//	local_smallmenu(getlang("ตัวกำหนดการนำเข้าข้อมูลวัสดุฯ::l::Media Importer mapping"),"../root.importer_book_map/index.php","","ITDLP.GIF");
	local_smallmenu(getlang("อัพเกรดตาราง::l::Table Upgrade"),"../root.upgrade_table/index.php","","ITDLP.GIF");
	local_smallmenu(getlang("อัพเกรด Variable เป็นเวอร์ชันล่าสุด::l::Upgrade Variable"),"../root.upgrade_variable/index.php","","ITDLP.GIF");
	local_smallmenu(getlang("DB Morph"),"../root.dbmorph/index.php","","ITDLP.GIF");
	local_smallmenu(getlang("ปรับ ULIBM เป็นเวอร์ชันล่าสุด::l::ULIBM-Upgrade to current"),"../root.upgrade_tocurrent/index.php","","ITDLP.GIF");
	local_smallmenu(getlang("ฟื้นคืนข้อมูลแบ็คอัพ::l::Restore from backup"),"../root.upgrade_restore/index.php","","ITDLP.GIF");
?>
		</TD>
	<TD bgcolor=white width=50%><?php  
	local_smallmenu(getlang("ระบบแนะนำข้อมูลการใช้::l::Intro to system"),"../root.libmann/index.php");
	local_smallmenu(getlang("ข้อความหน้าที่ของเจ้าหน้าที่::l::Library Module Text"),"../root.text_librarianmodule/index.php");
	local_smallmenu(getlang("ข้อความกฏการยืมระหว่างห้องสมุด::l::Library Campus Module Text"),"../root.text_libsitemodule/index.php");
	local_smallmenu(getlang("ข้อความกฏการแก้ไข Bib ระหว่างห้องสมุด::l::Library Campus Bib permission Text"),"../root.text_libsitebibmodule/index.php");
	local_smallmenu(getlang("ข้อความค่าตัวแปรของห้องสมุด::l::Library Variables Text"),"../root.text_libsitevar/index.php");
	//local_smallmenu(getlang("ข้อความสถานะของไอเทม::l::Item Status Text"),"../root.text_midstatus/index.php");
	local_smallmenu(getlang("เมนูของบรรณารักษ์::l::Librarian's menu"),"../root.librarymenu/index.php");
	?><BR></TD></TR>
	
<TR bgcolor=#800000>
	<TD  align=center><B style="color: white"><?php  echo getlang("ตัวช่วยระบบ Cache::l::Cache System tools"); ?></B></TD>
	<TD  align=center><B style="color: white"><?php  echo getlang("ตัวช่วยปรับแต่งระบบ::l::System customize tools"); ?></B></TD>
</TR>
<TR valign=top>
		<TD bgcolor=white width=50%>
<?php 
	local_smallmenu("Cache Browser","../root.cachebrowser/");
	local_smallmenu("Session Browser","../root.sessionbrowser/");
	local_smallmenu("Enter module Logs","../root.entermodule/");
?>
		</TD>
	<TD bgcolor=white width=50%><?php  
	local_smallmenu(getlang("คีย์รายการใหม่แบบง่าย::l::Easy Key new"),"../root.easyadd_map/index.php");
	?><BR></TD></TR>

</TABLE>
</span>




<BR><TABLE width=650 align=center>
<TR>
	<TD><?php  echo getlang("<B>หมายเหตุ</B> โปรแกรม ULibM สนับสนุนการทำงานทั้งภาษาไทยและภาษาอังกฤษ โดยในส่วนการตั้งค่า จะมีฟิลด์จำนวนมาก (แต่ไม่ใช่ทุกฟิลด์) ที่สามารถกำหนดตัวเลือกให้ใช้ได้ทั้งสองภาษา ดังตัวอย่าง ::l::<B>Note</B> ULibM support bi-language system (Thai-English). In Administrator System administrator can set many fields in database to work with bi-language system as an example"); ?> <BR><BR><B>ภาษาไทย::l::English</B><BR><BR><?php 
	echo getlang("ใช้สัญลักษณ์ ::l::Use symbol "); ?> <B>::l:: </B><?php  echo getlang("แยกระหว่างทั้งสองภาษา::l::to seperate between 2 language"); ?> (<?php  echo getlang("colon-colon-L ตัวพิมพ์เล็ก-colon-colon::l::colon-colon-L in lower case-colon-colon"); ?>)<BR>
	<?php  echo getlang("โดยหากไม่ต้องการระบุทั้งสองภาษา หรือ มีการระบุแค่ภาษาเดียว ก็ไม่ต้องอาศัยสัญลักษณ์ดังกล่าว ระบบจะแสดงค่าที่ป้อนออกมาให้ทันที::l::If, need to use only 1 language, just type in what you want without language seperator. system will show your text immediately."); ?>
	<BR><BR></TD>
</TR>
</TABLE><BR>


<?php 


///////////////////////////////////////////////////
//fmod check at footer
$local_modchk_help= Array();
function local_modchk($wh,$cate="") {
	global $setmodchkuname;
	if ($setmodchkuname=="") {
		$setmodchkuname="apache:apache";
	}
	global $local_modchk_help;
	global $dcrs;
   @mkdir($wh, 0755, true );
	$b=@chmod($wh,0755);
	if (!$b) {
		echo "<B>".getlang("มีปัญหาเกี่ยวกับการเปลี่ยนโหมดโฟลเดอร์::l::Folder mode problem")."</B> [$cate] [$wh]<BR>";
		$tmpd=trim($wh,'.');
		$tmpd=trim($tmpd,'/');
		$tmpd=$dcrs.$tmpd;
		$local_modchk_help[].="chown $setmodchkuname '$tmpd' -R;";
		$local_modchk_help[].="chmod 755 '$tmpd' -R;";
		//$local_modchk_help[].="chgrp apache '$tmpd' -R;";
	}
/*
	$x=fso_listfile($wh);
	foreach ($x as $i) {
		$b=@chmod($wh.$i,0755);
		if (!$b) {
			echo "<B>".getlang("มีปัญหาเกี่ยวกับการเปลี่ยนโหมดไฟล์::l::File mode problem")."</B> [$cate] [$wh]<BR>";
			$tmp=rtrim($wh,'.');
			$tmp=rtrim($tmp,'/');
			$tmp=$dcrs.$tmp;
			$local_modchk_help[].="chown apache:apache '$tmp' -R;";
			$local_modchk_help[].="chmod 755 '$tmp' -R;";
			//$local_modchk_help[].="chgrp apache '$tmp' -R;";
//			$local_modchk_help[].="chmod 755 '$tmp';";
		}
	}*/
}

?>
<BR>
<BR>
<BLOCKQUOTE><CENTER><?php 

local_modchk("../acqxls/import/",getlang("Acquisition's File"));
local_modchk("../oai/tmp/",getlang("OAI server resumption cache"));
local_modchk("../robots.txt",getlang("Robots.txt"));
local_modchk("../sitemap.xml",getlang("Sitemap.xml"));
local_modchk("../acqxls/upload/upload/",getlang("Acquisition's File (User Upload)"));
local_modchk("../_logs/",getlang("ล็อกไฟล์::l::Log file storage"));
local_modchk("../_addons/0moduleupdate/_tmp/",getlang("Addons: Module update"));
local_modchk("../_addons/0ulibupdate/_tmp/",getlang("ULibM update by section"));
local_modchk("../_addons/0ulibupdate/_download/",getlang("ULibM update by section/Download ready"));
local_modchk("../_addons/_tmp/",getlang("Addons: Module update temp. file"));
local_modchk("../_cache/",getlang("Cache โฟลเดอร์::l::Cache Folder"));
local_modchk("../_tmp/logo/",getlang("อัพโหลดไฟล์โลโก้::l::Upload Logo"));
local_modchk("../_tmp/paper/",getlang("อัพโหลดไฟล์หัว-ท้ายกระดาษ::l::Upload page header and footer"));
local_modchk("../_tmp/cards/",getlang("อัพโหลดไฟล์ภาพบัตรสมาชิก::l::Upload member card template"));
local_modchk("../_output/",getlang("โฟลเดอร์หลักการส่งออกข้อมูล::l::Main Export Place"));
local_modchk("../_input/",getlang("โฟลเดอร์หลักการนำเข้าข้อมูล::l::Main Import Place"));
local_modchk("../_input/import/",getlang("โฟลเดอร์การนำเข้าข้อมูลสมาชิก::l::Main member import place"));
local_modchk("../_input/xpbc/",getlang("โฟลเดอร์การนำเข้าบาร์โค้ดสำหรับพิมพ์::l::Upload barcode data file (xpbc)"));
local_modchk("../pic/",getlang("โฟลเดอร์ภาพสมาชิก::l::Member photo folder"));
local_modchk("../webboard/_files/",getlang("ที่เก็บไฟล์เว็บบอร์ด::l::Webboard's files place"));
local_modchk("../_fulltext/",getlang("ที่เก็บฟูลเท็กซ์::l::Fulltext's files place"));
local_modchk("../web/_files/",getlang("ที่เก็บไฟล์หน้าเว็บ::l::Webpage's files place"));
local_modchk("../_tmp/rqroomfile/",getlang("เก็บภาพประกอบรายการจองห้อง::l::Reserve room's files place"));
local_modchk("../_tmp/headbar/",getlang("โลโก้ส่วนหัว::l::Head bar Image"));
local_modchk("../_tmp/rsstmp/",getlang("RSS- tmp file"));
local_modchk("../_tmp/rqroomfile_tp/",getlang("เก็บภาพประกอบแผนผังห้องของการจองห้อง::l::Reserve room's plan files place"));
local_modchk("../_session/",getlang("Session file holder"));
local_modchk("../lostandfound/attatch/",getlang("Lost and found images"));
local_modchk("../answerpoint/attatch/",getlang("Answerpoint images"));
local_modchk("../_globalupload/",getlang("GlobalUpload's files place"));
local_modchk("../library.member/ulibcamcap/file/",getlang("ULIB Camera capture's tempolary files place"));
local_modchk("../library.member/ulibcamcap-newmem/file/",getlang("ULIB Camera capture's tempolary files place"));
local_modchk("../_tmp/fft_upload/",getlang("ULIB Global upload folder"));
local_modchk("../_tmp/createwebbanner/",getlang("Create Web Banner"));
local_modchk("../css/",getlang("ULIB Global CSS folder"));
local_modchk("../_sip/",getlang("SIP operating directory"));
local_modchk("../_svpush/",getlang("ULIBM - svpush"));
local_modchk("../library.dbfulltext/ulibcamcap/file/",getlang("Materials cover by camera"));
local_modchk("../_tmp/graphtemp/",getlang("Graph tempolary storage"));
local_modchk("../_tmp/libsound/",getlang("Library's sound storage"));
local_modchk("../_tmp/memcard_img/",getlang("Member card image"));
local_modchk("../_tmp/_tempqrcode/",getlang("QR code storage"));
local_modchk("../_tmp/_pdftemp/",getlang("PDF temp. storage"));
local_modchk("../_tmp/_bctemp/",getlang("Barcode temp. storage"));
local_modchk("../_tmp/printtemplate_img/",getlang("Print Template files"));
local_modchk("../_input/tmpcountuse/",getlang("Countuse import files"));
local_modchk("../_globalupload_multiple/",getlang("Global Multiple Upload"));
//local_modchk("../test/",getlang("Global Multiple Upload"));

local_modchk("../library.indexphotonews/file/",getlang("ที่เก็บไฟล์ของภาพข่าวหน้าหลัก::l::Index photo news's files"));
?></CENTER></BLOCKQUOTE><?php 
//printr($local_modchk_help);
if (count($local_modchk_help)!=0) {
	$local_modchk_help=array_unique($local_modchk_help);
	$local_modchk_help=join($local_modchk_help,"<BR>");
	?>
	<script type="text/javascript">
	<!--
		function modchkfunc() {
			tmp=prompt("Enter Different Username and group","apache:apache");
			//alert(tmp);
			if (tmp!=null) {
				self.location="<?php  echo $PHP_SELF;?>?setmodchkuname="+escape(tmp);
			}
		}
	//-->
	</script>
	<TABLE class=table_border width=700 align=center>
	<TR>
		<TD class=table_head><?php  echo getlang("หากคุณเป็นผู้ดูแลระบบเซิร์ฟเวอร์บนระบบปฏิบัติการ Linux::l::If you are server administrator (Linux) ");?></TD>
	</TR>
	<TR>
		<TD class=table_td><?php  echo $local_modchk_help;?></TD>
	</TR>
	</TABLE><HR>
	<CENTER>* <?php  
		echo getlang("apache คือชื่อ user และ group ของ httpd service ในระบบปฏิบัติการ *nix <BR><a href=\"javascript:void(null);\" onclick=\"modchkfunc();\">หากมีการกำหนดเป็นอย่างอื่น</a> กรุณาเปลี่ยนตามที่เซิร์ฟเวอร์กำหนด::l::apache is a user and group name of httpd service on *nix OS.<BR> <a  href=\"javascript:void(null);\" onclick=\"modchkfunc();\">If name and group is difference</a> please change as server specified.");
		echo "<BR></CENTER><HR>";
}

	?><TABLE  width=500 align=center cellpadding="0" cellspacing=0>

	<TR>
		<TD align=center>Server time : <?php  echo ymd_datestr(time());?></TD>
	</TR>
	</TABLE>
	<BR>
<TABLE  width="<?php  echo $_TBWIDTH?>" border=0 cellpadding=0 cellspacing=0 align=center>
<TR>
	<TD align=right><FORM METHOD=POST ACTION="mainadmin.php#rootallowlibrarianlogin">
<TABLE width=550 class=table_border>
	<TR>
	<TD class="table_head smaller"><?php  echo getlang("อนุญาตเจ้าหน้าที่ห้องสมุดล็อกอิน::l::Allow Librarian login?");?><A name="rootallowlibrarianlogin"></A></TD>
	<TD class=table_td>
<?php 
//printr($_POST);
$ise=barcodeval_get("rootallowlibrarianlogin");?>
	<label style="color:darkgreen" class=smaller2><INPUT TYPE="radio" NAME="rootallowlibrarianlogin" value="yes"
	<?php  if ($ise=="yes") { echo " checked ";}	?>
	><?php  echo getlang("อนุญาต::l::Allow");?></label>
	<label style="color:dardred"  class=smaller2><INPUT TYPE="radio" NAME="rootallowlibrarianlogin" value="no" 	
	<?php  if ($ise=="no") { echo " checked ";}	?>
><?php  echo getlang("ไม่อนุญาต::l::Disallowed");?></label>
	
	</TD>
	<TD class=table_td> <INPUT TYPE="submit" value=" Save " class=a_btn style="color:red"></TD>
</TR>

</TABLE></FORM></TD>
</TR>
</TABLE><?php 
foot();
?>