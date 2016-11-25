<?php 
include("../inc/config.inc.php");
include("trap.admin.php");
html_start();

$tbname="docdelivery_doctype";

$c[2][text]="ประเภทเอกสาร::l::Document type";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="หมายเลขอัตโนมัติปัจจุบัน::l::Current Running Number";
$c[3][field]="running";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="เรียงลำดับ::l::Order";
$c[4][field]="ordr";
$c[4][fieldtype]="number";
$c[4][descr]="";
$c[4][defval]="";

//dsp


$dsp[1][text]="ประเภทเอกสาร::l::Document type";
$dsp[1][field]="name";
$dsp[1][width]="50%";

$dsp[2][text]="เรียงลำดับ::l::Order";
$dsp[2][field]="ordr";
$dsp[2][width]="30%";

$_TBWIDTH="100%";
fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"ordr",$o,"","");

?>