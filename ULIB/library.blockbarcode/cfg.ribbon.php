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
	barcodeval_set("BARCODE-blockbc-ribbon-callntag",addslashes($callntag));
	barcodeval_set("BARCODE-blockbc-ribbon-addtextsize",addslashes($addtextsize));
	barcodeval_set("BARCODE-blockbc-ribbon-addtext",addslashes($addtext));

	barcodeval_set("BARCODE-blockbc-ribbon-showtitle",addslashes($showtitle));
	barcodeval_set("BARCODE-blockbc-ribbon-showtitlesize",addslashes($showtitlesize));
	barcodeval_set("BARCODE-blockbc-ribbon-groupchar",addslashes($groupchar));
	barcodeval_set("BARCODE-blockbc-ribbon-addstrokeline",addslashes($addstrokeline));
	barcodeval_set("BARCODE-blockbc-ribbon-yearedition",addslashes($yearedition));
	barcodeval_set("BARCODE-blockbc-ribbon-includebarcode",addslashes($includebarcode));
	$s=tmq("select * from keyhelp_callngenner where prefix<>'' order by name");
	//printr($_POST);
	while ($r=tmq_fetch_array($s)) {
		barcodeval_set("BARCODE-blockbc-ribbon-colorof[$r[prefix]]",$_POST["colorof"]["$r[prefix]"]); 
	}
	$s=explode(',',$_STR_A_Z.",0,1,2,3,4,5,6,7,8,9");
	while (list($k,$v)=each($s)) {
		barcodeval_set("BARCODE-blockbc-ribbon-colorofchar[$v]",$_POST["colorofchar"]["$v"]); 
	}
}
$tbmn="width=1000  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();
?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="<?php  echo $PHPSELF;?>"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("แท็กที่เก็บเลขเรียก::l::Tag for Call Number"); ?></TD>
<TD><?php 
form_quickedit("callntag",barcodeval_get("BARCODE-blockbc-ribbon-callntag"),"list:auto,tag050,tag060,tag082,tag090,tag098,tag099"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("จับกลุ่มตัวอักษรกลุ่มแรกแยกจากตัวเลข::l::Grouping fir characters from digits"); ?></TD>
<TD><?php 
form_quickedit("groupchar",barcodeval_get("BARCODE-blockbc-ribbon-groupchar"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงบาร์โค้ดด้วย::l::Include barcode"); ?></TD>
<TD><?php 
form_quickedit("includebarcode",barcodeval_get("BARCODE-blockbc-ribbon-includebarcode"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงชื่อเรื่อง::l::Show title"); ?></TD>
<TD><?php 
form_quickedit("showtitle",barcodeval_get("BARCODE-blockbc-ribbon-showtitle"),"yesno"); 
?>
 size  <input type="number" name="showtitlesize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-ribbon-showtitlesize")); ?>">
</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงครั้งที่พิมพ์และปีพิมพ์::l::Include Year and Edition"); ?></TD>
<TD><?php 
form_quickedit("yearedition",barcodeval_get("BARCODE-blockbc-ribbon-yearedition"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ขีดเส้นรอบตัวอักษร::l::Add stroke to callnumber"); ?></TD>
<TD><?php 
form_quickedit("addstrokeline",barcodeval_get("BARCODE-blockbc-ribbon-addstrokeline"),"yesno"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติม::l::Add text"); ?></TD>
<TD><?php 
form_quickedit("addtext",barcodeval_get("BARCODE-blockbc-ribbon-addtext"),"text"); 
?>
 size  <input type="number" name="addtextsize" min="-10" step=1 max="10" value="<?php echo floor(barcodeval_get("BARCODE-blockbc-ribbon-addtextsize")); ?>">

<BR>[bc] = barcode [bib] = Bib.ID</TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("สีประจำประเภทเลขหมู่::l::Color of Call Number collection"); ?></TD>
<TD><?php 
$s=tmq("select * from keyhelp_callngenner where prefix<>'' order by name");
while ($r=tmq_fetch_array($s)) {
	echo "<B>".getlang($r[name]) ."</B> <FONT class=smaller2>($r[prefix])</FONT> ";
	echo getlang("ใช้สี::l::use color")." ";
	form_quickedit("colorof[$r[prefix]]",barcodeval_get("BARCODE-blockbc-ribbon-colorof[$r[prefix]]"),"color"); 
	?><BR><?php 
}
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("สีประจำตัวอักษร::l::Color of Charactors"); ?></TD>
<TD><?php 
$s=explode(',',$_STR_A_Z.",0,1,2,3,4,5,6,7,8,9");
$i=0;
while (list($k,$v)=each($s)) {
	$i++;
	echo " &nbsp; &nbsp; <B style='font-family:monospace;'>".strtoupper($v)."</B> ";
	echo getlang("ใช้สี::l::use color")." ";
	form_quickedit("colorofchar[$v]",barcodeval_get("BARCODE-blockbc-ribbon-colorofchar[$v]"),"color"); 
	//echo "[".barcodeval_get("BARCODE-blockbc-ribbon-colorofchar[$v]")."]";
	if ($i % 3 ==0) {
		?><BR><?php 
	}
}
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD align=center colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
</TR>

</FORM>
</TABLE>
<?php 
$bcgenmode="ribbon";
include("cfg._getexamples.php");
?>