<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="librarycampus";
$tmp=mn_lib();

pagesection($tmp);

$tbname="library_site";


$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";
$c[1][unediton]="code,main";

$c[2][text]="ชื่อห้องสมุด::l::Campus name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[4][text]="เป็นสาขาหลักหรือไม่::l::Is default campus";
$c[4][field]="isdef";
$c[4][fieldtype]="switchsingle";
$c[4][descr]="";
$c[4][defval]="no";

//dsp


$dsp[2][text]="ชื่อห้องสมุด::l::Campus name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[4][text]="เป็นสาขาหลักหรือไม่::l::Is default campus";
$dsp[4][field]="isdef";
$dsp[4][filter]="switchsingle";
$dsp[4][width]="30%";

$o[undelete][field]="code";
$o[undelete][value]="main";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot();
?>