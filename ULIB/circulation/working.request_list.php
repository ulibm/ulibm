<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");
$tbname="request_list";


$c[2][text]="Memberid::l::Memberid";
$c[2][field]="memberid";
$c[2][fieldtype]="readonlytext";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Itemid::l::Itemid";
$c[3][field]="itemid";
$c[3][fieldtype]="readonlytext";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="วันที่ขอยืม::l::request date";
$c[4][field]="dt";
$c[4][fieldtype]="date";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Status::l::Status";
$c[5][field]="status";
$c[5][fieldtype]="list:wait,cancel,ready";
$c[5][descr]="";
$c[5][defval]="wait";

//dsp


$dsp[3][text]="วัสดุสารสนเทศ::l::Material";
$dsp[3][align]="center";
$dsp[3][field]="itemid";
$dsp[3][filter]="module:localmat";
$dsp[3][width]="25%";


$dsp[2][text]="Memberid::l::Memberid";
$dsp[2][field]="memberid";
$dsp[2][filter]="memberbarcode";
$dsp[2][width]="25%";
$dsp[4][text]="วันที่ขอยืม::l::request date";
$dsp[4][field]="dt";
$dsp[4][align]="center";
$dsp[4][filter]="date";
$dsp[4][width]="30%";

$dsp[5][text]="Status::l::Status";
$dsp[5][field]="status";
$dsp[5][width]="30%";

function localmat($wh) {
	$parentid=tmq("select * from media_mid where bcode='$wh[itemid]' ");
	$parentid=tmq_fetch_array($parentid);

	$s=marc_gettitle($parentid[pid ])." ($wh[itemid])<BR><A HREF='main.checkout.php?memberbarcode=$wh[memberid]&mediabarcode=$wh[itemid]' target=main>(".getlang("คลิกเพื่อยืม::l::Click to use").")</A> <BR>		[<a href='working.request_list.print.php?id=$wh[id]' target=_blank>".getlang("พิมพ์ใบจอง::l::Print req. slip")."</a>]
";
	return $s;
}
fixform_tablelister($tbname," 1 ",$dsp,"no","yes","yes","mi=$mi",$c,"dt desc");

?>