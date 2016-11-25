<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="acqxls_faculty";
$tmp=mn_lib();
pagesection($tmp);

$tbname="acqn_faculty";

$c[2][text]="ชื่อคณะ หน่วยงาน::l::Faculty / Departments name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";


//dsp


$dsp[1][text]="ชื่อคณะ หน่วยงาน::l::Faculty / Departments name";
$dsp[1][field]="name";
$dsp[1][width]="70%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot(); 
?>