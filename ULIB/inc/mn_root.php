<?php 
function mn_root($_REQPERM="") {
	global $loginadmin;
	global $dcr;
	global $dcrURL;
	global $PHP_SELF;
	global $_TBWIDTH;
	if ($_REQPERM=="") {
		die("<B>mn_root()</B> error: require \$_REQPERM;");
	}
	$_REQPERMDB[dbmorph]=getlang("DB Morph");
	$_REQPERMDB[filebrowser]=getlang("File Browser");
	$_REQPERMDB[logentermodule]=getlang("Log Enter module");
	$_REQPERMDB[libmann]=getlang("ระบบแนะนำข้อมูลการใช้::l::Intro to system");
	$_REQPERMDB[cleardb]=getlang("เคลียร์ (ลบ) ฐานข้อมูล::l::Clear (delete) database");
	$_REQPERMDB[entermodule]=getlang("Enter module Logs");
	$_REQPERMDB[mainadmin]=getlang("หน้าหลักเจ้าหน้าที่::l::Administrator's Main menu");
	$_REQPERMDB[useradmin]=getlang("จัดการรายชื่อเจ้าหน้าที่สูงสุด::l::Administrator's login");
	$_REQPERMDB[userlibrary]=getlang("จัดการรายชื่อเจ้าหน้าที่ห้องสมุด::l::Librarian's login");
	$_REQPERMDB[mediatype]=getlang("ประเภทวัสดุสารสนเทศ::l::Material types");
	$_REQPERMDB[membertype]=getlang("ประเภทสมาชิก::l::Member types");
	$_REQPERMDB[checkoutrule]=getlang("กฏการยืมวัสดุสารสนเทศ::l::Checkout rule");
	$_REQPERMDB[tb_editor]=getlang("ระบบจัดการฐานข้อมูล::l::Table Editor");
	$_REQPERMDB[libsiteman]=getlang("จัดการห้องสมุดสาขาต่าง ๆ::l::Manage library site and campuses");
	$_REQPERMDB[libsite_vars]=getlang("ค่าตัวแปรสำหรับห้องสมุด::l::Library variable");
	$_REQPERMDB[libsiterule]=getlang("กฏการยืมคืนระหว่างห้องสมุด::l::Campus relation rule");
	$_REQPERMDB[itemplace]=getlang("สถานที่เก็บวัสดุสารสนเทศ::l::Shelves and collections");
	$_REQPERMDB[bkedit]=getlang("โครงสร้าง Marc::l::Marc structure");
	$_REQPERMDB[bkeditindex]=getlang("โครงสร้างการ Index::l::Indexing structure");
	$_REQPERMDB[marctemplate]=getlang("จัดการชุดฟอร์มการแก้ไขข้อมูล::l::Manage Marc template");
	$_REQPERMDB[bkdsp]=getlang("การแสดงผลรายการสืบค้น::l::Result displaying");
	$_REQPERMDB[backup]=getlang("สำรองข้อมูล::l::Backup");
	$_REQPERMDB[val]=getlang("ค่าตัวแปรระบบ::l::System variables");
	$_REQPERMDB[yaz_sv]=getlang("รายชื่อเซิร์ฟเวอร์ Z39.50::l::Z39.50 Server list");
	$_REQPERMDB[memberspic]=getlang("ตั้งค่ารูปสมาชิก::l::Member photo setting");
	$_REQPERMDB[listpic]=getlang("ดู/อัพโหลดรูปภาพสมาชิกในระบบโปรแกรม::l::View/Upload member photo");
	$_REQPERMDB[function_req]=getlang("ตรวจสอบความต้องการของระบบ::l::System requirement");
	$_REQPERMDB[importer_mem]=getlang("นำเข้ารายชื่อสมาชิก::l::Import members");
	$_REQPERMDB[logbrowser]=getlang("Log files");
	$_REQPERMDB[index_reindex]=getlang("re-Index ฐานข้อมูลวัสดุสารสนเทศ::l::re-index material database");
	$_REQPERMDB[usoundex_map]=getlang("U-Soundex");
	$_REQPERMDB[ignoreword]=getlang("Stop Words");
	$_REQPERMDB[ignorewordimportid]=getlang("Stop Words ที่นำเข้ามาแล้ว::l::Imported Stop Words");
	$_REQPERMDB[importer_ignoreword]=getlang("ตัวช่วยนำเข้า Stop Words::l::Stop Words Importer");
	$_REQPERMDB[indexword]=getlang("Words");
	$_REQPERMDB[indexwordimportid]=getlang("Words ที่นำเข้าและทำ usounddex::l::Imported Words and usoundex");
	$_REQPERMDB[importer_indexword]=getlang("ตัวช่วยนำเข้า Words::l::Words importer");
	$_REQPERMDB[rootutils]=getlang("ไฟล์เครื่องมืออื่น ๆ::l::Utility file");
	$_REQPERMDB[phpinfo]=getlang("phpinfo()");	
	$_REQPERMDB[shellinfo]=getlang("ข้อมูลเซิร์ฟเวอร์::l::Server Information");		
	$_REQPERMDB[configinfo]=getlang("การตั้งค่าทั่วไปของระบบ::l::Base system configuration");			
	$_REQPERMDB[dbmantain]=getlang("บำรุงรักษาฐานข้อมูล::l::DB miantainience ");	
	$_REQPERMDB[sqlexec]=getlang("SQL Executor");
	$_REQPERMDB[importer_book]=getlang("นำเข้าข้อมูลวัสดุฯ::l::Media Importer");	
	$_REQPERMDB[importer_book]=getlang("นำเข้าข้อมูลวัสดุฯ::l::Media Importer");	
	$_REQPERMDB[importer_bookitem]=getlang("นำเข้าข้อมูลไอเทม(โยงกับวัสดุ)::l::Items Importer (Relate with media)");	
	$_REQPERMDB[importer_book_map]=getlang("ตัวกำหนดการนำเข้าข้อมูลวัสดุฯ::l::Media Importer mapping");	
	$_REQPERMDB[upgrade_table]=getlang("อัพเกรดตาราง::l::Table Upgrade");	
	$_REQPERMDB[upgrade_restore]=getlang("ฟื้นคืนข้อมูลแบ็คอัพ::l::Restore from backup");	
	$_REQPERMDB[text_librarianmodule]=getlang("ข้อความหน้าที่ของเจ้าหน้าที่::l::Library Module Text");	
	$_REQPERMDB[text_libsitemodule]=getlang("ข้อความกฏการยืมระหว่างห้องสมุด::l::Library Campus Module Text");	
	$_REQPERMDB[text_libsitevar]=getlang("ข้อความค่าตัวแปรของห้องสมุด::l::Library Variables Text");	
	$_REQPERMDB[text_midstatus]=getlang("ข้อความสถานะของไอเทม::l::Item Status Text");	
	$_REQPERMDB[subjextract]=getlang("สร้างรายการหัวเรื่อง::l::Create Subject Heading list");	
	$_REQPERMDB[subjextracted]=getlang("รายการหัวเรื่อง::l::Subject Heading list");	
	$_REQPERMDB[subjextractedimportid]=getlang("รายการหัวเรื่องที่ Extract เข้ามาแล้ว::l::Extracted Subject Heading");	
	$_REQPERMDB[collections]=getlang("รายชื่อ Collection::l::Collection list");	
	$_REQPERMDB[librarymenu]=getlang("เมนูของบรรณารักษ์::l::Librarian's menu");
	$_REQPERMDB[easyadd_map]=getlang("คีย์รายการใหม่แบบง่าย::l::Easy Key new");
	$_REQPERMDB[remindersheet]=getlang("กระดาษเตือนความจำ::l::Reminder sheet");
	$_REQPERMDB[activateulib]=getlang("ULIBM - License Information");
	$_REQPERMDB[membercustomfield]=getlang("ฟิลด์เพิ่มเติมข้อมูลสมาชิก::l::Member's custom fields");	
	$_REQPERMDB[cachebrowser]=getlang("Cache Browser");
	$_REQPERMDB[upgrade_tocurrent]=getlang("ปรับ ULIBM เป็นเวอร์ชันล่าสุด::l::ULIBM-Upgrade to current");
	$_REQPERMDB[sessionbrowser]=getlang("Session Browser");
	$_REQPERMDB[libsitebibrule]=getlang("การอนุญาตการแก้ไข Bib ระหว่างห้องสมุด::l::Permission to edit Bib. between site and campus");
	$_REQPERMDB[text_libsitebibmodule]=getlang("ข้อความการอนุญาตการแก้ไข Bib ระหว่างห้องสมุด::l::Permission to edit Bib. between site and campus Text");
	$_REQPERMDB[upgrade_variable]=getlang("อัพเกรด Variable เป็นเวอร์ชันล่าสุด::l::Upgrade Variable");
	
	
	$_REQPERMDB[xxx]=getlang("xxx::l::xxx");
	
		$tmp=$_REQPERMDB[$_REQPERM];
	if ($tmp=="") {
		die("<B>mn_root()</B> error: require \$_REQPERM=$_REQPERM, <B>Not found description;</B>");
	}

	loginchk_root();
?> 
<table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "0" cellpadding = "3" bgcolor="#E2E2E2" 
>
<tr bgcolor = cccccc >
	<td colspan = 2 background="<?php  echo $dcrURL?>neoimg/menufade_1.png"
	style="background-repeat: no-repeat; background-position: top right"
	>
		<b><font face = "MS Sans Serif" size = "5" color = "#660000" class = stupidmenu>&nbsp;&nbsp;<?php  echo getlang("ระบบเจ้าหน้าที่สูงสุด::l::Administrator System"); ?> </font></b>
	</td>
					

                     </td>
                </tr>

                <tr valign=top>
					<td  style="padding-left: 20px; color: #7A7A7A; background-color: white;" class=smaller  align=left  ><?php 
echo getlang("อยู่ในระบบ::l::Working in");
echo " : ";
echo $tmp;
?></td>
<td align="right" bgcolor=white>
<TABLE align=right border = "0" cellspacing = "0" cellpadding =0 >
<TR bgcolor=white>
<?php 
	if ( $PHP_SELF !="/$dcr/root/mainadmin.php"	) {
?>
	<TD><img src='<?php echo $dcrURL?>neoimg/media/roundedge-gray-left.png'></TD>
	<TD background='<?php echo $dcrURL?>neoimg/media/roundedge-gray-right.png' style="background-repeat: no-repeat; background-position: top right; padding-right: 10px;padding-left: 4px;">
<a  href="/<?php echo "$dcr"; ?>/root/mainadmin.php" style="color:white;font-size:14px;font-weight:bold"><?php  echo getlang("เมนูหลัก::l::Menu"); ?></a> 
</TD>
<?php 
}	
?>
	<TD >&nbsp;</TD>
	<TD ><img src='<?php echo $dcrURL?>neoimg/media/roundedge-red-left.png'></TD>
	<TD background='<?php echo $dcrURL?>neoimg/media/roundedge-red-right.png' style="background-repeat: no-repeat; background-position: top right;padding-right: 10px;padding-left: 4px;">
<a  href="/<?php echo "$dcr"; ?>/root/logout.php"  style="color:white;font-size:14px;font-weight:bold;"><?php  echo getlang("ออกจากระบบ::l::Logout"); ?></a>

</TD>
</TR>
</TABLE>

</td>
                </tr>
            </table><?php 
	return $tmp;
}
?>