<?php  //พ
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
	barcodeval_set("BARCODE-blockbc-calln-isshowyear",addslashes($isshowyear));
	barcodeval_set("BARCODE-blockbc-calln-groupchar",addslashes($groupchar));
	barcodeval_set("BARCODE-blockbc-calln-isshowbc",addslashes($isshowbc));
	barcodeval_set("BARCODE-blockbc-calln-isshowtitle",addslashes($isshowtitle));
	barcodeval_set("BARCODE-blockbc-calln-isshowtitlesize",addslashes($isshowtitlesize));
	barcodeval_set("BARCODE-blockbc-calln-addtext",addslashes($addtext));
	barcodeval_set("BARCODE-blockbc-calln-addtextsize",addslashes($addtextsize));
	barcodeval_set("BARCODE-blockbc-calln-addtext1",addslashes($addtext1));
	barcodeval_set("BARCODE-blockbc-calln-addtext1size",addslashes($addtext1size));
	barcodeval_set("BARCODE-blockbc-calln-callntag",addslashes($callntag));
	barcodeval_set("BARCODE-blockbc-calln-callntagsize",addslashes($callntagsize));
	barcodeval_set("BARCODE-blockbc-calln-callnformat",addslashes($callnformat));
}
$tbmn="width= 780  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="<?php  echo $PHPSELF;?>"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงเลขปีหรือไม่::l::Show Year"); ?></TD>
<TD><?php 
form_quickedit("isshowyear",barcodeval_get("BARCODE-blockbc-calln-isshowyear"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงเลขบาร์โค้ดหรือไม่::l::Show Barcode"); ?></TD>
<TD><?php 
form_quickedit("isshowbc",barcodeval_get("BARCODE-blockbc-calln-isshowbc"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงชื่อเรื่องหรือไม่::l::Show Title"); ?></TD>
<TD><?php 
form_quickedit("isshowtitle",barcodeval_get("BARCODE-blockbc-calln-isshowtitle"),"yesno"); 
?> 
 size  <input type="number" name="isshowtitlesize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-calln-isshowtitlesize")); ?>">
</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("จับกลุ่มตัวอักษรกลุ่มแรกแยกจากตัวเลข::l::Grouping first characters from digits"); ?></TD>
<TD><?php 
form_quickedit("groupchar",barcodeval_get("BARCODE-blockbc-calln-groupchar"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติมก่อนชื่อเรื่อง::l::Add text before title"); ?></TD>
<TD><?php 
form_quickedit("addtext1",barcodeval_get("BARCODE-blockbc-calln-addtext1"),"text"); 
?>
 size  <input type="number" name="addtext1size" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-calln-addtext1size")); ?>">
<BR>[bc] = barcode [bib] = Bib.ID</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติม::l::Add text"); ?></TD>
<TD><?php 
form_quickedit("addtext",barcodeval_get("BARCODE-blockbc-calln-addtext"),"text"); 
?>
 size  <input type="number" name="addtextsize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-calln-addtextsize")); ?>">
<BR>[bc] = barcode [bib] = Bib.ID</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แท็กที่เก็บเลขเรียก::l::Tag for Call Number"); ?></TD>
<TD><?php 
form_quickedit("callntag",barcodeval_get("BARCODE-blockbc-calln-callntag"),"list:auto,tag050,tag060,tag082,tag090,tag098,tag099"); 
?>
 size  <input type="number" name="callntagsize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-calln-callntagsize")); ?>">
</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("รูปแบบเลขเรียก::l::Call Number format"); ?></TD>
<TD><?php 
form_quickedit("callnformat",barcodeval_get("BARCODE-blockbc-calln-callnformat"),"list:DC,LC,1_line"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD align=center colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
</TR>
</FORM>
</TABLE>
<?php 
$bcgenmode="calln";
include("cfg._getexamples.php");
?>