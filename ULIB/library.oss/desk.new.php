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
$dsp[2][width]="30%";

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


$dsp[5][text]="สถานะ";
$dsp[5][field]="ordr";
$dsp[5][align]="center";
$dsp[5][width]="7%";
$dsp[5][filter]="module:local_stat";


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


$limit=" stat='new' ";
if ($filterstat!="") {
	$limit=" stat='$filterstat' ";
}
if ($servicetype!="") {
	$limit.=" and servicetype='$servicetype' ";
}
$kw=trim($kw);
if ($kw!="") {
	$limit.="  and mat_info like '%$kw%'" . " or cardid='$kw' ";
}
?><center><form method="post" action="<?php  echo $PHP_SELF?>" style="margin-bottom: 0px;">
<input type="hidden" name="filterstat" value="<?php  echo $filterstat;?>">
	<input type="text" name="kw" value="<?php  echo $kw?>"> <?php 
	frm_genlist("servicetype","select * from oss_servicetype where 1 order by ordr","classid","name","","yes",$servicetype);
	?><input type="submit" value="ค้นหา">
</form></center><?php 
$_TBWIDTH="100%";
//echo $limit;
fixform_tablelister($tbname,$limit,$dsp,"no","no","no","kw=$kw&filterstat=$filterstat&servicetype=$servicetype",$c,"id desc");

include("desk.inc.ifupdater.php");
//foot();
?>