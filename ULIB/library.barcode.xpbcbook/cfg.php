<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
if ($save=='yes') {
	barcodeval_set("BARCODE-xpbcbook-iheight",$iheight);
	barcodeval_set("BARCODE-xpbcbook-iwidth",$iwidth);

	barcodeval_set("BARCODE-xpbcbook-width",$width);
	barcodeval_set("BARCODE-xpbcbook-height",$height);
	barcodeval_set("BARCODE-xpbcbook-text",$text);
	barcodeval_set("BARCODE-xpbcbook-papersize",$papersize);
	barcodeval_set("BARCODE-xpbcbook-str",$str);
	barcodeval_set("BARCODE-xpbcbook-perpage",$perpage);
	barcodeval_set("BARCODE-xpbcbook-isborder",$isborder);
	barcodeval_set("BARCODE-xpbcbook-color",$color);
}
$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?><CENTER>

<A class=a_btn HREF="media_type.php"><?php  echo getlang("เมนูบาร์โค้ดหนังสือ::l::Books-barcode"); ?></A></CENTER>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="cfg.php">
<INPUT TYPE="hidden" name=save value=yes>
<TR>
<TD class=mnhead colspan=2><?php  echo getlang("ตั้งค่า::l::Settings"); ?></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("ความกว้างบาร์โค้ด::l::Barcode Width"); ?></TD>
<TD><INPUT TYPE="text" NAME="width" size=15 value="<?php echo barcodeval_get("BARCODE-xpbcbook-width");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ความสูงบาร์โค้ด::l::Barcode Height"); ?></TD>
<TD><INPUT TYPE="text" NAME="height" size=15 value="<?php echo barcodeval_get("BARCODE-xpbcbook-height");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("ความละเอียดบาร์โค้ด (กว้าง)::l::Barcode resolution width"); ?></TD>
<TD><INPUT TYPE="text" NAME="iwidth" size=15 value="<?php echo barcodeval_get("BARCODE-xpbcbook-iwidth");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ความละเอียดบาร์โค้ด (สูง)::l::Barcode resolution height"); ?></TD>
<TD><INPUT TYPE="text" NAME="iheight" size=15 value="<?php echo barcodeval_get("BARCODE-xpbcbook-iheight");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php  echo getlang("จำนวนบาร์โค้ดต่อหน้า::l::Barcode per page"); ?></TD>
<TD><INPUT TYPE="text" NAME="perpage" size=15 value="<?php echo barcodeval_get("BARCODE-xpbcbook-perpage");?>"></TD>
</TR>


<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติม::l::Text"); ?> </TD>
<TD><INPUT TYPE="text" NAME="str" size=15 value="<?php echo barcodeval_get("BARCODE-xpbcbook-str");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงเส้นขอบด้วยหรือไม่::l::Display border"); ?></TD>
<TD>
<?php 
$isborder=barcodeval_get("BARCODE-xpbcbook-isborder");
?>
<INPUT TYPE="radio" NAME="isborder" value=0 <?php  if ($isborder==0) { echo "checked"; }?> style="border: 0px;"> <?php  echo getlang("ไม่แสดง::l::No"); ?>
<INPUT TYPE="radio" NAME="isborder" value=1 <?php  if ($isborder==1) { echo "checked"; }?> style="border: 0px;"> <?php  echo getlang("แสดง::l::Yes"); ?>
</TD>
</TR>

<TR bgcolor=ffffff>
<TD><?php 
$color=barcodeval_get("BARCODE-xpbcbook-color");
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
$text=barcodeval_get("BARCODE-xpbcbook-text");
?>
<INPUT TYPE="radio" NAME="text" value=0 <?php  if ($text==0) { echo "checked"; }?> style="border: 0px;"> <?php  echo getlang("ไม่แสดง::l::No"); ?>
<INPUT TYPE="radio" NAME="text" value=1 <?php  if ($text==1) { echo "checked"; }?> style="border: 0px;"> <?php  echo getlang("แสดง::l::Yes"); ?>
</TD>
</TR>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("ขนาดกระดาษ::l::Paper size"); ?></TD>
<TD>
<?php 
$papersize=barcodeval_get("BARCODE-xpbcbook-papersize");
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