<?php  //พ
include("../inc/config.inc.php");
head();
	$_REQPERM="usoundex_map";
	$tmp=mn_lib();
	pagesection($tmp);

$tbname="usoundex";


$c[2][text]="Search::l::Search";
$c[2][field]="search1";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Replace::l::Replace";
$c[3][field]="replace1";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Order";
$c[4][field]="ordr";
$c[4][fieldtype]="number";
$c[4][descr]="";
$c[4][defval]="";

//dsp


$dsp[2][text]="Search::l::Search";
$dsp[2][field]="search1";
$dsp[2][width]="30%";

$dsp[3][text]="Replace::l::Replace";
$dsp[3][field]="replace1";
$dsp[3][width]="30%";

$dsp[4][text]="Order";
$dsp[4][field]="ordr";
$dsp[4][width]="10%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"ordr");

foot();
?>
