<?php 
    ;
	include ("../inc/config.inc.php");
	head();

		$_REQPERM="stat-catalog";
	$tbl="media_edittrace";
        $tmp=mn_lib();
		pagesection(getlang($tmp),"stats");
$tbname="media_edittrace";


$c=Array();

//dsp


$dsp[1][text]="วันเวลา::l::Date time";
$dsp[1][field]="id";
$dsp[1][filter]="module:localdt";
$dsp[1][width]="30%";
function localdt($wh) {
	return ymd_datestr($wh[dt],"datetime")."<br>".ymd_ago($wh[dt]);
}

$dsp[2][text]="Bib";
$dsp[2][field]="bibid";
$dsp[2][filter]="module:localbib";
$dsp[2][width]="30%";
function localbib($wh) { //printr($wh);
   global $dcrURL;
	$res= trim(marc_gettitle($wh[bibid]));
	if ($res!="") {
	  $res="<a href='$dcrURL"."dublin.php?ID=$wh[bibid]' target=_blank>$res</a>";
	}
	return $res;
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

	$t.=" and edittype like '".base64_decode($edittype)."' ";
	//echo $t;
//fixform_tablelister($tb,$limitsql,$dsp,$iscanadd="no",$iscanedit="no",$iscandel="no",$addquery="none=none",$edittp,$orderby="",$options="",$selectwhat='*',$havinglogic="",$groupbylogic="") {
fixform_tablelister($tbname," $t ",$dsp,"no","no","no","y=$y&m=$m&d=$d&libtoview=$libtoview&roomtoview=$roomtoview&edittype=$edittype",$c,"dt desc",$o,"");
?><center><a href='cat.php'><?php  echo getlang("กลับ::l::Back");?></a></center><?php 

	foot();
?>