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
	barcodeval_set("BARCODE-blockbc-qrcode-isshownum",addslashes($isshownum));
	barcodeval_set("BARCODE-blockbc-qrcode-addtext",addslashes($addtext));
	barcodeval_set("BARCODE-blockbc-qrcode-isshowttcalln",addslashes($isshowttcalln));
}
$tbmn="width= 780  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="<?php  echo $PHPSELF;?>"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงหมายเลขหรือไม่::l::Show Number"); ?></TD>
<TD><?php 
form_quickedit("isshownum",barcodeval_get("BARCODE-blockbc-qrcode-isshownum"),"yesno"); 
?></TD>
</TR>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงชื่อเรื่องและเลขเรียก::l::Show Title and Call number"); ?></TD>
<TD><?php 
form_quickedit("isshowttcalln",barcodeval_get("BARCODE-blockbc-qrcode-isshowttcalln"),"yesno"); 
?></TD>
</TR>


<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติม::l::Add text"); ?></TD>
<TD><?php 
form_quickedit("addtext",barcodeval_get("BARCODE-blockbc-qrcode-addtext"),"longtext"); 
?><BR>[bc] = barcode [bib] = Bib.ID</TD>
</TR>

<TR bgcolor=ffffff>
<TD align=center colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
</TR>

</FORM>
</TABLE>
<?php 
$bcgenmode="qrcode";
include("cfg._getexamples.php");
?>