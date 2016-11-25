<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="acqxls_faculty";
$tmp=mn_lib();
pagesection($tmp);

$tbname="acqn_company";

$c[2][text]="ชื่อบริษัท::l::Company name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[7][text]="รายละเอียด::l::Description";
$c[7][field]="descr";
$c[7][fieldtype]="longtext";
$c[7][descr]="";
$c[7][defval]="";

$c[3][text]="ที่อยู่::l::Address";
$c[3][field]="address";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Email";
$c[4][field]="email";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Website";
$c[5][field]="website";
$c[5][fieldtype]="longtext";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="รายละเอียดเพื่อติดต่อ::l::Contact Info.";
$c[6][field]="contactinfo";
$c[6][fieldtype]="longtext";
$c[6][descr]="";
$c[6][defval]="";



//dsp


$dsp[1][text]="ชื่อบริษัท::l::Company name";
$dsp[1][field]="name";
$dsp[1][width]="40%";

$dsp[2][text]="รายละเอียด::l::Description";
$dsp[2][field]="name";
$dsp[2][width]="50%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot(); 
?>