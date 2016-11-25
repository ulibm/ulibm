<?php  //พ
include("../inc/config.inc.php");
	 head();
	 $_REQPERM="filesonserver";
	 mn_lib();
$tbname="filesonserver";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Path::l::Path";
$c[3][field]="path";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Url::l::Url";
$c[4][field]="url";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="Path::l::Path";
$dsp[3][field]="path";
$dsp[3][width]="30%";

$dsp[4][text]="Url::l::Url";
$dsp[4][field]="url";
$dsp[4][width]="30%";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mid=$mid",$c);


foot();
?>