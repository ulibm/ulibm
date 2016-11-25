<?php 
function get_library_name($wh,$mustexist=false) {
   global $dcrURL;
  $s=tmq("select * from library where UserAdminID='$wh' ");
  $r=tmq_fetch_array($s);
  if (trim("$r[UserAdminName]")=="") {
	  if ($mustexist==true) {
			html_dialog("Security alert","User not exists [$wh]");
			echo "<center><a href='$dcrURL"."library/logout.php'>Logout</a>";
			die;
	  }
  	return "<I><small>".getlang("ไม่พบชื่อเจ้าหน้าที่ห้องสมุด::l::Librarian not found")." $wh</small></I>";
  }
  return getlang($r[UserAdminName]);
}

?>