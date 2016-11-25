<?php  
 include("./inc/config.inc.php");
 html_start();
 loginchk_lib();
 if ($libsiteid=="") {
	die("no libsiteid passed");
}
 if ($jsid=="") {
	die("no jsid passed");
}
//printr($_GET);
if ($picked!="") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.tmpmappospicker=top.getobj('<?php echo $jsid?>');
		top.tmpmappospicker.value="<?php echo trim($picked,'?');?>";
		top.removegb();
	//-->
	</SCRIPT><?php  
	die;
}
if (!file_exists($dcrs."_tmp/_floorplan_$libsiteid.jpg")) {
	html_dialog("",getlang("แผนที่สำหรับ ".get_libsite_name($libsiteid)." ยังไม่ถูกอัพโหลด::l::Map for ".get_libsite_name($libsiteid)." not uploaded"));
	die;
}
 ?><CENTER><A HREF="_mappospicker.php?libsiteid=<?php echo $libsiteid;?>&jsid=<?php echo $jsid;?>&picked="><IMG SRC="<?php echo $dcrURL?>_tmp/_floorplan_<?php echo $libsiteid;?>.jpg?<?php echo randid();?>" border=1 ismap></A></CENTER>