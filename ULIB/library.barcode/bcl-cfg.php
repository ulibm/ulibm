<?php  
;
include("../inc/config.inc.php");
head();

$_REQPERM="barcode_pmembercard";
mn_lib();
if ($save=='yes') {
	barcodeval_set("BARCODE-membercard-bheight",$bheight);
	barcodeval_set("BARCODE-membercard-bwidth",$bwidth);
	barcodeval_set("BARCODE-membercard-iheight",$iheight);
	barcodeval_set("BARCODE-membercard-iwidth",$iwidth);

	barcodeval_set("BARCODE-membercard-width",$width);
	barcodeval_set("BARCODE-membercard-height",$height);
	barcodeval_set("BARCODE-membercard-class",$class);
	barcodeval_set("BARCODE-membercard-border",$border);
	barcodeval_set("BARCODE-membercard-bc",$bc);
	barcodeval_set("BARCODE-membercard-papersize",$papersize);
	barcodeval_set("BARCODE-membercard-cardfronttitle",$cardfronttitle);
	barcodeval_set("BARCODE-membercard-rule",$rule);
	barcodeval_set("BARCODE-membercard-picypos",$picypos);
	barcodeval_set("BARCODE-membercard-perpage",$perpage);
	barcodeval_set("BARCODE-membercard-currentcardtp",$currentcardtp);

	$dr="$dcrs/_tmp/cards/";
	if (strlen($_FILES['front1']['tmp_name'])!=0) { 
	   copy($_FILES['front1']['tmp_name'], "$dr" . "_card_front1.jpg"); 
	} 
	if (strlen($_FILES['back1']['tmp_name'])!=0) { 
	   copy($_FILES['back1']['tmp_name'], "$dr" . "_card_back1.jpg"); 
	} 
	if (strlen($_FILES['front2']['tmp_name'])!=0) { 
	   copy($_FILES['front2']['tmp_name'], "$dr" . "_card_front2.jpg"); 
	} 
	if (strlen($_FILES['back2']['tmp_name'])!=0) { 
	   copy($_FILES['back2']['tmp_name'], "$dr" . "_card_back2.jpg"); 
	} 
	if (strlen($_FILES['front3']['tmp_name'])!=0) { 
	   copy($_FILES['front3']['tmp_name'], "$dr" . "_card_front3.jpg"); 
	} 
	if (strlen($_FILES['back3']['tmp_name'])!=0) { 
	   copy($_FILES['back3']['tmp_name'], "$dr" . "_card_back3.jpg"); 
	} 
}
$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<CENTER><A class=a_btn HREF="print_bcl.php?rand=<?php echo randid?>.pdf" target=_blank ID=MEMBERBARCODE_PRINTBTN><?php echo getlang("พิมพ์::l::Print"); ?></A></CENTER>
 <TABLE <?php  echo $tbmn;?>>
<FORM METHOD=POST ACTION="bcl-cfg.php"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>
<TR>
<TD class=mnhead colspan=2><?php echo getlang("ระบุรายการที่จะพิมพ์::l::Specific member to print"); ?></TD>
</TR>

<TR  bgcolor=ffffff>
<TD><?php echo getlang("ระบุหมายเลขบาร์โค้ด::l::Memberbarcode"); ?></TD>
<TD><?php  
//$barcode_manage="BARCODE-membercard-bc";
//include("globalinc.php");
?><TEXTAREA NAME="bc" ROWS="6" COLS="20" ID="membercardbc"><?php  echo barcodeval_get("BARCODE-membercard-bc");?></TEXTAREA></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("เลือก$_ROOMWORD::l::Choose $_ROOMWORD"); ?></TD>
<TD>
<?php form_room("class",$class,"yes");?>
</TD>
</TR>

