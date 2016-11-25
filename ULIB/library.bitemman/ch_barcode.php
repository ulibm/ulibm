<?php 
	include ("../inc/config.inc.php");
	loginchk_lib();

$s=tmq("select * from media_mid where ismarked='YES' ");
$str="";
while ($r=tmq_fetch_array($s)) {
	$str.=$newline.$r[bcode];
}
	barcodeval_set("$bcid",$str);
$tmp=barcodeval_get("$bcid");
barcodeval_set("$bcid",$tmp);
tmq("delete from barcode_valmem;");
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
if ( confirm("<?php  echo getlang("การดำเนินการเรียบร้อย สามารถดูผลการเพิ่มได้ที่ ระบบบาร์โค้ด คุณต้องการไปที่ระบบบาร์โค้ดเลยหรือไม่?::l::Operation success, result of this action can view in Barcode module, do you want to go now?"); ?> ")) {
	self.location="../library.barcode/bc.php";
} else {
	self.location="media_type.php";
}
//-->
</SCRIPT>