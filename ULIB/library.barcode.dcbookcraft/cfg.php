<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
if ($save=='yes') {
	barcodeval_set("BARCODE-xpbc_dcbookcraft-iheight",$iheight);
	barcodeval_set("BARCODE-xpbc_dcbookcraft-iwidth",$iwidth);

	barcodeval_set("BARCODE-xpbc_dcbookcraft-width",$width);
	barcodeval_set("BARCODE-xpbc_dcbookcraft-height",$height);
	barcodeval_set("BARCODE-xpbc_dcbookcraft-text",$text);
	barcodeval_set("BARCODE-xpbc_dcbookcraft-papersize",$papersize);
	barcodeval_set("BARCODE-xpbc_dcbookcraft-str",$str);
	barcodeval_set("BARCODE-xpbc_dcbookcraft-perpage",$perpage);
	barcodeval_set("BARCODE-xpbc_dcbookcraft-allbc",$allbc);
	barcodeval_set("BARCODE-xpbc_dcbookcraft-color",$color);
}
$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?><CENTER>

<A class=a_btn HREF="bc_pdf.php" target=_blank><?php  echo getlang("พิมพ์::l::Print"); ?></A></CENTER>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="cfg.php">
<INPUT TYPE="hidden" name=save value=yes>
<TR>
<TD class=mnhead colspan=2><?php  echo getlang("ตั้งค่า::l::Settings"); ?></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("บาร์โค้ดที่จะพิมพ์::l::Barcodes"); ?></TD>
<TD><?php 
$barcode_manage="BARCODE-xpbc_dcbookcraft-allbc";
include("../library.barcode/globalinc.php");
?><TEXTAREA NAME="allbc" ROWS="9" COLS="25"><?php echo barcodeval_get("BARCODE-xpbc_dcbookcraft-allbc");?></TEXTAREA></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("ความกว้างบาร์โค้ด::l::Barcode Width"); ?></TD>
<TD><INPUT TYPE="text" NAME="width" size=15 value="<?php echo barcodeval_get("BARCODE-xpbc_dcbookcraft-width");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ความสูงบาร์โค้ด::l::Barcode Height"); ?></TD>
<TD><INPUT TYPE="text" NAME="height" size=15 value="<?php echo barcodeval_get("BARCODE-xpbc_dcbookcraft-height");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("ความละเอียดบาร์โค้ด (กว้าง)::l::Barcode resolution width"); ?></TD>
<TD><INPUT TYPE="text" NAME="iwidth" size=15 value="<?php echo barcodeval_get("BARCODE-xpbc_dcbookcraft-iwidth");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ความละเอียดบาร์โค้ด (สูง)::l::Barcode resolution height"); ?></TD>
<TD><INPUT TYPE="text" NAME="iheight" size=15 value="<?php echo barcodeval_get("BARCODE-xpbc_dcbookcraft-iheight");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("จำนวนบาร์โค้ดต่อคอลัมน์::l::Barcode per column"); ?></TD>
<TD><INPUT TYPE="text" NAME="perpage" size=15 value="<?php echo barcodeval_get("BARCODE-xpbc_dcbookcraft-perpage");?>"></TD>
</TR>


<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติม::l::Text"); ?> </TD>
<TD><INPUT TYPE="text" NAME="str" size=15 value="<?php echo barcodeval_get("BARCODE-xpbc_dcbookcraft-str");?>"></TD>
</TR>

<TR bgcolor=ffffff>
<TD><?php 
$color=barcodeval_get("BARCODE-xpbc_dcbookcraft-color");
 echo getlang("สีเพิ่มเติม::l::Color"); ?> </TD>
<TD><SELECT NAME="color">
<?php 
	$colors=explode(',',getval("_SETTING","barcode-colors"));
	while (list($ck,$cv)=each($colors)) {
				echo "<option value='$cv' ";
				 if ($color==$cv) { echo "selected"; }
				echo " style='color:$cv; background-color:$cv;'>$cv";
	}
?>
</SELECT></TD>
</TR>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงตัวเลขด้วยหรือไม่::l::Display number"); ?></TD>
<TD>
<?php 
$text=barcodeval_get("BARCODE-xpbc_dcbookcraft-text");
?>
<INPUT TYPE="radio" NAME="text" value=0 <?php  if ($text==0) { echo "checked"; }?> style="border: 0px;"> <?php  echo getlang("ไม่แสดง::l::No"); ?>
<INPUT TYPE="radio" NAME="text" value=1 <?php  if ($text==1) { echo "checked"; }?> style="border: 0px;"> <?php  echo getlang("แสดง::l::Yes"); ?>
</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ขนาดกระดาษ::l::Paper size"); ?></TD>
<TD>
<?php 
$papersize=barcodeval_get("BARCODE-xpbc_dcbookcraft-papersize");
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