<?php 
;
include("../inc/config.inc.php");
html_start();

include("_REQPERM.php");
loginchk_lib("check");

if ($save=='yes') {
	$dr="$dcrs/_tmp/bcsinglecolor/";
	if (strlen($_FILES['selectedfile']['tmp_name'])!=0) { 
	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "$mediatypemanage.jpg"); 
	}
}

$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="cfg.singlecolor.upload.php"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>
<INPUT TYPE="hidden" name=mediatypemanage value="<?php  echo $mediatypemanage;?>">
<TR>
<TD class=mnhead colspan=2><?php  echo getlang("เลือกอัพโหลดภาพสำหรับเป็นภาพพื้นหลัง::l::Upload icon of media type"); 
echo "<BR><CENTER>$mediatypemanage</CENTER>";?></TD>
</TR>


<TR bgcolor=ffffff>
<TD><?php  echo getlang("เลือกภาพ::l::Choose picture"); ?></TD>
<TD><INPUT TYPE="file" NAME="selectedfile" size=15 ><small></TD>
</TR>

 <TR bgcolor=ffffff>
<TD colspan=2  align=center><img src="../_tmp/bcsinglecolor/<?php  echo $mediatypemanage;?>.jpg?<?php  echo rand();?>" width=48 height=48 style="border-width:1;border-style:inset;">
<BR><small>**<?php  echo getlang("เฉพาะไฟล์ .jpg เท่านั้น, ด้านบนของบาร์โค้ดคือฝั่งซ้ายมือ::l::Only jpg file, Top of Barcode is on the left"); ?></TD>
</TR>

<TR bgcolor=ffffff>
<TD align=right colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"> <A HREF="cfg.singlecolor.set.php">Back</A></TD>
</TR>

</FORM>
</TABLE>
<?php 
foot();
?>