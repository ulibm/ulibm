<?php 
include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

$tbname="bannedwords";


$c[2][text]="Banned Word";
$c[2][field]="word1";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="แทนที่ด้วยคำ::l::Replace with";
$c[3][field]="word2";
$c[3][fieldtype]="text";
$c[3][descr]=getlang("ไม่ต้องใส่ก็ได้::l::can be blank");
$c[3][defval]="";

$c[4][text]="ลำดับความสำคัญ::l::Priority";
$c[4][field]="priority1";
$c[4][fieldtype]="number";
$c[4][descr]="";
$c[4][defval]="10";

//dsp


$dsp[2][text]="Banned Word";
$dsp[2][field]="word1";
$dsp[2][width]="30%";

$dsp[3][text]="แทนที่ด้วยคำ::l::Replace with";
$dsp[3][field]="word2";
$dsp[3][width]="30%";

$dsp[1][text]="-";
$dsp[1][field]="priority1";
$dsp[1][width]="10%";

?><CENTER><?php  
echo getlang("การแบนคำต้องห้ามเหล่านี้ จะถูกใช้กับระบบเว็บบอร์ดและการคอมเมนท์ทรัพยากร::l::These banned words will affect to webboard and book comments.");
?></CENTER><?php 

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"priority1");

foot();
?>