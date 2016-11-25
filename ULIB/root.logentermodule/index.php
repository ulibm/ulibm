<?php 
include("../inc/config.inc.php");
head();
$tmp=mn_root("logentermodule");
pagesection($tmp);

$tbname="library";

if ($view!="") {
$tbname="library_entermodule";
   
   
$dsp[2][text]="Date";
$dsp[2][field]="dt";
$dsp[2][filter]="module:localdt";
$dsp[2][width]="30%";
function localdt($w) {
   return ymd_datestr($w[dt]). " <font class=smaller2>".ymd_ago($w[dt])."</font>";
}

$dsp[4][text]="ประจำห้องสมุดสาขา::l::On campus";
$dsp[4][field]="module";
$dsp[4][width]="50%";
$dsp[4][filter]="foreign:-localdb-,library_modules,code,name";
fixform_tablelister($tbname," loginid='$view' ",$dsp,"no","no","no","view=$view",$c,"dt desc",$o);
?><center><a href=index.php>Back</a></center><?php
foot();
die();

}

//dsp


$dsp[2][text]="รหัสล็อกอิน::l::Loginid";
$dsp[2][field]="UserAdminID";
$dsp[2][width]="15%";

$dsp[4][text]="ประจำห้องสมุดสาขา::l::On campus";
$dsp[4][field]="libsite";
$dsp[4][width]="25%";
$dsp[4][filter]="foreign:-localdb-,library_site,code,name";

$dsp[5][text]="ชื่อเจ้าหน้าที่::l::Librarian's Name";
$dsp[5][field]="UserAdminName";
$dsp[5][width]="20%";

$dsp[7][text]="อนุญาตให้ล็อกอิน::l::Allow to login";
$dsp[7][field]="isallowlogin";
$dsp[7][align]="center";
$dsp[7][width]="20%";
$dsp[7][filter]="module:local_yesno";
function local_yesno($wh) {
	//printr($wh);
	if ($wh[isallowlogin]=="YES") {
		$s="<B style='color:darkgreen'>Yes</B>";
	} else {
		$s="<B style='color:darkred'>-NO-</B>";
	}
	return $s;
}
$dsp[6][text]="Log";
$dsp[6][field]="descr";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_logs";//"linkout:./permission.php?ID=[value-UserAdminID]";
$dsp[6][width]="250%";
function local_logs($wh) {

	if ($wh[UserAdminID]=="automated_task") {
		//return "-";
	}
	$c=tmq("select count(id) as cc from library_entermodule where loginid='$wh[UserAdminID]' ");
	$cc=tfa($c);
	$ccc=number_format($cc[cc]);
	return "<a href='index.php?view=$wh[UserAdminID]'>View ($ccc)</a>";
}

//$o[undeletearr][type]="temp";
/*$o[unedit][field]="UserAdminID";
$o[unedit][value]="automated_task";
*/
fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"",$o);
tmq("delete from library_permission where lib not in (select UserAdminID from library)");

foot();
?>