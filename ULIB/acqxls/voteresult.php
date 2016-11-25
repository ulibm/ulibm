<?php 
session_start();
include("./cfg.inc.php");
include("./head.php");
limitpage_var();    

	$permupload="no";


$tbname="acqn_sub";


$c[1][text]="ชื่อเรื่อง";
$c[1][field]="titl";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="-";
$c[2][field]="pid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$pid;

$c[3][text]="ผู้แต่ง";
$c[3][field]="auth";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ISBN";
$c[4][field]="isn";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="จำนวนสำเนา";
$c[5][field]="copy";
$c[5][fieldtype]="number";
$c[5][descr]="";
$c[5][defval]=1;

$c[6][text]="ราคา";
$c[6][field]="price";
$c[6][fieldtype]="number";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="ส่วนลด";
$c[7][field]="pricedis";
$c[7][fieldtype]="number";
$c[7][descr]="";
$c[7][defval]=0;

$c[8][text]="ราคาสุทธิ";
$c[8][field]="pricenet";
$c[8][fieldtype]="number";
$c[8][descr]="";
$c[8][defval]="";

$c[9][text]="สถานะ";
$c[9][field]="pricenet";
$c[9][fieldtype]="number";
$c[9][descr]="";
$c[9][defval]="";



//

$dsp[1][text]="รายละเอียดทรัพยากร";
$dsp[1][field]="text";
$dsp[1][filter]="module:local_dsp";
$dsp[1][width]="60%";
if ($permupload=="yes") {
	$o[addlink][] = "addlong.php?pid=$pid::<B>เพิ่มทีละหลายรายการ</B>::_self";
}
//$o[addlink][] = "list.php::กลับ::_self";

function local_dsp($wh) {
	$sayyes=tnr(tmq("select id from acqn_voted where data like '%,on-$wh[id],%' "));
	$sayno=tnr(tmq("select id from acqn_voted where data like '%,off-$wh[id],%' "));
	$s="<div style='width: 100%'>
<div style='width: 50;float:left; text-align:center; color: darkgreen;font-size:16;font-weight: bolder;'>".number_format($sayyes)."</div>
<div style='width: 50;float:left; text-align:center; color: darkred; font-size:16;font-weight: bolder; margin-right: 15; border: 0 black dotted; border-right-width:2; padding-right: 3'>".number_format($sayno)."</div>
".stripslashes($wh[text])."
</div>";

	return $s;
}

fixform_tablelister($tbname," pid='$pid' ",$dsp,"$permupload","$permupload","$permupload","pid=$pid",$c,"id",$o);

    
?>
<SCRIPT LANGUAGE="JavaScript" src="/counter2?Arec_acqn">
<!--
//-->
</SCRIPT>


<?php 
foot();
?>