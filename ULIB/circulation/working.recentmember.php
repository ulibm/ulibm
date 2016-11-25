<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

 //dsp


$dsp[1][text]="บาร์โค้ด::l::Barcode";
$dsp[1][field]="head";
//$dsp[1][filter]="module:localhead";
$dsp[1][width]="20%";
function localhead($wh) {
   return $wh[head]."<BR><font class=smaller2 color=gray TITLE='".strip_tags(ymd_datestr($wh[dt]))."'>".ymd_ago($wh[dt])."</font>";
}

$dsp[9][text]="ให้ยืม::l::Checkout";
$dsp[9][align]="center";
$dsp[9][field]="memberbarcode";
$dsp[9][filter]="module:letcheckout";
$dsp[9][width]="15%";

$dsp[10][text]="ค่าปรับ::l::Fines";
$dsp[10][align]="center";
$dsp[10][field]="memberbarcode";
$dsp[10][filter]="module:letcheckfine";
$dsp[10][width]="15%";

$dsp[2][text]="สมาชิก::l::Member";
$dsp[2][field]="head";
$dsp[2][filter]="memberbarcode";
$dsp[2][width]="25%";

/*
$dsp[3][text]="Date::l::Date";
$dsp[3][field]="dt";
$dsp[3][filter]="date";
$dsp[3][width]="20%";
*/

$dsp[8][text]="สาขา::l::Campus";
$dsp[8][field]="lib";
$dsp[8][filter]="module:locallibrarian";
$dsp[8][width]="20%";


function locallibrarian($wh) {
	return get_libsite_name($wh[foot]);
}
function letcheckout($wh) {
	return "<B><A HREF='main.checkout.php?memberbarcode=$wh[head]' target=main>".getlang("ให้ยืม::l::Checkout")."</A></B>";
}
function letcheckfine($wh) {
	return "<B><A HREF='main.fine.php?memberbarcode=$wh[head]&submitnow=yes' target=main>".getlang("ค่าปรับ::l::Fines")."</A></B>";//.ymd_datestr($wh[dt])."<BR>".ymd_ago($wh[dt]);
}

$tbname="stathist_cir_member";

fixform_tablelister($tbname," foot='$LIBSITE' ",$dsp,"no","no","no","mi=$mi",$c," id desc","","distinct head");

?>