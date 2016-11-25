<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

$tbname="ms_annouce";


$c[3][text]="ข้อความ::l::Text";
$c[3][field]="text";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="แสดงหรือไม่::l::Is Show";
$c[4][field]="isshow";
$c[4][fieldtype]="list:YES,NO";
$c[4][descr]="";
$c[4][defval]="YES";

$c[5][text]="สีตัวอักษร::l::TextColor";
$c[5][field]="col";
$c[5][fieldtype]="color";
$c[5][descr]="";
$c[5][defval]="#000000";

$c[6][text]="สีพื้นหลัง::l::BackgroundColor";
$c[6][field]="bgcol";
$c[6][fieldtype]="color";
$c[6][descr]="";
$c[6][defval]="#FFFFFF";

$c[7][text]="แสดงเป็นลำดับที่::l::Order";
$c[7][field]="ordr";
$c[7][fieldtype]="number";
$c[7][descr]="";
$c[7][defval]="0";

//dsp


$dsp[3][text]="ข้อความ::l::Text";
$dsp[3][field]="text";
$dsp[3][width]="50%";

$dsp[4][text]="แสดงหรือไม่::l::Is Show";
$dsp[4][field]="isshow";
$dsp[4][width]="10%";

$dsp[5][text]="สีตัวอักษร::l::TextColor";
$dsp[5][filter]="color";
$dsp[5][field]="col";
$dsp[5][width]="15%";

$dsp[6][text]="สีพื้นหลัง::l::BackgroundColor";
$dsp[6][field]="bgcol";
$dsp[6][filter]="color";
$dsp[6][width]="15%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?>