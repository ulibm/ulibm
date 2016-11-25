<?php 
include("../inc/config.inc.php");
html_start();
loginchk_lib();

$tbname="webbox_photogrid";



$c[6][text]="ไฟล์ภาพประชาสัมพันธ์::l::Annouce Image banner";
$c[6][field]="imgfiles";
$c[6][fieldtype]="multiplefile";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]=" ";
$c[7][field]="boxid";
$c[7][fieldtype]="addcontrol";
$c[7][descr]="";
$c[7][defval]=$id;

$c[8][text]="Random?";
$c[8][field]="israndom";
$c[8][fieldtype]="yesno";
$c[8][descr]="";
$c[8][defval]="yes";

$c[9][text]="Photo Width";
$c[9][field]="photowidth";
$c[9][fieldtype]="number";
$c[9][descr]="";
$c[9][defval]="120";
//dsp


$dsp[4][text]="ตั้งค่า::l::settings";
$dsp[4][align]="center";
$dsp[4][field]="id";
$dsp[4][filter]="module:localcfg";
$dsp[4][width]="40%";
function localcfg($wh) {
	$s="";
   $c=tmq("select * from globalupload where keyid='webbox_photogrid-$wh[id]'  ",false);
	//$s.=localcfg_sub(getlang("ข้อความส่วนหัว"),"main_bartoptext","text");
   $s.= tnr($c)." File(s)";
	return $s;
}
function localcfg_sub($name,$item,$mode="html") {
	$s.=" <a href=\"pagehtml.php?code=$item&mode=$mode\" class='a_btn smaller2' rel='gb_page_fs[]' >".$name."</a> ";
	return $s;
}
$id=floor($id);
$chk=tmq("select * from webbox_photogrid where boxid = $id ");
if (tnr($chk)!=1) {
   tmq("delete from $tbname where boxid='$id' ");
   tmq("insert into $tbname set boxid='$id' ");
}
fixform_tablelister($tbname," boxid = $id ",$dsp,"no","yes","no","id=$id",$c,"",$o);

foot(); 
?>