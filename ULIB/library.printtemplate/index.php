<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="printtemplate";
$tmp=mn_lib();
pagesection($tmp);

$tbname="printtemplate";


$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";


//dsp


//$dsp[1][text]="รหัส::l::Code";
//$dsp[1][field]="code";
//$dsp[1][width]="20%";

$dsp[2][text]="ชื่อ::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";


$dsp[4][text]="จัดการ::l::Manage";
$dsp[4][align]="center";
$dsp[4][field]="name";
$dsp[4][filter]="module:local_man";
$dsp[4][width]="30%";
function local_man($wh) {
	$remains=tmq("select count(id) as cc from printtemplate_sub where pid='$wh[code]' ",false);
	$remains=tfa($remains);
	$remains=$remains[cc];
	$s= "<a href=\"sub.php?pid=$wh[code]\"><font >".getlang("จัดการ::l::Manage")." (".number_format($remains).")</font></a>";
	return $s;
}
/*
$dsp[5][text]="ยังใช้งาน::l::is active?";
$dsp[5][field]="isactive";
$dsp[5][filter]="switchsingle";
$dsp[5][width]="10%";
*/


fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"",$o);
?>
<center><BR><BR>
<?php 
html_dialog("","หากต้องการแทนที่เทมเพลทปัจจุบันทั้งหมด ด้วยเทมเพลทมาตรฐานจากเซิร์ฟเวอร์กลาง สารมารถคลิกได้ที่ลิงค์ด้านล่าง::l::If you want to replace all current template with template from ULibM server, click link below");
?>
<a href="../_addons/dbmorph/index.php?autoload=printtemplate" class='smaller a_btn'><?php echo getlang("อัพเดทเทมเพลทจาก ULibM เซิร์ฟเวอร์::l::Update templace from ULibM server");?></a>
</center>
<?php
foot(); 
?>