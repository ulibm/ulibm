<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
$tmp=mn_lib();
pagesection($tmp);

$tbname="selfcheckio";


$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="".getlang("มีไว้เลือกใช้เท่านั้น ผู้ใช้บริการไม่เห็นข้อความนี้::l::Library's member don't see this");
$c[2][defval]="";

$c[3][text]="Enable Checkout";
$c[3][field]="io_out";
$c[3][fieldtype]="yesno";
$c[3][descr]="";
$c[3][defval]="yes";

$c[5][text]="Enable Checkin";
$c[5][field]="io_in";
$c[5][fieldtype]="yesno";
$c[5][descr]="";
$c[5][defval]="yes";

$c[8][text]="แสดงช่องกรอกบาร์โค้ด::l::Show Input Box";
$c[8][field]="io_allowkeym";
$c[8][fieldtype]="yesno";
$c[8][descr]="";
$c[8][defval]="";

$c[9][text]="สาขาห้องสมุด::l::Library Campus";
$c[9][field]="libsite";
$c[9][fieldtype]="foreign:-localdb-,library_site,code,name";
$c[9][descr]="";
$c[9][defval]="";

$c[7][text]="การสั่งพิมพ์เมื่อเสร็จสิ้น::l::Print slip when finish";
$c[7][field]="io_autoprint";
$c[7][fieldtype]="list:ask,yes,no";
$c[7][descr]="";
$c[7][defval]="ask";

$c[4][text]="กลุ่มไอพีที่อนุญาตให้ใช้::l::Allowed in IP range";
$c[4][field]="allowips";
$c[4][fieldtype]="longtext";
$c[4][descr]="";
$c[4][defval]="";

$c[6][text]="ไฟล์ภาพประชาสัมพันธ์::l::Annouce Image banner";
$c[6][field]="imgfiles";
$c[6][fieldtype]="multiplefile";
$c[6][descr]="";
$c[6][defval]="";

$c[10][text]="ภาพแบนเนอร์::l::Banner image file";
$c[10][field]="bannerfile";
$c[10][fieldtype]="singlefile";
$c[10][descr]="";
$c[10][defval]="";

$c[14][text]="ภาพพื้นหลังเมนู::l::Menu Background";
$c[14][field]="menubg";
$c[14][fieldtype]="singlefile";
$c[14][descr]="";
$c[14][defval]="";

$c[15][text]="ภาพพื้นหลังของเพจ::l::Page Background";
$c[15][field]="pageimgbg";
$c[15][fieldtype]="singlefile";
$c[15][descr]="";
$c[15][defval]="";

$c[11][text]="สลิปการยืม::l::Check out slip";
$c[11][field]="coslip";
$c[11][fieldtype]="foreign2:code,name,select * from printtemplate_sub where pid='selfcheckio_out' ";
$c[11][descr]="";
$c[11][defval]="";

$c[12][text]="สลิปการคืน::l::Check in slip";
$c[12][field]="coslip";
$c[12][fieldtype]="foreign2:code,name,select * from printtemplate_sub where pid='mat_checkedout' ";
$c[12][descr]="";
$c[12][defval]="";


//dsp



$dsp[2][text]="รายละเอียด::l::Detail";
$dsp[2][field]="id";
$dsp[2][filter]="module:localdet";
$dsp[2][width]="20%";
function localdet($wh) {
	$s="";
	$s.="<b>".getlang($wh[name])."</b><br> $wh[code]";
	return $s;
}

$dsp[3][text]="เรียกใช้::l::Open";
$dsp[3][align]="center";
$dsp[3][field]="id";
$dsp[3][filter]="module:localopen";
$dsp[3][width]="10%";
function localopen($wh) {
	$s="";
	$s.="<a href=\"run.php?id=$wh[id]\" class='a_btn bigger' target=_blank>".getlang("เรียกใช้::l::Open")."</a>";
	return $s;
}

$dsp[4][text]="ตั้งค่า::l::settings";
$dsp[4][align]="center";
$dsp[4][field]="id";
$dsp[4][filter]="module:localcfg";
$dsp[4][width]="40%";
function localcfg($wh) {
	$s="";
	$s.=localcfg_sub(getlang("ยืม-สแกนบาร์โค้ดสมาชิก"),$wh[id]."-out_scanmemberbc");
	$s.=localcfg_sub(getlang("ยืม-กรุณาใส่รหัสผ่าน"),$wh[id]."-out_enterpassword");
	$s.=localcfg_sub(getlang("ยืม-กรุณาสแกนบาร์โค้ดทรัพยากร"),$wh[id]."-out_scanmatbc");
	$s.=localcfg_sub(getlang("คืน-สแกนบาร์โค้ดทรัพยากร"),$wh[id]."-in_scanmatbc");
	$s.=localcfg_sub(getlang("ข้อความใต้ปุ่มหลัก"),$wh[id]."-main_belowmainbtn");
	$s.=localcfg_sub(getlang("สีพื้นหลัง"),$wh[id]."-pagebgcol","color");
	//$s.=localcfg_sub(getlang("ข้อความส่วนหัว"),"main_bartoptext","text");
	return $s;
}
function localcfg_sub($name,$item,$mode="html") {
	$s.=" <a href=\"pagehtml.php?code=$item&mode=$mode\" class='a_btn smaller2' rel='gb_page_fs[]' >".$name."</a> ";
	return $s;
}


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot(); 
?>