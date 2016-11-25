<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="fdbadmin";
$tmp=mn_lib();
pagesection($tmp);
$tbname="freedb_link";


$c[2][text]="Nested::l::Nested";
$c[2][field]="nested";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$main;


$c[3][text]="Name::l::Name";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[20][text]="ภาพประกอบ::l::Logo";
$c[20][field]="logoimg";
$c[20][fieldtype]="singlefile";
$c[20][descr]="";
$c[20][defval]="";


$c[4][text]="Url::l::Url";
$c[4][field]="url";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="http://";

$c[5][text]="ข้อความเพิ่มเติม::l::Description";
$c[5][field]="descr";
$c[5][fieldtype]="longtext";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="รายงานลิงค์เสีย::l::Report dead link";
$c[6][field]="reportdeadlink";
$c[6][fieldtype]="number";
$c[6][descr]="";
$c[6][defval]="0";


$c[8][text]="จำนวนการคลิก::l::Click Count";
$c[8][field]="clickcount";
$c[8][fieldtype]="number";
$c[8][descr]="";
$c[8][defval]="1";
//dsp


$dsp[3][text]="Name::l::Name";
$dsp[3][field]="name";
$dsp[3][filter]="module:local_name";
$dsp[3][width]="30%";

$dsp[4][text]="Url::l::Url";
$dsp[4][field]="url";
$dsp[4][width]="30%";

$dsp[5][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[5][field]="descr";
$dsp[5][width]="30%";

$o[addlink][] = "index.php::".getlang("กลับ::l::Back");;

function local_name($wh) {
	global $tbname;
	global $cate;
	$img=fft_upload_get($tbname,"logoimg",$wh[id]);
	//printr($img);
	$s="<img src='$img[url]' align=left width=100>";
	$wh[name]=trim($wh[name]);
	if ($wh[name]=="") {
		$wh[name]="<I>- no title -</I>";
	}
	$s.="$wh[name]";
	if ($wh[reportdeadlink]!=0) {
		$s.="<BR><FONT class=smaller COLOR=red>Report Dead Link : $wh[reportdeadlink]</FONT>";
	}
	if ($wh[clickcount]!=0) {
		$s.="<BR><FONT class=smaller COLOR=darkgreen>Click : $wh[clickcount]</FONT>";
	}
	return $s;
}

fixform_tablelister($tbname," nested='$main' ",$dsp,"yes","yes","yes","main=$main",$c,"",$o);
?><center>
<a class='smaller a_btn' href='./index.php'><?php echo getlang("กลับ::l::Back");?></a> 
<a class='smaller a_btn' href='../freedb.php' target=_blank><?php echo getlang("ไปยังฐานข้อมูลออนไลน์ส่วนผู้ใช้::l::Go to member's view");?></a> 


</center><?php

foot();
?>