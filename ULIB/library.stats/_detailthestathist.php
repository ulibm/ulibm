<?php 
include("../inc/config.inc.php");
head();
include("inc.local.php");
		$sdbs=tmq("select * from library_modules where code='stat-cir-".$stat."_$db' ");
		if (tmq_num_rows($sdbs)==0) {
			die("library_modules where code='stat-cir-$stat"."_$db'");
		}
		$sdbs=tmq_fetch_array($sdbs);
		
		$_REQPERM=$sdbs[code];

	$tmp=mn_lib();
	pagesection($tmp);

$tbname=$stat."_".$db;


$c[2][text]="ชื่อวันหมดอายุ::l::Template name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[20][text]="วันเดือนปี::l::Date";
$c[20][field]="dt";
$c[20][fieldtype]="date";
$c[20][descr]="";
$c[20][defval]="";

//dsp

		$sdb=local_getsdb_thestathist();

$dsp[2][text]="Stat";
$dsp[2][field]="head";
$dsp[2][filter]="module:local_head";
$dsp[2][width]="30%";
function local_head($wh) {
	global $db;
	global $sdb;
	return local_getdspstr($wh[head],$sdb[$db][headmode]);
}

$dsp[4][text]="Stat";
$dsp[4][field]="foot";
$dsp[4][filter]="module:local_foot";
$dsp[4][width]="30%";
function local_foot($wh) {
	//printr($wh);
	global $db;
	global $sdb;
	//printr($sdb["$db"]);
	return local_getdspstr($wh[foot],$sdb["$db"][footmode]);
}


$dsp[3][text]="วันเวลา::l::Date Time";
$dsp[3][field]="dt";
$dsp[3][filter]="datetime";
$dsp[3][width]="30%";

$iscandel="no";
if (library_gotpermission("stat-candelete")) {
	$iscandel="yes";
}
$limit="1 and dat='$d' and mon='$m' and yea='$y' ";

if (trim($foot)!="") {
   $limit.=" and foot='$foot' ";
}
fixform_tablelister($tbname," $limit ",$dsp,"no","no","$iscandel","mi=$mi&d=$d&m=$m&y=$y&stat=$stat&db=$db",$c);


foot();
?>