<TR>
<TD class=mnhead colspan=2><?php echo getlang("ตั้งค่า::l::Settings"); ?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ขนาดกระดาษ::l::Paper size"); ?></TD>
<TD>
<?php  
$papersize=barcodeval_get("BARCODE-membercard-papersize");
?>
<SELECT NAME="papersize">
<option value="A3" <?php if ($papersize=="A3") { echo "selected"; }?>>A3
<option value="A4"<?php if ($papersize=="A4") { echo "selected"; }?>>A4
<option value="Letter"<?php if ($papersize=="Letter") { echo "selected"; }?>>Letter
<option value="Legal"<?php if ($papersize=="Legal") { echo "selected"; }?>>Legal
</SELECT>
</TD>
</TR>

<TR  bgcolor=ffffff>
<TD><?php echo getlang("กฏที่พิมพ์หลังบัตร::l::Rules at back side"); ?></TD>
<TD><TEXTAREA NAME="rule" ROWS="5" COLS="20"><?php  echo barcodeval_get("BARCODE-membercard-rule");?></TEXTAREA></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php echo getlang("ข้อความหัวบัตร::l::Card title"); ?></TD>
<TD><INPUT TYPE="text" NAME="cardfronttitle" size=15 value="<?php  echo barcodeval_get("BARCODE-membercard-cardfronttitle");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php echo getlang("ความกว้างบัตร::l::Card width"); ?></TD>
<TD><INPUT TYPE="text" NAME="width" size=15 value="<?php  echo barcodeval_get("BARCODE-membercard-width");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ความสูงบัตร::l::Card height"); ?></TD>
<TD><INPUT TYPE="text" NAME="height" size=15 value="<?php  echo barcodeval_get("BARCODE-membercard-height");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php echo getlang("ความกว้างบาร์โค้ด::l::Barcode Width"); ?></TD>
<TD><INPUT TYPE="text" NAME="bwidth" size=15 value="<?php  echo barcodeval_get("BARCODE-membercard-bwidth");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ความสูงบาร์โค้ด::l::Barcode Height"); ?></TD>
<TD><INPUT TYPE="text" NAME="bheight" size=15 value="<?php  echo barcodeval_get("BARCODE-membercard-bheight");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php echo getlang("ความละเอียดบาร์โค้ด (กว้าง)::l::Barcode resolution width"); ?></TD>
<TD><INPUT TYPE="text" NAME="iwidth" size=15 value="<?php  echo barcodeval_get("BARCODE-membercard-iwidth");?>"></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ความละเอียดบาร์โค้ด (สูง)::l::Barcode resolution height"); ?></TD>
<TD><INPUT TYPE="text" NAME="iheight" size=15 value="<?php  echo barcodeval_get("BARCODE-membercard-iheight");?>"></TD>
</TR>
<TR  bgcolor=ffffff>
<TD><?php echo getlang("จำนวนบาร์โค้ดต่อหน้า::l::Barcode per page"); ?></TD>
<TD><INPUT TYPE="text" NAME="perpage" size=15 value="<?php  echo barcodeval_get("BARCODE-membercard-perpage");?>"></TD>
</TR>

<TR bgcolor=ffffff>
<TD><?php echo getlang("ตำแหน่งด้านซ้ายที่วางภาพ::l::Y-position for picture"); ?></TD>
<TD><INPUT TYPE="text" NAME="picypos" size=15 value="<?php  echo barcodeval_get("BARCODE-membercard-picypos");?>"></TD>
</TR>

<TR bgcolor=ffffff>
<TD><?php echo getlang("แสดงเส้นขอบหรือไม่::l::Show borders"); ?></TD>
<TD>
<?php  
$border=barcodeval_get("BARCODE-membercard-border");
?>
<INPUT TYPE="radio" NAME="border" value=0 <?php if ($border==0) { echo "checked"; }?> style="border: 0px;"> <?php echo getlang("ไม่แสดง::l::No"); ?> 
<INPUT TYPE="radio" NAME="border" value=1 <?php if ($border==1) { echo "checked"; }?> style="border: 0px;">  <?php echo getlang("แสดง::l::Yes"); ?>
</TD>
</TR>

