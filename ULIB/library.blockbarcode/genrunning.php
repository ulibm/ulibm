<?php 
;
include("../inc/config.inc.php");
html_start();

include("_REQPERM.php");
loginchk_lib("check");
if ($save=='yes') {
	/*
	$dr="$dcrs/_tmp/";
	if (strlen($_FILES['head']['tmp_name'])!=0) { 
	   copy($_FILES['head']['tmp_name'], "$dr" . "_paper_head.jpg"); 
	} 
	*/
	$length=floor($length);
	if ($length==0) {
	  html_dialog("",getlang("กรุณาระบุความยาวของบาร์โค้ด::l::Please specific barcode length"));
	  ?><CENTER><a href="<?php echo $PHP_SELF;?>">Back</a></CENTER><?php
	  die;
	} 
	$addprefix=strtoupper($addprefix);
	barcodeval_set("BARCODE-blockbc-genrunning-start",addslashes($start));
	barcodeval_set("BARCODE-blockbc-genrunning-end",addslashes($end));
	barcodeval_set("BARCODE-blockbc-genrunning-length",addslashes($length));
	barcodeval_set("BARCODE-blockbc-genrunning-isreplace",addslashes($isreplace));
	barcodeval_set("BARCODE-blockbc-genrunning-addprefix",addslashes($addprefix));
	
	$s="";
	for ($i=$start;$i<=$end;$i++) {
		$tmp="$addprefix".str_fixw($i,$length);
		$s.="
$tmp";
	}
	$s=trim($s);
	if ($isreplace=="yes") {
		
	} else {
		$s=barcodeval_get("BARCODE-blockbc-allbc")."
".$s;
	}
	barcodeval_set("BARCODE-blockbc-allbc",$s);
	$s=barcodeval_get("BARCODE-blockbc-allbc");
	barcodeval_set("BARCODE-blockbc-allbc",$s);

	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location.reload();
	//-->
	</SCRIPT><?php 
}
$tbmn="width= 780  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="<?php  echo $PHPSELF;?>"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("เริ่มจากหมายเลข::l::Start from"); ?></TD>
<TD><?php 
form_quickedit("start",barcodeval_get("BARCODE-blockbc-genrunning-start"),"number"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ถึงหมายเลข::l::to number"); ?></TD>
<TD><?php 
form_quickedit("end",barcodeval_get("BARCODE-blockbc-genrunning-end"),"number"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ความยาวของบาร์โค้ด::l::Barcode Length"); ?></TD>
<TD><?php 
form_quickedit("length",barcodeval_get("BARCODE-blockbc-genrunning-length"),"number"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("เพิ่มตัวอักษรนำหน้าบาร์โค้ด::l::Add Prefix"); ?></TD>
<TD><?php 
form_quickedit("addprefix",strtoupper(barcodeval_get("BARCODE-blockbc-genrunning-addprefix")),"text"); 
?></TD>
</TR><TR bgcolor=ffffff>
<TD><?php  echo getlang("แทนที่บาร์โค้ดในรายการหรือไม่::l::Replace barcodes in the box"); ?></TD>
<TD><?php 
form_quickedit("isreplace",barcodeval_get("BARCODE-blockbc-genrunning-isreplace"),"yesno"); 
?><BR><?php  echo getlang("หากไม่แทนที่ จะนำไปต่อท้าย::l::If not, will append generated barcode to the list"); ?></TD>
</TR>
<TR bgcolor=ffffff>
<TD align=center colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
</TR>

</FORM>
</TABLE>