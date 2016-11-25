<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="mediatype";
$tmp=mn_lib();

$tbname="media_type";

pagesection($tmp);

$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";
$c[1][unediton]="delable,NO";

$c[2][text]="ชื่อประเภท::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ลบได้หรือไม่::l::Delable";
$c[3][field]="delable";
$c[3][fieldtype]="list:YES,NO";
$c[3][descr]="";
$c[3][defval]="YES";
//$c[3][unediton]="delable,NO";

$c[5][text]="ยืมวัสดุ Bib เดียวกันได้หลายรายการหรือไม่::l::Can checkout multi item in a Bib. ";
$c[5][field]="canduphold";
$c[5][fieldtype]="list:yes,no";
$c[5][descr]="";
$c[5][defval]="no";

$c[4][text]="ซ่อนไว้หรือไม่::l::Ishide";
$c[4][field]="ishide";
$c[4][fieldtype]="list:no,yes";
$c[4][descr]="ซ่อนวัสดุประเภทนี้ในระบบการสืบค้น::l::Hide this media type in searching module";
$c[4][defval]="no";

$c[6][text]="เป็นสื่อบันทึกข้อมูลแบบแม่เหล็กหรือไม่::l::Is magnetic type?";
$c[6][field]="ismagnetic";
$c[6][fieldtype]="list:YES,NO";
$c[6][descr]="";
$c[6][defval]="NO";

$c[7][text]="ข้อความสถานะในการแสดงผล::l::Display Status Text";
$c[7][field]="setstatusdsp";
$c[7][fieldtype]="text";
$c[7][descr]="";
$c[7][defval]="";
//dsp

$dsp[7][text]="Icon";
$dsp[7][field]="id";
$dsp[7][width]="5%";
$dsp[7][filter]="module:local_upload";

$dsp[3][text]="รหัส::l::Code";
$dsp[3][field]="code";
$dsp[3][width]="20%";

$dsp[2][text]="ชื่อประเภท::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="40%";

$dsp[4][text]="ซ่อนไว้หรือไม่::l::Ishide";
$dsp[4][field]="ishide";
$dsp[4][filter]="switchsingle";
$dsp[4][width]="10%";

$dsp[5][text]="หลายรายการ::l::checkout multi item";
$dsp[5][field]="canduphold";
$dsp[5][width]="10%";
$dsp[5][filter]="switchsingle";

function local_upload($wh) {
	global $dcrs;
	global $dcrURL;
	$s="<A HREF='upload.php?mediatypemanage=$wh[code]'><img border=0 width=48 height=48 src='";
	if (file_exists("$dcrs/_tmp/mediatype/$wh[code].png")==true) {
		$s.= "$dcrURL/_tmp/mediatype/$wh[code].png";
	} else {
		$s.=  "$dcrURL/_tmp/mediatype.png";
	}
	$s.="'></A>";
	return $s;
	//
}

$o[undelete][field]="delable";
$o[undelete][value]="NO";
/*
$o[unedit][field]="delable";
$o[unedit][value]="NO";
*/

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c," code ",$o);
?><CENTER><?php  echo getlang("คลิกที่ไอคอนเพื่ออัพโหลดภาพใหม่::l::Click on icon to upload new icon.");?></CENTER><?php 
foot();
?>