<?php  //พ
include("../inc/config.inc.php");
head();
mn_root("librarymenu");

$tbname="library_modules_cate";

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

$c[4][text]="Url::l::Url";
$c[4][field]="url";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Isplayathead::l::Isplayathead";
$c[5][field]="isplayathead";
$c[5][fieldtype]="list:yes,no";
$c[5][descr]="";
$c[5][defval]="yes";

$c[6][text]="topcate";
$c[6][field]="topcate";
$c[6][fieldtype]="foreign:-localdb-,library_modules_topcate,code,name";
$c[6][descr]="";
$c[6][defval]="";

//dsp


$dsp[2][text]="Code::l::Code";
$dsp[2][field]="code";
$dsp[2][width]="30%";

$dsp[3][text]="Name::l::Name";
$dsp[3][field]="name";
$dsp[3][width]="30%";

$dsp[7][text]="Edit::l::Edit";
$dsp[7][field]="name";
$dsp[7][align]="center";
$dsp[7][filter]="linkout:./sub.php?main=[value-code]";
$dsp[7][width]="10%";

$dsp[4][text]="Url::l::Url";
$dsp[4][field]="url";
$dsp[4][width]="30%";

$dsp[5][text]="Isplayathead::l::Isplayathead";
$dsp[5][field]="isplayathead";
$dsp[5][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"id");

foot();
?>