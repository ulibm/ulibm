<?php 
include("../inc/config.inc.php");
head();
$tmp=mn_root("backup");
pagesection($tmp);

$tbname="backup_log";



//dsp


$dsp[1][text]="Date";
$dsp[1][field]="dt";
$dsp[1][filter]="datetime";
$dsp[1][width]="20%";

$dsp[2][text]="Type";
$dsp[2][field]="type1";
$dsp[2][width]="10%";

$dsp[3][text]="Admin";
$dsp[3][field]="id";
$dsp[3][filter]="module:local_adminname";
$dsp[3][width]="20%";
function local_adminname($wh) {
	$s=tmq("select * from useradmin where UserAdminID='$wh[useradmin]' ");
	$s=tfa($s);
	return $s[UserAdminName]." ($wh[useradmin])";
}

$dsp[4][text]="Filename";
$dsp[4][field]="filename";
$dsp[4][filter]="module:local_filename";
$dsp[4][width]="40%";

function local_filename($wh) {
	$s="<a href=\"get.php?filename=".base64_encode($wh[filename])."\">$wh[filename]</a><br>" . getlang("คลิกขวา เลือก Save Target As..::l::Right click and select Save Target As...");;
	return $s;
}
fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c," dt desc ",$o);

foot(); 
?>