<?php 
function get_libsite_name($wh) {
$s=tmq("select * from library_site where code='$wh' ");
$r=tmq_fetch_array($s);
if (trim("$r[name]")=="") {
	return "<I><small>".getlang("ไม่พบชื่อห้องสมุด::l::Library not found")." $wh</small></I>";
}
return getlang($r[name]);
}

?>