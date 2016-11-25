<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="webpage-sections";
        mn_lib();
		$tbname="webpage_sections";


pagesection(getlang("จัดการประกาศหน้าหลัก::l::Annouce at homepage"));

$c[2][text]="Title::l::Title";
$c[2][field]="title";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Body::l::Body";
$c[3][field]="body";
$c[3][fieldtype]="html";
$c[3][addon]="globalupload::";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Date";
$c[4][field]="dt";
$c[4][fieldtype]="autotime";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="แสดงหรือไม่::l::Show?";
$c[5][field]="isshow";
$c[5][fieldtype]="list:yes,no";
$c[5][descr]="";
$c[5][defval]="";


$c[6][text]="แสดงไว้บนสุด::l::Pin at top";
$c[6][field]="ispin";
$c[6][fieldtype]="list:yes,no";
$c[6][descr]="";
$c[6][defval]="no";

//dsp


$dsp[2][text]="Title::l::Title";
$dsp[2][field]="title";
$dsp[2][width]="30%";

$dsp[4][text]="Dt::l::Dt";
$dsp[4][field]="dt";
$dsp[4][filter]="date";
$dsp[4][width]="30%";

$dsp[5][text]="แสดงไว้บนสุด::l::Pin at top";
$dsp[5][field]="ispin";
$dsp[5][filter]="switchsingle";
$dsp[5][width]="20%";

$dsp[6][text]="Isshow::l::Isshow";
$dsp[6][field]="isshow";
$dsp[6][filter]="switchsingle";
$dsp[6][width]="20%";

 
fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"ispin desc, isshow desc, dt desc");

				foot();
?>