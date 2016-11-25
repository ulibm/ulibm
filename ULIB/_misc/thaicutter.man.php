<?php 
include("../inc/config.inc.php");
html_start();
$tbname="keyhelp_thauthname";


$c[2][text]="ค้นหา::l::Search";
$c[2][field]="search1";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="แทนที่ด้วย::l::replace with";
$c[3][field]="replace1";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="เรียงลำดับ::l::Order";
$c[4][field]="ordr";
$c[4][fieldtype]="number";
$c[4][descr]="";
$c[4][defval]="";

$c[2][text]="ค้นหา::l::Search";
$c[2][field]="search1";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$dsp[2][text]="ค้นหา::l::Search";
$dsp[2][field]="search1";
$dsp[2][align]="center";
$dsp[2][width]="30%";
$dsp[2][filter]="";

$dsp[3][text]="แทนที่ด้วย::l::replace with";
$dsp[3][field]="replace1";
$dsp[3][width]="30%";

$dsp[4][text]="เรียงลำดับ::l::Order";
$dsp[4][field]="ordr";
$dsp[4][width]="10%";


	$limit=" 1  ";

$o[tablewidth]="100%";

fixform_tablelister($tbname," $limit  ",$dsp,"yes","yes","yes","parentjsid=$parentjsid&class1=$class1&class2=$class2&class3=$class3",$c," ordr",$o);
?>