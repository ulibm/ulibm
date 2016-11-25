<?php  //พ
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

$tbname="blockbarcode_tp";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Date create";
$c[3][field]="dt";
$c[3][fieldtype]="addcontrol";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="data";
$c[4][field]="data";
$c[4][fieldtype]="addcontrol";
$c[4][descr]="";
$c[4][defval]="";


//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="Date Created";
$dsp[3][filter]="date";
$dsp[3][field]="dt";
$dsp[3][width]="30%";

$dsp[4][text]="Librarian";
$dsp[4][field]="loginid";
$dsp[4][filter]="module:localmemname";
$dsp[4][width]="30%";

function localmemname($wh) {
	return get_library_name($wh[loginid]);
}

fixform_tablelister($tbname," 1 ",$dsp,"no","yes","yes","mi=$mi",$c);
?><center><a href="index.php" class=a_btn><b>Back</b></a></center><?php 
foot();
?>