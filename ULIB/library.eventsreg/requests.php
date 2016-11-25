<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

pagesection("คำขอ/ตัวเลือกเพิ่มเติม");
$tbname="eventsreg_requests";


$c[2][text]="ข้อความ::l::Text";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]=" ";
$c[2][defval]="";

$c[6][text]="ข้อความเพิ่มเติม::l::Details";
$c[6][field]="detail";
$c[6][fieldtype]="longtext";
$c[6][descr]="";
$c[6][defval]="";

$c[3][text]="เรียงลำดับ::l::Order";
$c[3][field]="ordr";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";


$c[9][text]="";
$c[9][field]="pid";
$c[9][fieldtype]="addcontrol";
$c[9][descr]="";
$c[9][defval]=$pid;


//dsp

$dsp[5][text]="order::l::order";
$dsp[5][field]="ordr";
$dsp[5][width]="5%";

$dsp[2][text]="ข้อความ::l::Text";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[4][text]="Open?";
$dsp[4][field]="openreg";
$dsp[4][filter]="switchsingle";
$dsp[4][width]="10%";


$dsp[3][text]="รายการย่อย::l::Items";
$dsp[3][field]="name";
$dsp[3][filter]="module:local_sub";
$dsp[3][width]="30%";

function local_sub($wh) {
	$s=tmq("select * from eventsreg_requests_sub where pid='$wh[id]' ");
	$res= "<CENTER><A HREF='requests_sub.php?pid=$wh[id]'>รายการย่อย ".tmq_num_rows($s)."</A></CENTER>";
	return $res;
}

fixform_tablelister($tbname," pid=$pid  ",$dsp,"yes","yes","yes","pid=$pid",$c," ordr ");
?><A HREF="index.php"><CENTER>กลับ</CENTER></A><?php

foot();
?>