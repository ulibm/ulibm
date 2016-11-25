<?php 
    ;
	include ("../inc/config.inc.php");
	head();

		$_REQPERM="stat-editmem";
	$tbl="member_edittrace";
        $tmp=mn_lib();
		pagesection(getlang($tmp),"stats");
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

$dsp[2][text]="Member";
$dsp[2][field]="id";
$dsp[2][filter]="module:localmem";
$dsp[2][width]="30%";
function localmem($wh) {
	return trim(strip_tags(get_member_name($wh[memid])));
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

$m=floor($m);
	$dts=ymd_mkdt($d,$m,$y);
	$dte=ymd_mkdt($d+1,$m,$y);

$t=" dt<=$dte and dt>=$dts ";
	if ($libtoview!="") {
      $t.="and  login='$libtoview'";
	}
	if ($roomtoview!="") {
      $t.="and  memid in (select UserAdminID from member where room='$roomtoview' ) ";
	}
	$t.=" and edittype like '".base64_decode($edittype)."' ";
	
//fixform_tablelister($tb,$limitsql,$dsp,$iscanadd="no",$iscanedit="no",$iscandel="no",$addquery="none=none",$edittp,$orderby="",$options="",$selectwhat='*',$havinglogic="",$groupbylogic="") {
fixform_tablelister($tbname," $t ",$dsp,"no","no","no","y=$y&m=$m&d=$d&libtoview=$libtoview&roomtoview=$roomtoview&edittype=$edittype",$c,"dt desc",$o,"");
?><center><a href='mem.php'><?php  echo getlang("กลับ::l::Back");?></a></center><?php 

	foot();
?>