<?php  //พ
include("../inc/config.inc.php");
head();
mn_root("text_librarianmodule");

$tbname="libsite_modules";


$c[1][text]="Code::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="readonlytext";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

//dsp


$dsp[1][text]="Code::l::Code";
$dsp[1][field]="code";
$dsp[1][width]="30%";

$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"no","yes","no","mi=$mi",$c);

foot();
?>