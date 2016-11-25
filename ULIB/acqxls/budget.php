<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="acqxls_budget";
$tmp=mn_lib();
pagesection($tmp);

$tbname="acqn_budget";


$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="งบประมาณ::l::Amount";
$c[3][field]="amnt";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ยังใช้งาน::l::is active?";
$c[4][field]="isactive";
$c[4][fieldtype]="list:yes,no";
$c[4][descr]="";
$c[4][defval]="yes";

//dsp


//$dsp[1][text]="รหัส::l::Code";
//$dsp[1][field]="code";
//$dsp[1][width]="20%";

$dsp[2][text]="ชื่อ::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="งบประมาณ::l::Amount";
//$dsp[3][filter]="number";
$dsp[3][field]="amnt";
$dsp[3][align]="center";
$dsp[3][width]="15%";

$dsp[4][text]="สถานะ::l::Status";
$dsp[4][align]="center";
$dsp[4][field]="name";
$dsp[4][filter]="module:localstat";
$dsp[4][width]="30%";
function localstat($wh) {
	$remains=tmq("select sum(pricenet) as cc from acqn_sub where budget='$wh[code]' ");
	$remains=tfa($remains);
	$remains=$remains[cc];
	$remains=$wh[amnt]-$remains;
	$s= "<font ";
	if ($remains<0) {
		$s.=" style='color:red;' ";
	}
	$s.=">คงเหลือ ".number_format($remains)."</font>";
	return $s;
}

$dsp[5][text]="ยังใช้งาน::l::is active?";
$dsp[5][field]="isactive";
$dsp[5][filter]="switchsingle";
$dsp[5][width]="10%";



fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot(); 
?>