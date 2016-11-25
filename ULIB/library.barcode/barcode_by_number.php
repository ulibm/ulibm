<?php 
;
include("../inc/config.inc.php");
head();
$_REQPERM="barcode_by_number";
mn_lib();
if ($save=='yes') {
	barcodeval_set("BARCODE-barcode_bynumber-iheight",$iheight);
	barcodeval_set("BARCODE-barcode_bynumber-iwidth",$iwidth);

	barcodeval_set("BARCODE-barcode_bynumber-width",$width);
	barcodeval_set("BARCODE-barcode_bynumber-height",$height);
	barcodeval_set("BARCODE-barcode_bynumber-start",$start);
	barcodeval_set("BARCODE-barcode_bynumber-end",$end);
	barcodeval_set("BARCODE-barcode_bynumber-text",$text);
	barcodeval_set("BARCODE-barcode_bynumber-digit",$digit);
	barcodeval_set("BARCODE-barcode_bynumber-number",$number);
	barcodeval_set("BARCODE-barcode_bynumber-papersize",$papersize);
	barcodeval_set("BARCODE-barcode_bynumber-colnum",$colnum);
	barcodeval_set("BARCODE-barcode_bynumber-perpage",$perpage);
}
$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?><CENTER>

<A class=a_btn HREF="print_barcode_by_number.php" target=_blank><?php  echo getlang("พิมพ์::l::Print"); ?></A></CENTER>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="barcode_by_number.php">
<INPUT TYPE="hidden" name=save value=yes>
<TR>
<TD class=mnhead colspan=2><?php  echo getlang("ตั้งค่า::l::Settings"); ?></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("ความกว้างบาร์โค้ด::l::Barcode Width"); ?></TD>
<TD><INPUT TYPE="text" NAME="width" size=15 value="<?php echo barcodeval_get("BARCODE-barcode_bynumber-width");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ความสูงบาร์โค้ด::l::Barcode Height"); ?></TD>
<TD><INPUT TYPE="text" NAME="height" size=15 value="<?php echo barcodeval_get("BARCODE-barcode_bynumber-height");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("ความละเอียดบาร์โค้ด (กว้าง)::l::Barcode resolution width"); ?></TD>
<TD><INPUT TYPE="text" NAME="iwidth" size=15 value="<?php echo barcodeval_get("BARCODE-barcode_bynumber-iwidth");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ความละเอียดบาร์โค้ด (สูง)::l::Barcode resolution height"); ?></TD>
<TD><INPUT TYPE="text" NAME="iheight" size=15 value="<?php echo barcodeval_get("BARCODE-barcode_bynumber-iheight");?>"></TD>
</TR>

<TR  bgcolor=ffffff>
<TD><?php  echo getlang("เริ่มจากหมายเลข::l::Start Number"); ?></TD>
<TD><INPUT TYPE="text" NAME="start" size=15 value="<?php echo barcodeval_get("BARCODE-barcode_bynumber-start");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ถึงจากหมายเลข::l::End Number"); ?></TD>
<TD><INPUT TYPE="text" NAME="end" size=15 value="<?php echo barcodeval_get("BARCODE-barcode_bynumber-end");?>"></TD>
</TR><TR bgcolor=ffffff>
<TD><?php  echo getlang("จำนวนหลักของตัวอักษรในบาร์โค้ด::l::Digits "); ?></TD>
<TD><INPUT TYPE="text" NAME="digit" size=15 value="<?php echo barcodeval_get("BARCODE-barcode_bynumber-digit");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("จำนวนบาร์โค้ดต่อหน้า::l::Barcode per page"); ?></TD>
<TD><INPUT TYPE="text" NAME="perpage" size=15 value="<?php echo barcodeval_get("BARCODE-barcode_bynumber-perpage");?>"></TD>
</TR>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความที่จะให้แสดง::l::Text to show"); ?> </TD>
<TD><INPUT TYPE="text" NAME="text" size=15 value="<?php echo barcodeval_get("BARCODE-barcode_bynumber-text");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงตัวเลขด้วยหรือไม่::l::Display number"); ?></TD>
<TD>
<?php 
$number=barcodeval_get("BARCODE-barcode_bynumber-number");
?>
<INPUT TYPE="radio" NAME="number" value=0 <?php  if ($number==0) { echo "checked"; }?> style="border: 0px;"> <?php  echo getlang("ไม่แสดง::l::No"); ?> 
<INPUT TYPE="radio" NAME="number" value=1 <?php  if ($number==1) { echo "checked"; }?> style="border: 0px;"> <?php  echo getlang("แสดง::l::Yes"); ?> 
</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("จำนวนคอลัมน์ในการพิมพ์::l::Print Columns"); ?></TD>
<TD>
<?php 
$colnum=barcodeval_get("BARCODE-barcode_bynumber-colnum");
?>
<INPUT TYPE="radio" NAME="colnum" value=2 <?php  if ($colnum==2) { echo "checked"; }?> style="border: 0px;"> 2
<INPUT TYPE="radio" NAME="colnum" value=3 <?php  if ($colnum==3) { echo "checked"; }?> style="border: 0px;"> 3
</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ขนาดกระดาษ::l::Paper size"); ?></TD>
<TD>
<?php 
$papersize=barcodeval_get("BARCODE-barcode_bynumber-papersize");
?>
<SELECT NAME="papersize">
<option value="A3" <?php  if ($papersize=="A3") { echo "selected"; }?>>A3
<option value="A4"<?php  if ($papersize=="A4") { echo "selected"; }?>>A4
<option value="Letter"<?php  if ($papersize=="Letter") { echo "selected"; }?>>Letter
<option value="Legal"<?php  if ($papersize=="Legal") { echo "selected"; }?>>Legal
</SELECT>
</TD>
</TR>

<TR bgcolor=ffffff>
<TD align=right><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
<TD><INPUT TYPE="reset" value="<?php  echo getlang("ยกเลิก::l::Reset"); ?>"></TD>
</TR>
</FORM>
</TABLE>
<?php 
foot();
?>