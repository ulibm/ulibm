<?php  //พ
include("../inc/config.inc.php");
head();
mn_root("libmann");

$tbname="library_modules_cate";


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
$dsp[7][filter]="module:locallink";
$dsp[7][width]="10%";
function locallink($wh) {
	return "<a href='sub.php?main=$wh[code]'>Edit</a>";
}

$dsp[4][text]="Url::l::Url";
$dsp[4][field]="url";
$dsp[4][width]="30%";

$dsp[5][text]="Isplayathead::l::Isplayathead";
$dsp[5][field]="isplayathead";
$dsp[5][width]="30%";

?><center><b><a href="freecate.php" class=a_btn>Not related to menu</a></b></center><?php 

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"id");

foot();
?>