<?php 
function get_itemplace_name($pl,$spliter=',') {
	$s=tmq("select * from media_place where code='$pl' ");
	$r=tmq_fetch_array($s);
	if (trim("$r[name]")=="") {
		return "<I><small>".getlang("ไม่พบชื่อสถานที่::l::Shelves not found")." $pl</small></I>";
	}
	$libs=tmq("select * from library_site where 1 ");
	if (tmq_num_rows($libs)>1 ) {
		$libs=tmq("select * from library_site where code='$r[main]' ");
		$libs=tmq_fetch_array($libs);
		return "<nobr>".getlang($libs[name])."</nobr> $spliter".getlang($r[name]);
	} else {
		return "<nobr>".getlang($r[name])."</nobr>";
	}

}
?>