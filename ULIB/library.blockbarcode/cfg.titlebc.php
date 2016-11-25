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
	barcodeval_set("BARCODE-blockbc-titlebc-titlesize",addslashes($titlesize));
	barcodeval_set("BARCODE-blockbc-titlebc-callnsize",addslashes($callnsize));

	barcodeval_set("BARCODE-blockbc-titlebc-isshowinum",addslashes($isshowinum));
	barcodeval_set("BARCODE-blockbc-titlebc-bcline",addslashes($bcline));
	barcodeval_set("BARCODE-blockbc-titlebc-bclinesize",addslashes($bclinesize));
	barcodeval_set("BARCODE-blockbc-titlebc-isshownum",addslashes($isshownum));
	barcodeval_set("BARCODE-blockbc-titlebc-addtextsize",addslashes($addtextsize));
	barcodeval_set("BARCODE-blockbc-titlebc-addtext",addslashes($addtext));
}
$tbmn="width= 780  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="<?php  echo $PHPSELF;?>"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>
<TR bgcolor=ffffff> 
<TD><?php  echo getlang("ขนาดอักษรชื่อเรื่อง::l::Title font size"); ?></TD>
<TD>  <input type="number" name="titlesize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-titlebc-titlesize")); ?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ขนาดอักษรเลขเรียก::l::Callnumber font size"); ?></TD>
<TD>   <input type="number" name="callnsize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-titlebc-callnsize")); ?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงหมายเลขหรือไม่::l::Show Number"); ?></TD>
<TD><?php 
form_quickedit("isshownum",barcodeval_get("BARCODE-blockbc-titlebc-isshownum"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความในบรรทัดหมายเลขบาร์โค้ด::l::Barcode number line"); ?></TD>
<TD><?php 
form_quickedit("bcline",barcodeval_get("BARCODE-blockbc-titlebc-bcline"),"text"); 
?>
 size  <input type="number" name="bclinesize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-titlebc-bclinesize")); ?>">
<BR>[bc] = barcode [bib] = Bib.ID</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงเลขฉบับที่หรือไม่::l::Show Copy Number"); ?></TD>
<TD><?php 
form_quickedit("isshowinum",barcodeval_get("BARCODE-blockbc-titlebc-isshowinum"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติม::l::Add text"); ?></TD>
<TD><?php 
form_quickedit("addtext",barcodeval_get("BARCODE-blockbc-titlebc-addtext"),"text"); 
?>
 size  <input type="number" name="addtextsize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-titlebc-addtextsize")); ?>">
</TD>
</TR>

<TR bgcolor=ffffff>
<TD align=center colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
</TR>

</FORM>
</TABLE>
<?php 
$bcgenmode="titlebc";
include("cfg._getexamples.php");
?>