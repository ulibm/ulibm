<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="libsitebibrule";
$tmp=mn_lib();

pagesection($tmp);

$tbname="library_site";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[4][text]="Isdef::l::Isdef";
$c[4][field]="isdef";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="no";

//dsp


$dsp[2][text]="ชื่อสาขาห้องสมุด::l::Campus name";
$dsp[2][field]="name";
$dsp[2][width]="30%";


$dsp[5][text]="แก้ไขกฏ::l::Edit rule";
$dsp[5][field]="isdef";
$dsp[5][align]="center";
$dsp[5][filter]="linkout:./permission.php?libsite=[value-code]";
$dsp[5][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c);

foot();
?>