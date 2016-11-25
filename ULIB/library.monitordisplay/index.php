<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="monitordisplay";
$tmp=mn_lib();
pagesection($tmp);

$tbname="monitordisplay";


$c[2][text]="ชื่อ::l::Title";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ไฟล์ภาพ::l::Image files";
$c[3][field]="files";
$c[3][fieldtype]="multiplefile";
$c[3][descr]="";
$c[3][defval]="";


//dsp

$dsp[2][text]="ชื่อ::l::Title";
$dsp[2][field]="name";
$dsp[2][width]="30%";


$dsp[3][text]="-";
$dsp[3][align]="center";
$dsp[3][field]="name";
$dsp[3][width]="30%";
$dsp[3][filter]="module:localdet";
function localdet($wh) {
	global $dcrURL;
	global $pid;
	$c=tmq("select * from globalupload where keyid='monitordisplay-$wh[id]'  ");
	$c=tnr($c);
	return " $c Files <br>
	<a href='$dcrURL"."library.monitordisplay/galleria/index.php?id=$wh[id]' class=a_btn target=_blank>".getlang("แสดงหน้าจอ::l::Show this set")."</a>";
}

/*
$dsp[9][text]="แสดง?::l::Show?";
$dsp[9][field]="isshow";
$dsp[9][filter]="switchsingle";
$dsp[9][width]="10%";
*/


fixform_tablelister($tbname," 1  ",$dsp,"yes","yes","yes","pid=$pid&cate=$cate",$c," id desc ");

foot(); 
?>