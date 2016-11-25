<?php 
	; 
		
        include ("../inc/config.inc.php");
loginchk_lib();
 if (!library_gotpermission("bitem_countuse_manage")) { die("no permission") ; }
	tmq("delete from countuse_name where countuse='$qnid' ");
	tmq("insert into   countuse_name set countuse='$qnid' ,shelf='$shelf',name='$name',lib='$useradminid' ");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("<?php  echo getlang("เปลี่ยนชื่อเรียบร้อย::l::Rename success.")?>");
	top.location.reload();
	//-->
	</SCRIPT><?php 
?>