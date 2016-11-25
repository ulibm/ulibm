<?php 
;
     include("../inc/config.inc.php"); 
	 head();
	 //include("_REQPERM.php");
	 $_REQPERM="dbfulltext-dspcon";
	 mn_lib();
	 
	 $tbname="dbfulltext_cate";


$c[2][text]="Code::l::Code";
$c[2][field]="code";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ชื่อประเภท::l::Name";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ข้อความเพิ่มเติม::l::Description";
$c[4][field]="descr";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="รูปแบบการแสดงผล::l::Display code";
$c[5][field]="dsp";
$c[5][fieldtype]="longtext";
$c[5][descr]="<BR>ใช้ [[url]] เพื่อแทน URL ไฟล์ [[dcrurl]] สำหรับ URL โปรแกรม::l::<BR>Use [[url]] replacing file's URL [[dcrurl]] for ULIB's URL";
$c[5][defval]="";

//dsp


$dsp[2][text]="Code::l::Code";
$dsp[2][field]="code";
$dsp[2][width]="15%";

$dsp[3][text]="ชื่อประเภท::l::Name";
$dsp[3][field]="name";
$dsp[3][width]="30%";

$dsp[4][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[4][field]="descr";
$dsp[4][width]="30%";

$dsp[5][text]="ประเภทไฟล์::l::Extensions";
$dsp[5][field]="code";
$dsp[5][align]="center";
$dsp[5][width]="30%";
$dsp[5][filter]="module:local_link";

function local_link($wh) {
				 $s="<a href='dspcon.sub.php?pid=$wh[code]'>".getlang("จัดการ::l::Manage")."</a>";
				 
				 return $s;
}

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot();

?>