<TR bgcolor=ffffff>
<TD class=table_head><?php echo getlang("ใช้ภาพนี้::l::Use this template"); ?></TD>
<TD class=table_head><INPUT TYPE="radio" NAME="currentcardtp" value=1 <?php  
$currentcardtp=barcodeval_get("BARCODE-membercard-currentcardtp");
if ($currentcardtp=="1") {
	echo "checked";
}
?>></TD>
</TR><TR bgcolor=ffffff>
<TD><img src="../_tmp/cards/_card_front1.jpg?<?php echo rand();?>" width=244 height=155></TD>
<TD><img src="../_tmp/cards/_card_back1.jpg?<?php echo rand();?>" width=244 height=155></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ด้านหน้าบัตร::l::Card front side"); ?></TD>
<TD><INPUT TYPE="file" NAME="front1" size=15 ><small></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ด้านหลังบัตร::l::Card back side"); ?></TD>
<TD><INPUT TYPE="file" NAME="back1" size=15 > </TD>
</TR>

<TR bgcolor=ffffff >
<TD class=table_head><?php echo getlang("ใช้ภาพนี้::l::Use this template"); ?></TD>
<TD class=table_head><INPUT TYPE="radio" NAME="currentcardtp" value=2 <?php  
$currentcardtp=barcodeval_get("BARCODE-membercard-currentcardtp");
if ($currentcardtp=="2") {
	echo "checked";
}
?>></TD>
</TR><TR bgcolor=ffffff>
<TD><img src="../_tmp/cards/_card_front2.jpg?<?php echo rand();?>" width=244 height=155></TD>
<TD><img src="../_tmp/cards/_card_back2.jpg?<?php echo rand();?>" width=244 height=155></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ด้านหน้าบัตร::l::Card front side"); ?></TD>
<TD><INPUT TYPE="file" NAME="front2" size=15 ><small></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ด้านหลังบัตร::l::Card back side"); ?></TD>
<TD><INPUT TYPE="file" NAME="back2" size=15 > </TD>
</TR>


<TR bgcolor=ffffff>
<TD class=table_head><?php echo getlang("ใช้ภาพนี้::l::Use this template"); ?></TD>
<TD class=table_head><INPUT TYPE="radio" NAME="currentcardtp" value=3 <?php  
$currentcardtp=barcodeval_get("BARCODE-membercard-currentcardtp");
if ($currentcardtp=="3") {
	echo "checked";
}
?>></TD>
</TR>
<TR bgcolor=ffffff>
<TD><img src="../_tmp/cards/_card_front3.jpg?<?php echo rand();?>" width=244 height=155></TD>
<TD><img src="../_tmp/cards/_card_back3.jpg?<?php echo rand();?>" width=244 height=155></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ด้านหน้าบัตร::l::Card front side"); ?></TD>
<TD><INPUT TYPE="file" NAME="front3" size=15 ><small></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php echo getlang("ด้านหลังบัตร::l::Card back side"); ?></TD>
<TD><INPUT TYPE="file" NAME="back3" size=15 > </TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=2><small>**<?php echo getlang("เฉพาะไฟล์ .JPG เท่านั้น ขนาดที่เหมาะสมคือ กว้าง 244px สูง 155px ความละเอียดไม่น้อยกว่า::l::Only JPEG file, preferred size is W 244px H 155px, Minimum resolution is"); ?> 300dpi</TD>
</TR>

<TR bgcolor=ffffff  >
<TD align=center ID=MEMBERCARD_SUBMITTR colspan=2><INPUT TYPE="submit" value="<?php echo getlang("บันทึก::l::Save"); ?>"> <INPUT TYPE="reset" value="<?php echo getlang("ยกเลิก::l::Reset"); ?>"></TD>
</TR>


</FORM>
</TABLE>
<?php  
foot();
?>