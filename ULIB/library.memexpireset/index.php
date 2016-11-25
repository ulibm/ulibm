<?php 
include("../inc/config.inc.php");
head();
	$_REQPERM="memexpireset";
	$tmp=mn_lib();
	pagesection($tmp);

$tbname="member_expireset";


$c[2][text]="ชื่อวันหมดอายุ::l::Template name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[20][text]="วันเดือนปี::l::Date";
$c[20][field]="dt";
$c[20][fieldtype]="date";
$c[20][descr]="";
$c[20][defval]="";

//dsp


$dsp[2][text]="ชื่อวันหมดอายุ::l::Template name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="วันเดือนปี::l::Date";
$dsp[3][field]="dt";
$dsp[3][filter]="date";
$dsp[3][width]="30%";



fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);


foot();
?>