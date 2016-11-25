<?php 
include("../../inc/config.inc.php");
include("./_conf.php");
head();
        mn_root("activateulib");
$tbname="ulib_clientlogins_ma";


$c[2][text]="Login ID";
$c[2][field]="uug";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$id;

$c[3][text]="วันเดือนปี";
$c[3][field]="dt";
$c[3][fieldtype]="date";
$c[3][descr]="";
$c[3][defval]=time();

$c[5][text]="ประเภท";
$c[5][field]="matype";
$c[5][fieldtype]="list:เริ่มM-A,ต่ออายุ";
$c[5][descr]="";
$c[5][defval]="เริ่มM-A";

$c[6][text]="จำนวนเงิน";
$c[6][field]="price";
$c[6][fieldtype]="number";
$c[6][descr]="฿";
$c[6][defval]="";

$c[7][text]="ระยะเวลาคุ้มครอง";
$c[7][field]="month";
$c[7][fieldtype]="number";
$c[7][descr]=" เดือน";
$c[7][defval]="";

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
	$s=ymd_datestr($wh[dt],"date")." ($wh[matype]) <font class=smaller2>" .ymd_ago($wh[dt])."</font><br>
$wh[descr]
	";
	 return $s;
}

$dsp[4][text]="จำนวน";
$dsp[4][field]="price";
$dsp[4][width]="10%";

$dsp[5][text]="เวลา (เดือน)";
$dsp[5][field]="month";
$dsp[5][width]="10%";





fixform_tablelister($tbname," uug='$id' ",$dsp,"yes","yes","yes","id=$id",$c,"dt desc");
?>
<a href="clientlogins.php"><center><b>กลับ</b></center></a>
<?php 
foot();
?>