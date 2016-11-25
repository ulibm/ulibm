<?php 
include("../inc/config.inc.php");
head();
	include("_REQPERM.php");
mn_lib();

$tbname="bkedit";

$c=Array();

//dsp

$dsp[4][text]="Tag";
$dsp[4][field]="fid";
$dsp[4][width]="10%";

$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[3][field]="descr";
$dsp[3][width]="30%";

$dsp[5][text]="Indicators 1/2";
$dsp[5][field]="name";
$dsp[5][align]="center";
$dsp[5][width]="15%";
$dsp[5][filter]="module:localicon";

function localicon($wh) { //printr($wh);
				 global $dcrURL;
				 $c1=tmq("select id from bkedit_indi where indiid='1' and tag='$wh[fid]' ");
				 $c1=tnr($c1);
				 $c2=tmq("select id from bkedit_indi where indiid='2' and tag='$wh[fid]' ");
				 $c2=tnr($c2);
				 return "[$c1/$c2] <a href='defindi_sub.php?tag=$wh[fid]'>".getlang("จัดการ::l::Manage")."</a>";
}

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"fid");
?><center><a href='index.php' class=a_btn>Back</a></center><?php
  include("reindexindi.php");
foot();
?>