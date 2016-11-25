<?php 
	include ("../inc/config.inc.php");
	head();
	$_REQPERM="ulibecard-bgs";
	$tmp=mn_lib();
	pagesection(getlang($$tmp));

if ($save=='yes') {
	$dr="$dcrs/_tmp/ecard/";
	if (strlen($_FILES['selectedfile']['tmp_name'])!=0) { 
	   copy($_FILES['selectedfile']['tmp_name'], "$dr" . "$mediatypemanage.jpg"); 
	}
}

$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?> class=table_border>
<FORM METHOD=POST ACTION="upload.php"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>
<INPUT TYPE="hidden" name=mediatypemanage value="<?php  echo $mediatypemanage;?>">
<TR>
<TD class=mnhead colspan=2><?php  echo getlang("เลือกอัพโหลดภาพสำหรับุ::l::Upload Image for "); 
$mediatypemanagename=tmq("select * from htmltemplate where id='$mediatypemanage'; ");
$mediatypemanagename=tmq_fetch_array($mediatypemanagename);
$mediatypemanagename=$mediatypemanagename[name];
echo "<BR><CENTER>$mediatypemanagename</CENTER>";?></TD>
</TR>


<TR bgcolor=ffffff>
<TD><?php  echo getlang("เลือกภาพ::l::Choose picture"); ?></TD>
<TD><INPUT TYPE="file" NAME="selectedfile" size=15 ><small></TD>
</TR>

 <TR bgcolor=ffffff>
<TD colspan=2  align=center><img src="../_tmp/ecard/<?php  echo $mediatypemanage;?>.jpg?<?php  echo rand();?>" width=512 height=256 style="border-width:1;border-style:inset;">
<BR><small>**<?php  echo getlang("เฉพาะไฟล์ .JPG เท่านั้น กว้าง 1024 px สูง 512 px::l::Only JPG file, Width 1024 px Height 512 px"); ?></TD>
</TR>

<TR bgcolor=ffffff>
<TD align=right colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"> <A HREF="index.php">Back</A></TD>
</TR>

</FORM>
</TABLE>
<?php 
foot();
?>