<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	mn_web("webpage");
	if ($mem==$_memid || loginchk_lib('chk')) {

$tbname="member_edittrace";


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
	$res=$wh[edittype]."<BR>".get_library_name($wh[login]);
	return $res;
}
//$o[unedit][field]="type";
//$o[unedit][value]="onlineregist";
pagesection(getlang("ประวัติการอัพเดทข้อมูล::l::Update History"));
fixform_tablelister($tbname," memid='$mem' ",$dsp,"no","no","no","mem=$mem",$c,"dt desc",$o,"");
	} else {
		html_dialog("Error","Permission Denied");
	}

	foot();
?>