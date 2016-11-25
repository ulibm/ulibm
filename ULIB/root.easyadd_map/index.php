<?php  //พ
include("../inc/config.inc.php");
head();
mn_root("easyadd_map");

$tbname="easyadd_map";


$c[2][text]="Classid::l::Classid";
$c[2][field]="classid";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Name::l::Name";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Fid::l::Fid";
$c[4][field]="fid";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Tp::l::Tp";
$c[5][field]="tp";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="";

$c[8][text]="Maxlength";
$c[8][field]="maxlen";
$c[8][fieldtype]="number";
$c[8][descr]="";
$c[8][defval]="";

$c[7][text]="Focus::l::Focus";
$c[7][field]="focus";
$c[7][fieldtype]="list:yes,no";
$c[7][descr]="";
$c[7][defval]="";

//dsp


$dsp[2][text]="Classid::l::Classid";
$dsp[2][field]="classid";
$dsp[2][width]="30%";

$dsp[3][text]="Name::l::Name";
$dsp[3][field]="name";
$dsp[3][width]="30%";

$dsp[4][text]="Fid::l::Fid";
$dsp[4][field]="fid";
$dsp[4][width]="30%";

$dsp[5][text]="Tp::l::Tp";
$dsp[5][field]="tp";
$dsp[5][width]="30%";

$dsp[7][text]="Focus::l::Focus";
$dsp[7][field]="focus";
$dsp[7][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?>