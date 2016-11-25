<?php 
;
        include ("../inc/config.inc.php");
html_start();
$_REQPERM="webbox";
mn_lib();
if ($pid=="") {
	die("no pid");
}
$localcatehead="yes";
$taginfo=tmq("select * from webbox_box where id='$pid' ");
$taginfo=tmq_fetch_array($taginfo);
//echo $taginfo[name];

pagesection("จัดการข้อมูลในแท็บ: $taginfo[name]");
$tbname="webbox_boxtab_tabs";


$c[2][text]="ข้อความ::l::Text";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]=" <BR>ข้อความที่จะแสดงที่หัวแท็บ::l::Text to display at tab head";
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
$c[4][defval]=$pid;


$c[9][text]="ประเภท::l::Type";
$c[9][field]="type";
$c[9][fieldtype]="foreign:-localdb-,webbox_tabs_type,code,name";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="แสดงรายการนี้หรือไม่::l::Show this item";
$c[10][field]="isshow";
$c[10][fieldtype]="yesno";
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
$dsp[3][filter]="foreign:-localdb-,webbox_tabs_type,code,name";
$dsp[3][width]="30%";

        
function localmanage($wh) {
	global $pid;
	global $locate;
	if ($wh[type]=="html") {
		return "<CENTER><A HREF='man.box.tab.html.php?locate=$locate&id=$wh[id]&pid=$pid'><B>".getlang("จัดการเนื้อหา::l::Manage")."</B></A></CENTER>";
	}
	if ($wh[type]=="rss") {
		return "<CENTER><A HREF='man.box.tab.rss.php?locate=$locate&id=$wh[id]&pid=$pid'><B>".getlang("แก้ไขการเชื่อมโยง RSS::l::Edit RSS Url")."</B></A></CENTER>";
	}

}

fixform_tablelister($tbname," 1 and locate='$pid' ",$dsp,"yes","yes","yes","pid=$pid",$c," ordr ");


?><CENTER><A HREF="javascript:top.location.reload();" style="font-size:20"><?php  echo getlang("กลับ::l::Back");?></A></CENTER>