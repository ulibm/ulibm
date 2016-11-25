<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="cookielogin";
$tmp=mn_lib();
pagesection("จัดการล็อกอินอัตโนมัติ::l::Manage auto login clients");

$tbname="library_cookielogin";




//dsp

/*
$dsp[1][text]="รหัส::l::Code";
$dsp[1][field]="type";
$dsp[1][width]="20%";*/
$dsp[1][text]="ชื่อเครื่อง::l::computer name";
$dsp[1][field]="pcname";
$dsp[1][width]="20%";

$dsp[2][text]="วันที่เพิ่มข้อมูล::l::Date added";
$dsp[2][filter]="module:local_dt";
$dsp[2][field]="descr";
$dsp[2][width]="30%";
function local_dt($wh) {
	global $_COOKIE;
	$libraryautologincookie=trim($_COOKIE[LIBAUTHC]);
	if($wh[dat]==$libraryautologincookie) {
		$thispc=" <b>(".getlang("เครื่องปัจจุบัน::l::This PC").")</b>";
	}
	//print_r($wh);
	return ymd_datestr($wh[dt])." $thispc <font class=smaller>(".ymd_ago($wh[dt]).")</font>";
}

fixform_tablelister($tbname," 1 ",$dsp,"no","no","yes","mi=$mi",$c,"",$o);

foot(); 
?>