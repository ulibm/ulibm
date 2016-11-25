<?php 
	; 
	include ("../inc/config.inc.php");
	head();
	$_REQPERM="ulibecard-bgs";
	$tmp=mn_lib();
	pagesection(getlang($tmp));
	
	
$tbname="ulibecard_bg";


$c[5][text]="ใช้งานภาพนี้หรือไม่::l::Active this image";
$c[5][field]="isuse";
$c[5][fieldtype]="yesno";
$c[5][descr]="";
$c[5][defval]="yes";


//dsp

$dsp[7][text]="ภาพย่อ::l::Icon";
$dsp[7][field]="id";
$dsp[7][width]="60%";
$dsp[7][filter]="module:local_upload";


$dsp[8][text]="ใช้ภาพนี้?::l::Active this image?";
$dsp[8][field]="isuse";
$dsp[8][filter]="switchsingle";
$dsp[8][width]="10%";

$local_local_uploadisfirst="yes";
function local_upload($wh) {
	global $dcrs;
	global $local_local_uploadisfirst;
	global $dcrURL;
	$s="<A HREF='upload.php?mediatypemanage=$wh[id]'><img border=0 width=234  ";
	if ($local_local_uploadisfirst=="yes") {
		$s.= " id='local_local_uploadisfirst' ";
		$local_local_uploadisfirst="no";
	}
	$s.= " src='";
	if (file_exists("$dcrs/_tmp/ecard/$wh[id].jpg")==true) {
		$s.= "$dcrURL/_tmp/ecard/$wh[id].jpg";
	} else {
		$s.=  "$dcrURL/_tmp/ecard/default.jpg";
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

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"  isuse<>'yes' ",$o);
?><CENTER><?php  echo getlang("คลิกที่ภาพย่อเพื่ออัพโหลดภาพใหม่<BR>เมื่อมีการบันทึก กรุณารีเฟรชเพื่อดูความเปลี่ยนแปลง::l::Click on icon to upload new icon.<BR>After make changes please refresh to view result.");?></CENTER><?php 


				foot();
?>