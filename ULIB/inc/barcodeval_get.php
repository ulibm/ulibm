<?php // พ
function barcodeval_get($wh) {
	$s=tmq("select * from barcode_valmem where classid='$wh' ",false);
	if (tnr($s)==1) {
		$s=tmq_fetch_array($s); //printr($s);
		return stripslashes($s["val"]);
	} else {
		$s=tmq("select * from barcode_val where classid='$wh' ");
		$s=tmq_fetch_array($s);
		tmq("delete from barcode_valmem where classid='$wh' ");
		$s[val]=addslashes($s["val"]);
		if (strlen($s["val"])<255) {
			tmq("insert into barcode_valmem set
			classid='$wh',
			val='$s[val]'
			");
		}
		return stripslashes($s[val]);
	}
}
?>