<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="marctemplate";
	$tmp=mn_lib();
	pagesection($tmp);

$tbname="marc_template";


$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ตั้งอัตโนมัติสำหรับ Loader/06::l::Auto set for Loader/06";
$c[3][field]="autoset";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="NONE";

$c[6][text]="ใช้อัตโนมัติสำหรับดรรชนีวารสาร::l::Auto use for Journal Index";
$c[6][field]="forjindex";
$c[6][fieldtype]="switchsingle";
$c[6][descr]="";
$c[6][defval]="";

/*
$c[4][text]="Delable::l::Delable";
$c[4][field]="delable";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="YES";
*/
$flist="defaultshow";
for ($i=1;$i<=11;$i++) {
	$flist.= ",marc_tp".str_fixw($i,2);
}
$flist=trim($flist,',');
$c[5][text]="โยงกับเขตข้อมูล::l::Use field";
$c[5][field]="fid";
$c[5][fieldtype]="list:$flist";
$c[5][descr]="";
$c[5][defval]="";

//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="Autoset::l::Autoset";
$dsp[3][field]="autoset";
$dsp[3][width]="30%";

$dsp[4][text]="Delable::l::Delable";
$dsp[4][field]="delable";
$dsp[4][width]="30%";

$dsp[6][text]="JournalIndex";
$dsp[6][field]="forjindex";
$dsp[6][filter]="switchsingle";
$dsp[6][width]="7%";

$dsp[5][text]="Fid::l::Fid";
$dsp[5][field]="fid";
$dsp[5][width]="30%";

$o[undelete][field]="delable";
$o[undelete][value]="NO";

$o[addlink][] = "../library.bkedit/media_type.php::".getlang("กลับโครงสร้างมาร์ค::l::Back to Marc structure");;

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot();
?>