<?php // พ
function barcodeval_set($wh,$ct) {
	tmq("delete from barcode_val where classid='$wh' ");
	tmq("insert into barcode_val set
	classid='$wh',
	val='$ct'
	");
	tmq("delete from barcode_valmem where classid='$wh' ");
	if (strlen($ct)<255) {
		tmq("insert into barcode_valmem set
		classid='$wh',
		val='$ct'
		");
	}
}
?>