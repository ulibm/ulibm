<?php 
	; 
	include ("../inc/config.inc.php");
	head();
	$_REQPERM="webpage-headbar";
	mn_lib();
	pagesection(getlang("ภาพส่วนหัวโปรแกรม::l::Webpage Head Image"));
	
	
$tbname="htmltemplate";

$c[2][text]="ชื่อภาพ::l::File Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="เป็นภาพหลักหรือไม่::l::Default Head";
$c[3][field]="isdef";
$c[3][fieldtype]="switchsingle";
$c[3][descr]="";
$c[3][defval]="YES";

$c[5][text]="ใช้งานภาพนี้หรือไม่::l::Active this image";
$c[5][field]="isuse";
$c[5][fieldtype]="yesno";
$c[5][descr]="";
$c[5][defval]="yes";

$c[4][text]="แสดงเป็นส่วนภาพหลัก ตั้งแต่::l::Set as head image from";
$c[4][field]="dtstart";
$c[4][fieldtype]="datetime";
$c[4][descr]="";
$c[4][defval]=time();

$c[8][text]="จนถึง::l:: to ";
$c[8][field]="dtend";
$c[8][fieldtype]="datetime";
$c[8][descr]="";
$c[8][defval]=time()+(60*60*24*15);

//dsp

$dsp[7][text]="ภาพย่อ::l::Icon";
$dsp[7][field]="id";
$dsp[7][width]="5%";
$dsp[7][filter]="module:local_upload";

$dsp[2][text]="ชื่อ::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="40%";

$dsp[5][text]="แสดงตามช่วงเวลา::l::Show on period";
$dsp[5][field]="dtstart";
$dsp[5][filter]="module:local_dsptime";
$dsp[5][width]="30%";

$dsp[4][text]="เป็นภาพหลัก?::l::Default Image?";
$dsp[4][field]="isdef";
$dsp[4][filter]="switchsingle";
$dsp[4][width]="20%";

$dsp[8][text]="ใช้ภาพนี้?::l::Active this image?";
$dsp[8][field]="isuse";
$dsp[8][filter]="switchsingle";
$dsp[8][width]="20%";

$local_local_uploadisfirst="yes";
function local_upload($wh) {
	global $dcrs;
	global $local_local_uploadisfirst;
	global $dcrURL;
	$s="<A HREF='h_headbar-upload.php?mediatypemanage=$wh[id]'><img border=0 width=234 height=23 ";
	if ($local_local_uploadisfirst=="yes") {
		$s.= " id='local_local_uploadisfirst' ";
		$local_local_uploadisfirst="no";
	}
	$s.= " src='";
	if (file_exists("$dcrs/_tmp/headbar/$wh[id].jpg")==true) {
		$s.= "$dcrURL/_tmp/headbar/$wh[id].jpg";
	} else {
		$s.=  "$dcrURL/_tmp/headbar/default.jpg";
	}
	$s.="'></A>";
	return $s;
	//
}

function local_dsptime($wh) {
	//printr($wh);
	if ($wh[isdef]=="yes") {
		return "-";
	}
	$s="";
	$s.=ymd_datestr($wh[dtstart])." - ".ymd_datestr($wh[dtend]);
	return "<FONT style='font-size:12'>$s</FONT>";
}


$o[undelete][field]="isdef";
$o[undelete][value]="yes";
$o[unedit][field]="isdef";
$o[unedit][value]="yes";
/*
*/

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c," isdef<>'yes', isuse<>'yes' ",$o);
?><CENTER><?php  echo getlang("คลิกที่ภาพย่อเพื่ออัพโหลดภาพใหม่<BR>เมื่อมีการบันทึก กรุณารีเฟรชเพื่อดูความเปลี่ยนแปลง::l::Click on icon to upload new icon.<BR>After make changes please refresh to view result.");?></CENTER><?php 


if ($ffe_issave=="yes") {
   redir($PHP_SELF); die;
}
				foot();
?>