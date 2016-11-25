<?php 
include("../inc/config.inc.php");
head();
mn_root("userlibrary");

$tbname="library_modules_templatename";


$c[2][text]="Code::l::Code";
$c[2][field]="code";
$c[2][fieldtype]="text";
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
$dsp[2][width]="20%";

$dsp[3][text]="Name::l::Name";
$dsp[3][field]="name";
$dsp[3][width]="30%";

$dsp[6][text]="การอนุญาต::l::Permission";
$dsp[6][field]="descr";
$dsp[6][align]="center";
$dsp[6][filter]="linkout:./template_permission.php?ID=[value-code]";
$dsp[6][width]="20%";

$o[addlink][] = "index.php::".getlang("กลับระบบจัดการรายชื่อเจ้าหน้าที่ห้องสมุด::l::Back to Librarian's login management")."::";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot();
?>