<?php 
include("../../inc/config.inc.php");
include("./_conf.php");
head();
        mn_root("activateulib");
$tbname="ulib_clientlogins_support";


$c[2][text]="Login ID";
$c[2][field]="uug";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$id;

$c[3][text]="วันเวลา";
$c[3][field]="dt";
$c[3][fieldtype]="datetime";
$c[3][descr]="";
$c[3][defval]=time();

$c[5][text]="ค่าใช้จ่าย";
$c[5][field]="price";
$c[5][fieldtype]="number";
$c[5][descr]="฿";
$c[5][defval]="";

$c[4][text]="รายละเอียด";
$c[4][field]="descr";
$c[4][fieldtype]="longtext";
$c[4][descr]="";
$c[4][defval]="";


//dsp

$dsp[3][text]="ประวัติ support";
$dsp[3][field]="id";
$dsp[3][filter]="module:local_dsp";
$dsp[3][width]="70%";
function local_dsp($wh) {
	$s=ymd_datestr($wh[dt])." <font class=smaller2>" .ymd_ago($wh[dt])."</font><br>
$wh[descr]
	";
	 return $s;
}

$dsp[5][text]="ค่าใช้จ่าย";
$dsp[5][field]="price";
$dsp[5][width]="10%";




fixform_tablelister($tbname," uug='$id' ",$dsp,"yes","yes","yes","id=$id",$c,"dt desc");
?>
<a href="clientlogins.php"><center><b>กลับ</b></center></a>
<?php 
foot();
?>