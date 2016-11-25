<?php  //พ
include("../inc/config.inc.php");
head();
	$_REQPERM="indexword";
	$tmp=mn_lib();
pagesection($tmp);
$tbname="indexword";


$c[2][text]="Word1::l::Word1";
$c[2][field]="word1";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="off";

/*$c[3][text]="Usoundex::l::Usoundex";
$c[3][field]="usoundex";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";
*/

/*$c[4][text]="Mid::l::Mid";
$c[4][field]="mid";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="-1";
*/

/*$c[5][text]="Importdt::l::Importdt";
$c[5][field]="importdt";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="0";

$c[6][text]="Importid::l::Importid";
$c[6][field]="importid";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";
*/
//dsp


$dsp[2][text]="Word1::l::Word1";
$dsp[2][field]="word1";
$dsp[2][width]="30%";

$dsp[3][text]="Usoundex::l::Usoundex";
$dsp[3][field]="usoundex";
$dsp[3][width]="30%";



fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?>