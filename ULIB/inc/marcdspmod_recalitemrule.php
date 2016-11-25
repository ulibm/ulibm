<?php // พ
function marcdspmod_recalitemrule($main) {
	global $dcrs;
	$data=tmq("select * from marcdspmod_itemrule where pid='$main' ",false);
	$dataa=tfa($data);
	$dataa=unserialize($dataa[val]);
	//printr($dataa);
	extract($dataa,EXTR_OVERWRITE);

	include($dcrs."library.marcdspmod/sub_itemrule.inc.sqllimit.php");
	include($dcrs."library.marcdspmod/sub_itemrule.inc.sqllimit_save.php");
}
?>