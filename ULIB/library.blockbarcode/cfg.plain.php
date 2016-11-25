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
	barcodeval_set("BARCODE-blockbc-plain-isshownum",addslashes($isshownum));
	barcodeval_set("BARCODE-blockbc-plain-bcline",addslashes($bcline));
	barcodeval_set("BARCODE-blockbc-plain-addtext",addslashes($addtext));
	barcodeval_set("BARCODE-blockbc-plain-bclinesize",addslashes($bclinesize));
	barcodeval_set("BARCODE-blockbc-plain-addtextsize",addslashes($addtextsize));
}
$tbmn="width= 780  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="<?php  echo $PHPSELF;?>"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงหมายเลขหรือไม่::l::Show Number"); ?></TD>
<TD><?php 
form_quickedit("isshownum",barcodeval_get("BARCODE-blockbc-plain-isshownum"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความในบรรทัดหมายเลขบาร์โค้ด::l::Barcode number line"); ?></TD>
<TD><?php 
form_quickedit("bcline",barcodeval_get("BARCODE-blockbc-plain-bcline"),"text"); 
?> size  <input type="number" name="bclinesize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-plain-bclinesize")); ?>">
<BR>[bc] = barcode</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติม::l::Add text"); ?></TD>
<TD><?php 
form_quickedit("addtext",barcodeval_get("BARCODE-blockbc-plain-addtext"),"text"); 
?>  size  <input type="number" name="addtextsize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-plain-addtextsize")); ?>"></TD>
</TR>

<TR bgcolor=ffffff>
<TD align=center colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
</TR>

</FORM>
</TABLE>
<?php 
$bcgenmode="plain";
include("cfg._getexamples.php");
?>