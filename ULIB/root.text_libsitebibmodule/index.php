<?php  //พ
include("../inc/config.inc.php");
head();
mn_root("text_libsitebibmodule");

$tbname="libsite_bibmodules";


$c[2][text]="Code::l::Code";
$c[2][field]="code";
$c[2][fieldtype]="readonlytext";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Name::l::Name";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

//dsp


$dsp[2][text]="Code::l::Code";
$dsp[2][field]="code";
$dsp[2][width]="30%";

$dsp[3][text]="Name::l::Name";
$dsp[3][field]="name";
$dsp[3][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"no","yes","no","mi=$mi",$c);

foot();
?>