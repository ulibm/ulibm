<?php // พ
function library_gotpermission($code,$chkfor="") {
	//echo "library_gotpermission($code,$chkfor) ";
	global $useradminid;
	if ($chkfor=="") {
		$chkfor=$useradminid;
	}
	//echo "select * from library_permission where lib='$chkfor' and code='$code'  ";
	if ($code=="avaipermission") {
	  return true;
	}
	$tmp=tmq("select * from library where UserAdminID='$chkfor' and lower(isallowall)='yes' ",false);	
	if (tmq_num_rows($tmp)==1 && trim($chkfor)!="") {
		//echo "pass allowall";
		return true;
	}
	$tmp=tmq("select * from library where UserAdminID='$chkfor' ",false);	
	$tmpr=tfa($tmp);
	if (trim($tmpr[permtp])!="") {
   	$tmp=tmq("select * from library_permission_template where lib='$tmpr[permtp]' and code='$code'  ",false);	
   	if (tmq_num_rows($tmp)==0) {
   		return false;
   	} else {
   		return true;
   	}
	}
	$tmp=tmq("select * from library_permission where lib='$chkfor' and code='$code'  ");	
	if (tmq_num_rows($tmp)==0) {
		return false;
	} else {
		return true;
	}
}
?>