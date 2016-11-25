<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="oss-pickuptype";
mn_lib();

pagesection(getlang("รูปแบบการรับเอกสาร::l::Pickup Type"));

$tbname="oss_pickuptype";


$c[2][text]="Code";
$c[2][field]="classid";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ชื่อ (ข้อความ)::l::Name (Place name)";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ข้อความเพิ่มเติมสำหรับผู้ใช้::l::Description for users";
$c[4][field]="userdescr";
$c[4][fieldtype]="longtext";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="เรียงลำดับ::l::Ordering";
$c[5][field]="ordr";
$c[5][fieldtype]="number";
$c[5][descr]="";
$c[5][defval]="0";

//dsp


$dsp[2][text]="ชื่อ (ข้อความ)::l::Name (Place name)";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="Code";
$dsp[3][field]="classid";
$dsp[3][width]="30%";

$dsp[1][text]="-";
$dsp[1][field]="ordr";
$dsp[1][width]="10%";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"ordr");
?><CENTER><a href="index.php" class=a_btn><?php  
echo getlang("กลับ::l::Back");
?></a></CENTER><?php 

foot();
?>