<?php 
include("../inc/config.inc.php");
html_start();
include ("./inc.php");

?><style>
* {
	font-size: 13px!important;
}
</style><?php 

$tbname="oss_req";



//dsp

$dsp[4][text]="Date/Time";
$dsp[4][field]="dt";
$dsp[4][filter]="module:localdt";
$dsp[4][width]="15%";
function localdt($wh) {
	return ymd_datestr($wh[dt],"datetime");///."<br>".ymd_ago($wh[dt]);
}
$dsp[2][text]="ชื่อ (ข้อความ)::l::Name (Place name)";
$dsp[2][field]="mat_info";
$dsp[2][filter]="module:localmat_info";
$dsp[2][width]="40%";

function localmat_info($wh) {
	global $servicetype;
	global $filterstat;
	global $dcrURL;
	$s="";
	$s.="<a href='checkmatresult.php?id=$wh[id]&servicetype=$servicetype&filterstat=$filterstat'>".dspmarc($wh[mat_info])."</a>";
	if ($wh[mat_id]!="") {
		$url=$dcrURL."dublin.php?ID=$wh[mat_id]";

		$s.=" &nbsp; 
[<a href='$url' target=_blank>View</a>]";
	}
	return "$s";}

$dsp[3][text]="ผู้ขอใช้";
$dsp[3][field]="name";
$dsp[3][filter]="module:local_name";
$dsp[3][width]="20%";

/*
$dsp[5][text]="สถานะ";
$dsp[5][field]="ordr";
$dsp[5][align]="center";
$dsp[5][width]="7%";
$dsp[5][filter]="module:local_stat";
*/

function local_name($wh) {
	$s=tmq("select * from member where UserAdminID='$wh[cardid]' ");
	$s=tfa($s);
	$res="";
	$res.= get_member_name($wh[cardid]);
	if ($s[email]!="") {
		$res.= "<br><a href='mailto:$s[email]'>Email:$s[email]</a>";
	}
	return $res;
}
//
function local_stat($wh) {
	$s="";
	global $statusdb;//printr($statusdb);
	$s.= $statusdb[$wh[stat]];
		$s.="<!-- <br>
<a href='checkmatresult.php?id=$wh[id]'>คลิกเพื่อระบุผลการตรวจสอบ</a> -->";

	return "$s";
}


$limit=" stat='done' ";

$limitdate=floor(form_pickdt_get("limitdate"));


if ($servicetype!="") {
	$limit.=" and servicetype='$servicetype' ";
}
$kw=trim($kw);
if ($kw!="") {
	$limit.="  and mat_info like '%$kw%'" . " or cardid in (select cardid from oss_mem where name like '%$kw%' or email like '%$kw%' )";
}

$limitdate_yea=floor($limitdate_yea);
$limitdate_mon=floor($limitdate_mon);
$limitdate_dat=floor($limitdate_dat);
//echo $limitdate_yea;
$ds=0;
$de=0;
if ($limitdate_yea>0) {
	$ds=mktime(0, 0, 0, 0, 0, $limitdate_yea);
	$de=mktime(0, 0, 0, 0, 0, $limitdate_yea+1);
	if ($limitdate_mon>0) {
		$ds=mktime(0, 0, 0,$limitdate_mon, 0,  $limitdate_yea);
		$de=mktime(0, 0, 0, $limitdate_mon+1,0,  $limitdate_yea);
		if ($limitdate_dat>0) {
			$ds=mktime(0, 0, 0, $limitdate_mon,$limitdate_dat,  $limitdate_yea);
			$de=mktime(0, 0, 0,  $limitdate_mon,$limitdate_dat+1, $limitdate_yea);
		}
	}
}
if ($de>0 && $de>0) {
	$limit.=" and (dt>=$ds and dt<=$de) ";
	//echo "$limitdate_yea/$limitdate_mon/$limitdate_dat<br>";
	//echo ymd_datestr($ds)."-".ymd_datestr($de);
}

?><center><form method="post" action="<?php  echo $PHP_SELF?>" style="margin-bottom: 0px;">
<input type="hidden" name="filterstat" value="<?php  echo $filterstat;?>">
	<input type="text" name="kw" value="<?php  echo $kw?>"> <?php 
	frm_genlist("servicetype","select * from oss_servicetype where 1 order by ordr","classid","name","","yes",$servicetype);
	echo "<br>";
	form_pickdate("limitdate",$limitdate,"yes");

	?><input type="submit" value="ค้นหา">
	<!-- <a target=_blank href="<?php  echo "reportprint.php?filterstat=$filterstat&servicetype=$servicetype&limitdate_dat=$limitdate_dat&limitdate_mon=$limitdate_mon&limitdate_yea=$limitdate_yea&kw=$kw";?>">พิมพ์</a> -->
</form></center><?php 
$_TBWIDTH="100%";
//echo $limit;
fixform_tablelister($tbname,$limit,$dsp,"no","no","no","kw=$kw&filterstat=$filterstat&servicetype=$servicetype&limitdate_dat=$limitdate_dat&limitdate_mon=$limitdate_mon&limitdate_yea=$limitdate_yea",$c,"id desc");

include("desk.inc.ifupdater.php");
//foot();
?>