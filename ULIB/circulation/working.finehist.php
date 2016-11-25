<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

	localloadmember($memberbarcode,"yes");
	pagesection("ค่าปรับที่ชำระแล้ว::l::Paid fine");
	html_xpbtn(getlang("ค่าปรับที่ยังไม่ชำระ::l::Unpaid fine").",working.fine.php?memberbarcode=$memberbarcode,gray");
$tbname="finedone";


//dsp

$dsp[2][text]="ใบเสร็จ::l::Reciept";
$dsp[2][field]="idid";
$dsp[2][align]="center";
$dsp[2][filter]="linkout:working.fine.fdd.php?id=[value-idid]&memberbarcode=$memberbarcode,_blank";
$dsp[2][width]="15%";

$dsp[3][text]="เงิน::l::Cach";
$dsp[3][field]="cach";
$dsp[3][align]="center";
$dsp[3][width]="10%";

$dsp[5][text]="Credit";
$dsp[5][field]="credit";
$dsp[5][align]="center";
$dsp[5][width]="10%";

$dsp[4][text]="ผู้รับจ่าย::l::Librarian";
$dsp[4][field]="lib";
$dsp[4][width]="20%";
$dsp[4][filter]="module:locallib";

$dsp[9][text]="วันที่ชำระ::l::Paid date";
$dsp[9][filter]="date";
$dsp[9][field]="dt";
$dsp[9][width]="30%";

function locallib($wh) {
	return get_library_name($wh[lib]);
}
$_TBWIDTH="100%";

fixform_tablelister($tbname,"  member='$memberbarcode'  ",$dsp,"no","no","no","memberbarcode=$memberbarcode",$c);

?>