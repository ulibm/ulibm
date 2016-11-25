<?php  //พ
;
include("../../inc/config.inc.php");
include("./_REQPERM.php");
head();

$tbname="rqroom_timetbi";


$c[2][text]="Maintb::l::Maintb";
$c[2][field]="maintb";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="0";

$c[3][text]="Keyid::l::Keyid";
$c[3][field]="keyid";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Period::l::Period";
$c[4][field]="period";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="0";

$c[5][text]="Loginid::l::Loginid";
$c[5][field]="loginid";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="";

//dsp


$dsp[2][text]="Maintb::l::Maintb";
$dsp[2][field]="maintb";
$dsp[2][width]="30%";

$dsp[3][text]="Keyid::l::Keyid";
$dsp[3][field]="keyid";
$dsp[3][width]="30%";

$dsp[4][text]="Period::l::Period";
$dsp[4][field]="period";
$dsp[4][width]="30%";

$dsp[5][text]="Loginid::l::Loginid";
$dsp[5][field]="loginid";
$dsp[5][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);



foot();
?>