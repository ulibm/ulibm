<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="itemtransit-arrive";
$tmp=mn_lib();
pagesection($tmp);
include("arrived.inc.php");

$setstatusall=floor($setstatusall);
if ($setstatusall!=0 && $setto!="") {
	//tmq("update itemtransit_sub set status='$setto' where pid='$setstatusall' and status='new' ");
	$s=tmq("select * from itemtransit_sub where pid='$setstatusall' and status='new' ",false);
	$now=time();
	while ($r=tfa($s)) {
		local_setarrive($r[id]);
	}
	html_dialog("Information","Set all status to $setto, for ID=$setstatusall");
}

$tbname="itemtransit_main";


$c[1][text]="วันเวลา::l::date time";
$c[1][field]="dt";
$c[1][fieldtype]="autotime";
$c[1][descr]="";
$c[1][defval]="student";

$c[2][text]="ชื่อรายการ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="Transit-".strip_tags(ymd_datestr(time(),"shortd"));

$c[3][text]="Librarian";
$c[3][field]="loginid";
$c[3][fieldtype]="autoofficer";
$c[3][descr]="";
$c[3][defval]="";

$c[5][text]="ย้ายถาวรหรือไม่::l::Permanent Transit";
$c[5][field]="isperm";
$c[5][fieldtype]="yesno";
$c[5][descr]="<br>".getlang("หากเป็นการย้ายถาวร จะทำการเปลี่ยนสถานที่จัดเก็บทรัพยากรอัตโนมัติ::l::If permanent' item place will be updated");
$c[5][defval]="NO";

$c[4][text]="สาขาห้องสมุดปลายทาง::l::Destination campus";
$c[4][field]="dest";
$c[4][fieldtype]="foreign:-localdb-,library_site,code,name,displaykey,displaykey,displaykey";
$c[4][descr]="";
$c[4][defval]=$LIBSITE;

$c[4][text]="Note";
$c[4][field]="note";
$c[4][fieldtype]="longtext";
$c[4][descr]="";
$c[4][defval]="";

//dsp


$dsp[1][text]="รายละเอียด::l::Detail";
$dsp[1][field]="id";
$dsp[1][filter]="module:localdet";
$dsp[1][width]="35%";
function localdet($wh) {
	$s="<b>$wh[name]</b><br>";
	$s.=ymd_datestr($wh[dt])."<BR>";
	$s.=get_library_name($wh[loginid])." <font class=smaller>".$wh[note]."</font>";

	return $s;
}

$dsp[2][text]="จัดการไอเทม::l::Manage Item";
$dsp[2][field]="id";
$dsp[2][align]="center";
$dsp[2][filter]="module:localmanitem";
$dsp[2][width]="30%";
function localmanitem($wh) {
	global $PHP_SELF;
	$cc=tmq("select count(id) as cc from itemtransit_sub where pid=$wh[id]");
	$ccr=tfa($cc);
	$ccrn=floor($ccr[cc]);
	$statusnew=tmq("select count(id) as cc from itemtransit_sub where pid='$wh[id]' and status='new' ");
	$statusnew=tfa($statusnew);
	$statusnew=floor($statusnew[cc]);
	$statusdone=tmq("select count(id) as cc from itemtransit_sub where pid='$wh[id]' and status='done' ");
	$statusdone=tfa($statusdone);
	$statusdone=floor($statusdone[cc]);
	$statuscancel=tmq("select count(id) as cc from itemtransit_sub where pid='$wh[id]' and status='cancel' ");
	$statuscancel=tfa($statuscancel);
	$statuscancel=floor($statuscancel[cc]);
	return "<a href='arrivedsub.php?pid=$wh[id]'>".getlang("ดูไอเทม/รับไอเทม::l::View Items/ Receive items")."</a> ($ccrn)<br>
	<font class=smaller>".getlang("ตั้งสถานะเป็น::l::Set status to").":</font>
	<a href='$PHP_SELF?setstatusall=$wh[id]&setto=done' class='smaller2 a_btn' >done</a><br>
	<font class=smaller>new=$statusnew / done=$statusdone / cancel=$statuscancel</font>
	";
}
$dsp[3][text]="ย้ายถาวรหรือไม่::l::Is Permanent";
$dsp[3][field]="isperm";
$dsp[3][align]="center";
$dsp[3][filter]="switchsingle";
$dsp[3][width]="10%";

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"",$o);

foot(); 
?>