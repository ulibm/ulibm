<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="serialsmodule-rectype";
mn_lib();
$tbname="serials_rectype";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="รายชื่อข้อความประเภท::l::Type names";
$c[3][field]="namelist";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]=",";

$c[4][text]="Inc.day::l::Inc.day";
$c[4][field]="inc_day";
$c[4][fieldtype]="number";
$c[4][descr]="";
$c[4][defval]="0";

$c[5][text]="Inc.month::l::Inc.month";
$c[5][field]="inc_mon";
$c[5][fieldtype]="number";
$c[5][descr]="";
$c[5][defval]="1";

$c[6][text]="Inc.year::l::Inc.year";
$c[6][field]="inc_yea";
$c[6][fieldtype]="number";
$c[6][descr]="";
$c[6][defval]="0";
/*
$c[7][text]="จัดกลุ่มตาม::l::Group by";
$c[7][field]="groupby";
$c[7][fieldtype]="list:month,year";
$c[7][descr]="";
$c[7][defval]="month";

$c[8][text]="ขนาดคอลัมน์ของกลุ่ม::l::Column Number per group";
$c[8][field]="groupsize";
$c[8][fieldtype]="number";
$c[8][descr]="";
$c[8][defval]="4";
*/
//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="รายชื่อข้อความประเภท::l::Type names";
$dsp[3][field]="namelist";
$dsp[3][width]="30%";

$dsp[4][text]="Inc.day::l::Inc.day";
$dsp[4][field]="inc_day";
$dsp[4][width]="10%";

$dsp[5][text]="Inc.month::l::Inc.month";
$dsp[5][field]="inc_mon";
$dsp[5][width]="10%";

$dsp[6][text]="Inc.year::l::Inc.year";
$dsp[6][field]="inc_yea";
$dsp[6][width]="10%";

$o[undelete][field]="isdev";
$o[undelete][value]="yes";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);


foot();
?>