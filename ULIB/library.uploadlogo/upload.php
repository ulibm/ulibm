<?php 
;
include("../inc/config.inc.php");
head();
$_REQPERM="uploadlogo";
mn_lib();
if ($save=='yes') {
	$dr="$dcrs/_tmp/paper/";
	if (strlen($_FILES['head']['tmp_name'])!=0) { 
	   copy($_FILES['head']['tmp_name'], "$dr" . "_paper_head.jpg"); 
	} 
	if (strlen($_FILES['foot']['tmp_name'])!=0) { 
	   copy($_FILES['foot']['tmp_name'], "$dr" . "_paper_foot.jpg"); 
	} 
	$dr="$dcrs/_tmp/logo/";
	if (strlen($_FILES['weblogoicon']['tmp_name'])!=0) { 
	   copy($_FILES['weblogoicon']['tmp_name'], "$dr" . "_weblogoicon.png"); 
	} 
	if (strlen($_FILES['logo']['tmp_name'])!=0) { 
	   copy($_FILES['logo']['tmp_name'], "$dr" . "_logo.jpg"); 
	} 
	if (strlen($_FILES['weblogo']['tmp_name'])!=0) { 
	   copy($_FILES['weblogo']['tmp_name'], "$dr" . "_weblogo.png"); 
	} 

	/*
	$dr="$dcrs/_tmp/";
	if ($deloldfloorplan=="yes") {
		 @unlink("$dr" . "_floorplan.jpg");
	}
	if (strlen($_FILES['floorplan']['tmp_name'])!=0) { 
	   copy($_FILES['floorplan']['tmp_name'], "$dr" . "_floorplan.jpg"); 
	} 	
	*/
	barcodeval_set("webpage-o-isshowweblogodecis",addslashes($isshowweblogodecis));
	barcodeval_set("webpage-o-isshowweblogodecistop",addslashes($isshowweblogodecistop));
	
	redir($PHP_SELF); die;
}
$tbmn="width= 780  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="upload.php"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>
<TR>
<TD class=mnhead colspan=2><?php  echo getlang("ดูภาพ และเลือกอัพโหลด::l::View and upload"); ?></TD>
</TR>

 <TR bgcolor=ffffff>
<TD><?php  echo getlang("ภาพโลโก้ที่จะแสดงที่ส่วนหัว::l::Web logo"); ?></TD>
<TD><img src="../_tmp/logo/_weblogo.png?<?php  echo rand();?>" width=261 height=66 style="border-width:3;border-style:inset;">
<BR>
<INPUT TYPE="file" NAME="weblogo" size=15 > <BR>
<small><?php  echo getlang("เฉพาะไฟล์ .PNG เท่านั้น กว้าง 261px สูง 66 px::l::Only JPEG file, Width 261px Height  66 px"); ?><br>
<?php  echo getlang("ต้องการให้แสดงโลโก้ที่ส่วนหัวเว็บหรือไม่ ::l:: Uncheck if don't want to show web top bar ");?> <?php  form_quickedit("isshowweblogodecistop",barcodeval_get("webpage-o-isshowweblogodecistop"),"yesno"); ?>

</TD>
</TR>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("ภาพหัวกระดาษ::l::Page header"); ?>
<BR><font class=smaller2>(v5.x)</font>

</TD>
<TD><img src="../_tmp/paper/_paper_head.jpg?<?php  echo rand();?>" width=400 style="border-width:3;border-style:inset;"><BR>
<INPUT TYPE="file" NAME="head" size=15 >
<BR>
<small><?php  echo getlang("ขนาดที่เหมาะสมคือ กว้าง 2480px สูง 200px::l:: Width 2480px Height 200px"); ?></small> </TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ภาพท้ายกระดาษ::l::Page footer"); ?>
<BR><font class=smaller2>(v5.x)</font>
</TD>
<TD>
<img src="../_tmp/paper/_paper_foot.jpg?<?php  echo rand();?>" width=400 style="border-width:3;border-style:inset;"><BR>
<INPUT TYPE="file" NAME="foot" size=15 >
<br>
<small><?php  echo getlang("ขนาดที่เหมาะสมคือ กว้าง 2480px สูง 59px::l::Width 2480px Height  59px"); ?></small></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ภาพโลโก้สถาบัน (บาร์โค้ดหนังสือ)::l::Library logo (Books-barcode)"); ?>
<BR><font class=smaller2>(v5.x)</font>
</TD>
<TD>
<img src="../_tmp/logo/_logo.jpg?<?php  echo rand();?>" style="border-width:3;border-style:inset;">
<BR>
<INPUT TYPE="file" NAME="logo" size=15 ><BR><small><?php  echo getlang("ขนาดที่เหมาะสมคือ กว้าง 45px สูง 45px::l:: Width 45px Height  45px"); ?><BR><?php  echo getlang("เฉพาะไฟล์ .JPG เท่านั้น ความละเอียดไม่ควรน้อยกว่า 300dpi::l::Only JPEG file, resolution 300dpi+"); ?> </TD>
</TR>
 <TR bgcolor=ffffff>
<TD><?php  echo getlang("ภาพโลโก้ที่แสดงที่เว็บเพจ::l::Webpage logo avartar"); ?><BR>
<font class=smaller2>(<?php  echo getlang("หน้าเว็บแบบเว็บเพจ::l::Homepage type=webpage"); ?>)</font>
</TD>
<TD>
<img src="../_tmp/logo/_weblogoicon.png?<?php  echo rand();?>" width=150 height=150 style="border-width:3;border-style:inset;">
<BR><small>**<?php  echo getlang("เฉพาะไฟล์ .PNG เท่านั้น กว้าง 150 px สูง 150 px::l::Only PNG file, Width 150 px Height  150 px"); ?>
<BR><INPUT TYPE="file" NAME="weblogoicon" size=15 ><BR>
<?php  echo getlang("ต้องการให้แสดงโลโก้ที่หน้าหลักเว็บหรือไม่ ::l:: Uncheck if don't want to show web-logo ");?> <?php  form_quickedit("isshowweblogodecis",barcodeval_get("webpage-o-isshowweblogodecis"),"yesno"); ?></TD>
</TR>
<!--  <TR bgcolor=ffffff>
<TD><?php  echo getlang("ภาพแผนที่ห้องสมุด::l::Floor plan"); ?></TD>
<TD><INPUT TYPE="file" NAME="floorplan" size=15 > <br />
<a href="../itemplaces.php" target=_blank><?php  echo getlang("แสดงที่ หน้าแสดงสถานที่จัดเก็บ::l::Display at book shelves");?></a><br />
<?php  echo getlang("เฉพาะไฟล์ .JPG เท่านั้น กว้าง 780px::l::Only JPEG file, Width 780px"); ?><br />
<input type="checkbox" name="deloldfloorplan" value="yes" style="border-width:0"/> <?php  echo getlang("ลบแผนที่::l::Delete floor plan");?>
 </TD>
</TR> -->




<TR bgcolor=ffffff>
<TD align=right><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
<TD><INPUT TYPE=reset value="<?php  echo getlang("ล้างค่า::l::reset"); ?>"></TD>
</TR>

</FORM>
</TABLE>
<?php 
foot();
?>