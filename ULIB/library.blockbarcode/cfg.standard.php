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
	barcodeval_set("BARCODE-blockbc-standard-isshowtitle",addslashes($isshowtitle));
	barcodeval_set("BARCODE-blockbc-standard-isshowtitlesize",addslashes($isshowtitlesize));
	barcodeval_set("BARCODE-blockbc-standard-isshownum",addslashes($isshownum));
	barcodeval_set("BARCODE-blockbc-standard-groupchar",addslashes($groupchar));
	barcodeval_set("BARCODE-blockbc-standard-bcline",addslashes($bcline));
	barcodeval_set("BARCODE-blockbc-standard-bclinesize",addslashes($bclinesize));
	barcodeval_set("BARCODE-blockbc-standard-addtext",addslashes($addtext));
	barcodeval_set("BARCODE-blockbc-standard-addtextsize",addslashes($addtextsize));
	barcodeval_set("BARCODE-blockbc-standard-callntag",addslashes($callntag));
	barcodeval_set("BARCODE-blockbc-standard-callntagsize",addslashes($callntagsize));
	barcodeval_set("BARCODE-blockbc-standard-callnformat",addslashes($callnformat));
	barcodeval_set("BARCODE-blockbc-standard-spinewidth",addslashes($spinewidth));
	barcodeval_set("BARCODE-blockbc-standard-addyear",addslashes($addyear));
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
form_quickedit("isshownum",barcodeval_get("BARCODE-blockbc-standard-isshownum"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความในบรรทัดหมายเลขบาร์โค้ด::l::Barcode number line"); ?></TD>
<TD><?php 
form_quickedit("bcline",barcodeval_get("BARCODE-blockbc-standard-bcline"),"text"); 
?>  size  <input type="number" name="bclinesize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-standard-bclinesize")); ?>">
<BR>[bc] = barcode [bib] = Bib.ID</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("จับกลุ่มตัวอักษรกลุ่มแรกแยกจากตัวเลข::l::Grouping fir characters from digits"); ?></TD>
<TD><?php 
form_quickedit("groupchar",barcodeval_get("BARCODE-blockbc-standard-groupchar"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงปีจากแท็ก 260::l::Include year from tag 260"); ?></TD>
<TD><?php 
form_quickedit("addyear",barcodeval_get("BARCODE-blockbc-standard-addyear"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงชื่อเรื่องหรือไม่::l::Show Title"); ?></TD>
<TD><?php 
form_quickedit("isshowtitle",barcodeval_get("BARCODE-blockbc-standard-isshowtitle"),"yesno"); 
?>  size  <input type="number" name="isshowtitlesize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-standard-isshowtitlesize")); ?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติม::l::Add text"); ?></TD>
<TD><?php 
form_quickedit("addtext",barcodeval_get("BARCODE-blockbc-standard-addtext"),"text"); 
?>  size  <input type="number" name="addtextsize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-standard-addtextsize")); ?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("% ความกว้างของสัน::l::% width of book spine"); ?></TD>
<TD><?php 
form_quickedit("spinewidth",barcodeval_get("BARCODE-blockbc-standard-spinewidth"),"list:20,25,30,35,40,45,50"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แท็กที่เก็บเลขเรียก::l::Tag for Call Number"); ?></TD>
<TD><?php 
form_quickedit("callntag",barcodeval_get("BARCODE-blockbc-standard-callntag"),"list:auto,tag050,tag060,tag082,tag090,tag098,tag099"); 
?>   size  <input type="number" name="callntagsize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-standard-callntagsize")); ?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("รูปแบบเลขเรียก::l::Call Number format"); ?></TD>
<TD><?php 
form_quickedit("callnformat",barcodeval_get("BARCODE-blockbc-standard-callnformat"),"list:DC,LC,1_line"); 
?></TD>
</TR>

<TR bgcolor=ffffff>
<TD align=center colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
</TR>

</FORM>
</TABLE>
<?php 
$bcgenmode="standard";
include("cfg._getexamples.php");
?>