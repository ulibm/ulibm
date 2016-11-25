<?php 
;
include("../inc/config.inc.php");
head();
if ($save=='yes') {
	$dr="$dcrs/_tmp/createwebbanner/";
	if (strlen($_FILES['selectedfile']['tmp_name'])!=0) { 
		@unlink("$dr" . "$mediatypemanage.jpg");
		@copy($_FILES['selectedfile']['tmp_name'], "$dr" . "$mediatypemanage.jpg"); 
		@unlink("$dr" . "$mediatypemanage.jpg.thumb.jpg");
		@copy("$dr" . "$mediatypemanage.jpg","$dr" .  "$mediatypemanage.jpg.thumb.jpg"); 
		fso_image_fixsize("$dr" .  "$mediatypemanage.jpg.thumb.jpg","jpg",120);
	}
}
$_REQPERM="createwebbanner";
$tmp=mn_lib();

$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="upload.php"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>
<INPUT TYPE="hidden" name=mediatypemanage value="<?php  echo $mediatypemanage;?>">
<TR>
<TD class=mnhead colspan=2><?php  echo getlang("เลือกอัพโหลดภาพ::l::Upload "); 
echo "<BR><CENTER>$mediatypemanage</CENTER>";?></TD>
</TR>


<TR bgcolor=ffffff>
<TD><?php  echo getlang("เลือกภาพ::l::Choose picture"); ?></TD>
<TD><INPUT TYPE="file" NAME="selectedfile" size=15 ><small></TD>
</TR>

 <TR bgcolor=ffffff>
<TD colspan=2  align=center><img src="../_tmp/createwebbanner/<?php  echo $mediatypemanage;?>.jpg?<?php  echo rand();?>" width=200 height=200 style="border-width:1;border-style:inset;">
<BR><small>**<?php  echo getlang("เฉพาะไฟล์ .JPG เท่านั้น ::l::Only JPG file,"); ?></TD>
</TR>

<TR bgcolor=ffffff>
<TD align=right colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"> <A HREF="index.php">Back</A></TD>
</TR>

</FORM>
</TABLE>
<?php 
foot();
?>