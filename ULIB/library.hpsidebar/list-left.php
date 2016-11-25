<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="hpsidebar-leftcontent";
mn_lib();

$localcatehead="yes";

pagesection("จัดการข้อมูล");
$tbname="webpage_hpsidebar";


$c[2][text]="ข้อความ::l::Text";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]=" <BR>ข้อความส่วนนี้มีไว้เตือนความจำแก่ผู้ปฏิบัติงานเท่านั้น::l::Only librarian can see this text";
$c[2][defval]="";

$c[3][text]="เรียงลำดับ::l::Order";
$c[3][field]="ordr";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="locate";
$c[4][field]="locate";
$c[4][fieldtype]="addcontrol";
$c[4][descr]="";
$c[4][defval]="left";


$c[9][text]="ประเภท::l::Type";
$c[9][field]="type";
$c[9][fieldtype]="foreign:-localdb-,webpage_hpsidebar_type,code,name";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="แสดงรายการนี้หรือไม่::l::Show this item";
$c[10][field]="isshow";
$c[10][fieldtype]="list:yes,no";
$c[10][descr]="";
$c[10][defval]="yes";


//dsp
function localicon($wh) {
	global $dcrURL;
	return "<img src='$dcrURL/neoimg/webpagemenu/$wh[icon]' width=48 height=48>";
}

$dsp[5][text]="order::l::order";
$dsp[5][field]="ordr";
$dsp[5][width]="5%";

$dsp[2][text]="ข้อความ::l::Text";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[9][text]="แสดง?::l::Show?";
$dsp[9][field]="isshow";
$dsp[9][filter]="switchsingle";
$dsp[9][width]="10%";


$dsp[4][text]="จัดการ::l::Manage";
$dsp[4][field]="id";
$dsp[4][align]="center";
$dsp[4][filter]="module:localmanage";
$dsp[4][width]="20%";

$dsp[3][text]="ประเภท::l::Type";
$dsp[3][field]="type";
$dsp[3][filter]="foreign:-localdb-,webpage_hpsidebar_type,code,name";
$dsp[3][width]="30%";


function localmanage($wh) {
   //printr($wh);
	if ($wh[type]=="html") {
		return "<CENTER><A HREF='list_content.php?locate=left&id=$wh[id]'><B>".getlang("จัดการเนื้อหา::l::Manage")."</B></A></CENTER>";
	}
	if ($wh[type]=="rss") {
		return "<CENTER><A HREF='list_url.php?locate=left&id=$wh[id]'><B>".getlang("แก้ไขการเชื่อมโยง RSS::l::Edit RSS Url")."</B></A></CENTER>";
	}
	if ($wh[type]=="tab") {
		$c=tmq("select * from webpage_hpsidebar_tabs where locate='$wh[id]' ");
		$c=tmq_num_rows($c);
		return "<CENTER><A HREF='list_tab.php?locate=left&pid=$wh[id]'><B>".getlang("ข้อมูลที่จะแสดง::l::Data to display")."</B></A> ($c)</CENTER>";
	}
}

fixform_tablelister($tbname," 1 and locate='left' ",$dsp,"yes","yes","yes","locate=left",$c," ordr ");

foot();

?>