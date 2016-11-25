<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	mn_web("webpage");
	if ($mem==$_memid || loginchk_lib('chk')) {

$tbname="member_log";


$c=Array();

//dsp


$dsp[1][text]="วันเวลา::l::Date time";
$dsp[1][field]="id";
$dsp[1][filter]="module:localdt";
$dsp[1][width]="30%";
function localdt($wh) {
	return ymd_datestr($wh[dt],"datetime")."<br>".ymd_ago($wh[dt]);
}


$dsp[3][text]="-";
$dsp[3][field]="id";
$dsp[3][filter]="module:localdescr";
$dsp[3][width]="30%";
function localdescr($wh) {
	$res="&nbsp;";
	if ($wh[type1]=="login") {
		$res=getlang("ล็อกอิน::l::Login");
	}
	if ($wh[type1]=="logout") {
		$res=getlang("ล็อกเอาท์::l::Logout");
	}
	if ($wh[type1]=="chinfo") {
		$res=getlang("อัพเดทข้อมูลส่วนตัว::l::Update Personal Info");
	}
	return $res;
}
//$o[unedit][field]="type";
//$o[unedit][value]="onlineregist";
pagesection(getlang("ประวัติการล็อกอิน::l::Login History"));
fixform_tablelister($tbname," memid='$mem' and (type1='login' or type1='logout' or type1='chinfo' ) ",$dsp,"no","no","no","mem=$mem",$c,"dt desc",$o,"");
	} else {
		html_dialog("Error","Permission Denied");
	}

	foot();
?>