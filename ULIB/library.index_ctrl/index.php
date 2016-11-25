<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="bkeditindex";
$tmp=mn_lib();
pagesection($tmp);

$tbname="index_ctrl";


$c[8][text]="Code::l::Code";
$c[8][field]="code";
$c[8][fieldtype]="text";
$c[8][descr]="";
$c[8][defval]="";

$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ใช้ฟิลด์::l::Use field";
$c[3][field]="fid";
$c[3][fieldtype]="list:index01,index02,index03,index04,index05,index06,index07,index08,index09,index10,fixw,kw,auth,isbn,subj,titl";
$c[3][descr]="";
$c[3][defval]="index01";

$c[9][text]="แสดงใน Presearch?::l::Show as Presearch?";
$c[9][field]="ispresearch";
$c[9][fieldtype]="list:yes,no";
$c[9][descr]="";
$c[9][defval]="no";

/*
$c[4][text]="Delable::l::Delable";
$c[4][field]="delable";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="YES";
*/
//dsp


$dsp[2][text]="ชื่อ::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="ใช้ฟิลด์::l::Use field";
$dsp[3][field]="fid";
$dsp[3][width]="30%";


$o[undelete][field]="delable";
$o[undelete][value]="NO";

$o[addlink][] = "../library.bkeditindex/media_type.php::".getlang("กลับโครงสร้างการ Index::l::Back to Indexing rules");;

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot();
?>