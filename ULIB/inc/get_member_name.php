<?php  
function get_member_name($wh,$addhtml="") {
	global $_memid;
	if ($addhtml=="") {
		$addhtml=" class=smaller ";
	}
	global $dcrURL;
	$s=tmq("select * from member where UserAdminID='$wh' ",false);
	if (tmq_num_rows($s)==0) {
		$s=tmq("Select * From ulib_clientlogins Where loginid='".substr($wh,4)."' and loginid<>'' ",false);
		if (tnr($s)!=0) {
   		$r=tmq_fetch_array($s);
   		$r[UserAdminName]=$r[name] ."(UUG)";
		} else {
	    	$s=tmq("select * from member_bin where UserAdminID='$wh' ",false);
         if (loginchk_lib('check')==true && tnr($s)!=0) {
      		return "<a href='$dcrURL/library.member/detail.php?id=$wh' target=_blank $addhtml style='font-size: inherit;font-weight: inherit; color: #909090'><I><small>".getlang("ไม่พบชื่อสมาชิก::l::member not found")." $wh [*]</small></I></a>";
         } else {
      		return "<I><small>".getlang("ไม่พบชื่อสมาชิก::l::member not found")." $wh</small></I>";
   		}
		}
	} else {
		$r=tmq_fetch_array($s);
	}
	if (trim("$r[UserAdminName]")=="") {
		return "<I><small>".getlang("ไม่พบชื่อสมาชิก::l::member not found")." $wh</small></I>";
	}
	if (loginchk_lib('check')==true) {
	   $namepref="";
	   if ($r[statusactive]!="normal") {
	     $namepref="<font style='font-size:inherit; color:darkred;'>!</font>";
	   }
		return "<A HREF='$dcrURL/library.member/detail.php?id=$wh' target=_blank $addhtml style='font-size: inherit;font-weight: inherit;'>".$r[UserAdminName].$namepref."</A>";
	} elseif ($_memid!="") {
		return "<A HREF='$dcrURL/member/viewmember.php?id=$wh' target=_blank $addhtml style='font-size: inherit;font-weight: inherit;'>".$r[UserAdminName]."</A>";
	} else {
		return "<A HREF='$dcrURL/member/viewmember.php?id=$wh' target=_blank $addhtml style='font-size: inherit;font-weight: inherit;'>".$r[UserAdminName]."</A>";
	}
}

?>