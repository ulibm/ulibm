<?php // พ
function localseterror($txt) {
	global $useradminid;
	tmq("delete from cir_error  where lib='$useradminid' ");
	tmq("insert into cir_error  set lib='$useradminid' ,dt='".time()."' , msg='$txt' ");
}
?>