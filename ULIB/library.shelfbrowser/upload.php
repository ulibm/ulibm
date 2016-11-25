<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
if ($save=='yes') {


	$dr="$dcrs/_tmp/";
	if ($deloldfloorplan=="yes") {
		 @unlink("$dr" . "_floorplan_$site.jpg");
	}
	if (strlen($_FILES['floorplan']['tmp_name'])!=0) { 
	   copy($_FILES['floorplan']['tmp_name'], "$dr" . "_floorplan_$site.jpg"); 
	} 	

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
<TD><?php  echo getlang("ภาพแผนที่ห้องสมุดของ ::l::Floor plan for ") .get_libsite_name($site);; ?></TD>
<TD><img src="../_tmp/_floorplan_<?php  echo $site;?>.jpg?<?php  echo rand();?>" width=200 style="border-width:3;border-style:inset;"><BR><INPUT TYPE="file" NAME="floorplan" size=15 >
 <br />
<a href="../itemplaces.php" target=_blank><?php  echo getlang("แสดงที่ หน้าแสดงสถานที่จัดเก็บ::l::Display at book shelves");?></a><br />
<?php  echo getlang("เฉพาะไฟล์ .JPG เท่านั้น กว้าง 1000px::l::Only JPEG file, Width 1000px"); ?><br />
<INPUT TYPE="hidden" NAME="site" value="<?php  echo $site?>">
<input type="checkbox" name="deloldfloorplan" value="yes" style="border-width:0"/> <?php  echo getlang("ลบแผนที่::l::Delete floor plan");?>
 </TD>
</TR>




<TR bgcolor=ffffff>
<TD align=right><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
<TD><INPUT TYPE=reset value="<?php  echo getlang("ล้างค่า::l::reset"); ?>"> <A HREF="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></A></TD>
</TR>

</FORM>
</TABLE>
<?php 
foot();
?>