<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="itemplace";
mn_lib();
$tbname="media_place_defformattype";
pagesection(getlang("จัดการสถานที่เริ่มต้น::l::Manage default place").":".get_itemplace_name($main));

$c[2][text]="Nested::l::Nested";
$c[2][field]="placecode";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$main;

$c[4][text]="เมื่ออยู่ที่สาขา::l::On campus";
$c[4][field]="libsite";
$c[4][fieldtype]="foreign:-localdb-,library_site,code,name,noblank";
$c[4][descr]="";
$c[4][defval]=$main;

$c[3][text]="ประเภทวัสดุ::l::Resource Type";
$c[3][field]="mediatypecode";
$c[3][fieldtype]="foreign:-localdb-,media_type,code,name,noblank";
$c[3][descr]="";
$c[3][defval]="";

//dsp

$dsp[4][text]="เมื่ออยู่ที่สาขา::l::On campus";
$dsp[4][field]="name";
$dsp[4][filter]="module:local_libsite";
$dsp[4][width]="40%";
function local_libsite($wh) {
	return get_libsite_name($wh[libsite]);
}

$dsp[3][text]="ประเภทวัสดุ::l::Resource Type";
$dsp[3][field]="name";
$dsp[3][filter]="module:local_name";
$dsp[3][width]="30%";
function local_name($wh) {
	return get_media_type($wh[mediatypecode]);
}

$o[addlink][] = "index.php::".getlang("กลับ::l::Back");;


//print_r($_POST);
if ($ffe_issave=="yes") {
	if ($ffdat[mediatypecode]=="") {
		$ffe_issave=""; // not save blank
	} else {
		tmq("delete from $tbname where mediatypecode='$ffdat[mediatypecode]' and libsite='$ffdat[libsite]' ");
	}
}
fixform_tablelister($tbname," placecode='$main' ",$dsp,"yes","no","yes","main=$main",$c,"",$o);

foot();
?>