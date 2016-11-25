<?php include("../inc/config.inc.php");
include("func.php");
		include("html.start.php");

$html_start_title=marc_gettitle($ID);

//head();
$_TBWIDTH="100%";
$sql = "select * from media where ID='$ID' ";
$result = tmq($sql);
$Num = tmq_num_rows($result);
if($Num == 0) {
	echo"<font s>ไม่สามารถหาวัสดุสารสนเทศ ID นี้ได้  ($ID)</font>";
	exit;
} else {
	res_brief_dsp($ID);
     	
		$module=get_itemmodule($ID);
		if ($module=="item") {
			html_displayitem($ID,$item);
		} elseif ($module=="serial") {
			html_displayserial($ID,$item,$serialmode);
		} else {
			echo "ผิดพลาด ไม่สามารถหาโมดูลสำหรับ $module";
		}


}
		include("html.end.php");

?>