<?php 
include("../inc/config.inc.php");
head();
$tmp=mn_root("entermodule");
pagesection($tmp);

$tbname="library_entermodule";



//dsp

html_dialog("Information","Module logs for : ".get_library_name($ID));


$dsp[5][text]="Date";
$dsp[5][field]="dt";
$dsp[5][filter]="datetime";
$dsp[5][width]="50%";

$dsp[6][text]="Module";
$dsp[6][field]="descr";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_module";//"linkout:./permission.php?ID=[value-UserAdminID]";
$dsp[6][width]="50%";
function local_module($wh) {
	//printr($wh);
	$s=tmq("select * from library_modules where code='$wh[module]' ");
	$s=tfa($s);
	$s=getlang($s[name]);
	return $s;
}

fixform_tablelister($tbname," loginid='$ID' ",$dsp,"no","no","no","ID=$ID",$c,"id desc");
?><b><center><a href="index.php" class=a_btn><?php echo getlang("กลับ::l::Back");?></a></center></b><?php 
foot();
?>