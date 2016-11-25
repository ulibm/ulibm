<?php 
include("../inc/config.inc.php");
html_start();

include("_REQPERM.php");
loginchk_lib("check");

$tbname="blockbarcode_singlecolor";

pagesection($tmp);

$c[1][text]="ข้อความที่ตรวจสอบ::l::Code";
$c[1][field]="prefix";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="ข้อความที่จะแสดงหากเจอข้อความที่ตรวจสอบ";
$c[2][defval]="";


//dsp

$dsp[7][text]="Icon";
$dsp[7][field]="id";
$dsp[7][width]="5%";
$dsp[7][filter]="module:local_upload";

$dsp[3][text]="ข้อความที่ตรวจสอบ::l::Code";
$dsp[3][field]="prefix";
$dsp[3][width]="20%";

$dsp[2][text]="ชื่อ::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="40%";


function local_upload($wh) {
	global $dcrs;
	global $dcrURL;
	$s="<A HREF='cfg.singlecolor.upload.php?mediatypemanage=$wh[id]'><img border=0 width=48 height=48 src='";
	if (file_exists("$dcrs/_tmp/bcsinglecolor/$wh[id].jpg")==true) {
		$s.= "$dcrURL/_tmp/bcsinglecolor/$wh[id].jpg";
	} else {
		$s.=  "$dcrURL/_tmp/bcsinglecolor.png";
	}
	$s.="'></A>";
	return $s;
	//
}

/*
$o[unedit][field]="delable";
$o[unedit][value]="NO";
*/

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);
?><CENTER><?php  echo getlang("คลิกที่ไอคอนเพื่ออัพโหลดภาพใหม่::l::Click on icon to upload new icon.");?> : <a href="cfg.singlecolor.php"><?php  echo getlang("กลับ::l::Back");?></a></CENTER><?php 
foot();
?>