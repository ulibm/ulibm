<?php 
;
include("../inc/config.inc.php");
head();
if ($save=='yes') {
	$dr="$dcrs/_tmp/mediatype/";
	if (strlen($_FILES['selectedfile']['tmp_name'])!=0) { 
	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "$mediatypemanage.png"); 
	}
}
$_REQPERM="mediatype";
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
<TD class=mnhead colspan=2><?php  echo getlang("เลือกอัพโหลดภาพสำหรับประเภทวัสดุ::l::Upload icon of media type"); 
echo "<BR><CENTER>$mediatypemanage</CENTER>";?></TD>
</TR>


<TR bgcolor=ffffff>
<TD><?php  echo getlang("เลือกภาพ::l::Choose picture"); ?></TD>
<TD><INPUT TYPE="file" NAME="selectedfile" size=15 ><small></TD>
</TR>

 <TR bgcolor=ffffff>
<TD colspan=2  align=center>
<div style="padding-top: 10px;position: relative;   margin-left: 170 ;
  margin-right: auto ;">

<img src="../_tmp/mediatype/<?php  echo $mediatypemanage;?>.png?<?php  echo rand();?>" width=16 height=16 style="border-width:1;border-style:inset; float: left;" hspace=10>
<img src="../_tmp/mediatype/<?php  echo $mediatypemanage;?>.png?<?php  echo rand();?>" width=32 height=32 style="border-width:1;border-style:inset; float: left;" hspace=10>
<img src="../_tmp/mediatype/<?php  echo $mediatypemanage;?>.png?<?php  echo rand();?>" width=48 height=48 style="border-width:1;border-style:inset; float: left;" hspace=10>

</div>

<div style="clear:both;"></div>
<BR><small>**<?php  echo getlang("เฉพาะไฟล์ .PNG เท่านั้น กว้าง 48 px สูง 48 px::l::Only PNG file, Width 48 px Height  48 px"); ?></TD>
</TR>

<TR bgcolor=ffffff>
<TD align=right colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"> <A HREF="index.php">Back</A></TD>
</TR>

</FORM>
</TABLE>
<?php 
foot();
?>