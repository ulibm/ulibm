<?php 
;
include("../../inc/config.inc.php");
head();
if ($save=='yes') {
	$dr="$dcrs/_tmp/";
	if (strlen($_FILES['selectedfile']['tmp_name'])!=0) { 
	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "havestclientlogo-$mediatypemanage.png"); 
	}
}
mn_root("havester");

$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="upload.php"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>
<INPUT TYPE="hidden" name=mediatypemanage value="<?php  echo $mediatypemanage;?>">
<TR>
<TD class=mnhead colspan=2><?php  echo getlang("เลือกอัพโหลดภาพ::l::Upload icon "); 
echo "<BR><CENTER>$mediatypemanage</CENTER>";?></TD>
</TR>


<TR bgcolor=ffffff>
<TD><?php  echo getlang("เลือกภาพ::l::Choose picture"); ?></TD>
<TD><INPUT TYPE="file" NAME="selectedfile" size=15 ><small></TD>
</TR>

 <TR bgcolor=ffffff>
<TD colspan=2  align=center><img src="../../_tmp/havestclientlogo-<?php  echo $mediatypemanage;?>.png?<?php  echo rand();?>" width=48 height=48 style="border-width:1;border-style:inset;">
<BR><small>**<?php  echo getlang("เฉพาะไฟล์ .PNG เท่านั้น กว้าง 48 px สูง 48 px::l::Only PNG file, Width 48 px Height  48 px"); ?></TD>
</TR>

<TR bgcolor=ffffff>
<TD align=right colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"> <A HREF="clientlist.php">Back</A></TD>
</TR>

</FORM>
</TABLE>
<?php 
foot();
?>