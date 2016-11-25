<?php 
;
     include("../inc/config.inc.php"); 
	 head();
	 $_REQPERM="webtextreplacer";
if (!library_gotpermission($_REQPERM)) {
	die();
}
	 mn_lib();

	 pagesection(getlang("แทนที่ข้อความในระบบหน้าเว็บไซต์::l::Webpage text replacer"));


$c[3][text]="แทนที่::l::replace this";
$c[3][field]="str1";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ด้วย::l::With";
$c[4][field]="str2";
$c[4][fieldtype]="longtext";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="เปิดใช้งาน::l::Enable";
$c[5][field]="active";
$c[5][fieldtype]="yesno";
$c[5][descr]="";
$c[5][defval]="yes";

$c[6][text]="เรียงลำดับ::l::Ordering";
$c[6][field]="ordr";
$c[6][fieldtype]="number";
$c[6][descr]="";
$c[6][defval]="0";

 //dsp


$dsp[1][text]="แทนที่::l::replace this";
$dsp[1][field]="str1";
$dsp[1][width]="30%";

$dsp[2][text]="ด้วย::l::With";
$dsp[2][field]="str2";
$dsp[2][width]="30%";

$dsp[3][text]="เปิดใช้งาน::l::Enable";
$dsp[3][field]="active";
$dsp[3][filter]="switchsingle";
$dsp[3][width]="20%";

$dsp[4][text]="ลำดับ::l::Ordering";
$dsp[4][field]="ordr";
$dsp[4][align]="center";
$dsp[4][width]="6%";


$tbname="webpage_textreplacer";

$limit=" 1 ";

fixform_tablelister($tbname," $limit ",$dsp,"yes","yes","yes","mi=$mi",$c,"ordr");

	 
	 foot();
?>