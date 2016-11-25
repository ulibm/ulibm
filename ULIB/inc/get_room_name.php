<?php  
function get_room_name($pl,$spliter=',') {
global $_ROOMWORD;
	$s=tmq("select * from room where id='$pl' ");
	$r=tmq_fetch_array($s);
	if (trim("$r[name]")=="") {
		return "<I><small>".getlang("ไม่พบ".getlang($_ROOMWORD)."::l::".getlang($_ROOMWORD)." not found")." $pl</small></I>";
	}
	$libs=tmq("select * from room_cate where 1 ");
	if (tmq_num_rows($libs)>1 ) {
		$libs=tmq("select * from room_cate where code='$r[pid]' ",false);
		if (tnr($libs)==0) {
   		$libs=tmq("select * from room_cate where code='default' ");
		}
		$libs=tmq_fetch_array($libs);
		return "".getlang($libs[name])." $spliter".getlang($r[name]);
	} else {
		return "".getlang($r[name])."";
	}
}
?>