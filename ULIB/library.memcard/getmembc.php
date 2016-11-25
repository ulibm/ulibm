<?php 
;
include("../inc/config.inc.php");
html_start();

include("_REQPERM.php");
loginchk_lib("check");
if ($save=='yes') {
	/*
	$dr="$dcrs/_tmp/";
	if (strlen($_FILES['head']['tmp_name'])!=0) { 
	   copy($_FILES['head']['tmp_name'], "$dr" . "_paper_head.jpg"); 
	} 
	*/
	$length=floor($length);


	
	$s="select * from member where 1";
   if ($room!="") {
      $s.=" and room='$room' ";
   }
   if ($major!="") {
      $s.=" and major='$major' ";
   }
   $s=tmq($s);
   $res="";
   while($r=tfa($s)) {
      $res.=$newline.$r[UserAdminID];
   }
	barcodeval_set("BARCODE-memcardbc-allbc",$res);
	$res=barcodeval_get("BARCODE-memcardbc-allbc");
	barcodeval_set("BARCODE-memcardbc-allbc",$res);

	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location.reload();
	//-->
	</SCRIPT><?php 
   die;
}
$tbmn="width= 780  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="<?php  echo $PHPSELF;?>"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("$_ROOMWORD"); ?></TD>
<TD><?php 
form_room("room","","yes");
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("$_FACULTYWORD"); ?></TD>
<TD><?php 
form_quickedit("major","","foreign:-localdb-,major,id,name,allowblank"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD align=center colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("ดึงข้อมูล::l::Retrieve"); ?>"></TD>
</TR>

</FORM>
</TABLE>