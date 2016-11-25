<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="backdate_viewlog";
$tmp=mn_lib();
pagesection($tmp);

$tbname="backdate_log";


//dsp


$dsp[1][text]="เจ้าหน้าที่::l::Librarian";
$dsp[1][field]="type";
$dsp[1][filter]="module:locallib";
$dsp[1][width]="20%";
function locallib($wh) {
	return get_library_name($wh[loginid]);
}

$dsp[2][text]="ประเภท::l::Type";
$dsp[2][field]="type1";
$dsp[2][width]="10%";

$dsp[3][text]="สมาชิก::l::Member";
$dsp[3][field]="id";
$dsp[3][filter]="module:localmem";
$dsp[3][width]="20%";
function localmem($wh) {
	return get_member_name($wh[memberid]);
}

$dsp[5][text]="ทรัพยากร::l::Title";
$dsp[5][filter]="module:localbcode";
$dsp[5][field]="id";
$dsp[5][width]="20%";
function localbcode($wh) {
	$tmp=tmq("select * from media_mid where bcode='$wh[bcode]' ");
	$tmp=tfa($tmp);

	return "[$wh[bcode]]".res_brief_dsp($tmp[pid],true,true,false);//marc_gettitle($tmp[pid]);
}

$dsp[4][text]="รายละเอียด::l::Detail";
$dsp[4][field]="id";
$dsp[4][filter]="module:localdet";
$dsp[4][width]="30%";
function localdet($wh) {
	return getlang("จาก::l::From")." ".$wh[from1]."<br> " .getlang("เป็น::l::to")." ".$wh[to1]."<br><font class=smaller> ".ymd_datestr($wh[dt])."</font>";
}

fixform_tablelister($tbname," 1 ",$dsp,"no","no","yes","mi=$mi",$c,"id desc",$o);

foot(); 
?>