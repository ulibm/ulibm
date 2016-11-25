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
	barcodeval_set("BARCODE-blockbc-singlecolor-callnformat",addslashes($callnformat));

	barcodeval_set("BARCODE-blockbc-singlecolor-callntag",addslashes($callntag));
	barcodeval_set("BARCODE-blockbc-singlecolor-addtext",addslashes($addtext));
	barcodeval_set("BARCODE-blockbc-singlecolor-isshowtitle",addslashes($isshowtitle));
	barcodeval_set("BARCODE-blockbc-singlecolor-fontsize1",addslashes($fontsize1));
	barcodeval_set("BARCODE-blockbc-singlecolor-fontsize2",addslashes($fontsize2));
	barcodeval_set("BARCODE-blockbc-singlecolor-fontsizebc",addslashes($fontsizebc));
	barcodeval_set("BARCODE-blockbc-singlecolor-linespace",addslashes($linespace));
	barcodeval_set("BARCODE-blockbc-singlecolor-ctrltop",addslashes($ctrltop));
	barcodeval_set("BARCODE-blockbc-singlecolor-ctrlleft",addslashes($ctrlleft));
	barcodeval_set("BARCODE-blockbc-singlecolor-ctrltop2",addslashes($ctrltop2));
	barcodeval_set("BARCODE-blockbc-singlecolor-ctrlleft2",addslashes($ctrlleft2));
	barcodeval_set("BARCODE-blockbc-singlecolor-fontsize1isb",addslashes($fontsize1isb));
	barcodeval_set("BARCODE-blockbc-singlecolor-fontsize2isb",addslashes($fontsize2isb));
	barcodeval_set("BARCODE-blockbc-singlecolor-fontsizebcisb",addslashes($fontsizebcisb));
	//printr($_POST);
}
$tbmn="width=1000  cellpadding=2 cellspacing=1 align=center bgcolor=888888";
html_htmlareajs();


?>
<BR>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF;?>"  enctype="multipart/form-data">
<INPUT TYPE="hidden" name=save value=yes>

<TR bgcolor=ffffff>
<TD><?php  echo getlang("แท็กที่เก็บเลขเรียก::l::Tag for Call Number"); ?></TD>
<TD><?php 
form_quickedit("callntag",barcodeval_get("BARCODE-blockbc-singlecolor-callntag"),"list:auto,tag050,tag060,tag082,tag090,tag098,tag099"); 
?> </TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("รูปแบบเลขเรียก::l::Call Number format"); ?></TD>
<TD><?php 
form_quickedit("callnformat",barcodeval_get("BARCODE-blockbc-singlecolor-callnformat"),"list:DC,LC,by_subfield"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("แสดงชื่อเรื่อง::l::Show title"); ?></TD>
<TD><?php 
form_quickedit("isshowtitle",barcodeval_get("BARCODE-blockbc-singlecolor-isshowtitle"),"list:yes,no"); 
?></TD>
</TR>
<TR bgcolor=ffffff><TD><?php  echo getlang("Font size 1"); ?></TD>
<TD><?php 
form_quickedit("fontsize1",barcodeval_get("BARCODE-blockbc-singlecolor-fontsize1"),"number"); 
echo " " . getlang("ตัวหนา::l::Bold")."";
form_quickedit("fontsize1isb",barcodeval_get("BARCODE-blockbc-singlecolor-fontsize1isb"),"yesno"); 
?> </TD>
</TR>
<TR bgcolor=ffffff><TD><?php  echo getlang("Font size 2"); ?></TD>
<TD><?php 
form_quickedit("fontsize2",barcodeval_get("BARCODE-blockbc-singlecolor-fontsize2"),"number"); 
echo " " . getlang("ตัวหนา::l::Bold")."";
form_quickedit("fontsize2isb",barcodeval_get("BARCODE-blockbc-singlecolor-fontsize2isb"),"yesno"); 

?> </TD>
</TR>
<TR bgcolor=ffffff><TD><?php  echo getlang("Line Spacing"); ?></TD>
<TD><?php 
form_quickedit("linespace",barcodeval_get("BARCODE-blockbc-singlecolor-linespace"),"number"); 
?> </TD>
</TR><TR bgcolor=ffffff><TD><?php  echo getlang("Font size Barcode"); ?></TD>
<TD><?php 
form_quickedit("fontsizebc",barcodeval_get("BARCODE-blockbc-singlecolor-fontsizebc"),"number"); 
echo " " . getlang("ตัวหนา::l::Bold")."";
form_quickedit("fontsizebcisb",barcodeval_get("BARCODE-blockbc-singlecolor-fontsizebcisb"),"yesno"); 

?> </TD>
</TR>
<TR bgcolor=ffffff><TD><?php  echo getlang("Head Start"); ?></TD>
<TD>Top:<?php 
form_quickedit("ctrltop",barcodeval_get("BARCODE-blockbc-singlecolor-ctrltop"),"number"); 
?> x Left:<?php 
form_quickedit("ctrlleft",barcodeval_get("BARCODE-blockbc-singlecolor-ctrlleft"),"number"); 
?> </TD>
</TR>
<TR bgcolor=ffffff><TD><?php  echo getlang("Rows Start"); ?></TD>
<TD>Top:<?php 
form_quickedit("ctrltop2",barcodeval_get("BARCODE-blockbc-singlecolor-ctrltop2"),"number"); 
?> x Left:<?php 
form_quickedit("ctrlleft2",barcodeval_get("BARCODE-blockbc-singlecolor-ctrlleft2"),"number"); 
?> </TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ข้อความเพิ่มเติม::l::Add text"); ?></TD>
<TD><?php 
form_quickedit("addtext",barcodeval_get("BARCODE-blockbc-singlecolor-addtext"),"text"); 
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD><?php  echo getlang("ภาพพื้นหลัง::l::Background Image"); ?></TD>
<TD><?php 
$s=tmq("select * from blockbarcode_singlecolor where prefix<>'' order by name");
while ($r=tmq_fetch_array($s)) {
	echo "<img width=20 height=20 src='$dcrURL"."_tmp/bcsinglecolor/$r[id].jpg'> <B '> ".getlang($r[name]) ."</B> <FONT class=smaller2>($r[prefix])</FONT> ";
	?><BR><?php 
}
	echo "<a href='cfg.singlecolor.set.php' class=a_btn>";
echo getlang("ตั้งค่าหมวดหมู่และภาพพื้นหลัง::l::CallNumber and Settings");
echo "</a>";
?></TD>
</TR>

<TR bgcolor=ffffff>
<TD align=center colspan=2><INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>"></TD>
</TR>

</FORM>
</TABLE>
<?php 
$bcgenmode="singlecolor";
include("cfg._getexamples.php");
?>