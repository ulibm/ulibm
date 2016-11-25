<?php 
;
include("../inc/config.inc.php");
head();
	include("_REQPERM.php");
	mn_lib();
pagesection("ตัวเลือกการส่งออก::l::Export template");

$tbname="quickstattp";

$c[1][text]="ชื่อ::l::Name";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="loginid";
$c[2][field]="loginid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$useradminid;

$c[3][text]="โครงสร้าง::l::HTML Structure";
$c[3][field]="data";
$c[3][fieldtype]="longtext";
$c[3][descr]="<br>".getlang("ตัวอย่าง ใช้ \$data[tag100] แทนข้อมูลในแท็ก 100 <BR> \$data[tag100_a] แทนข้อมูลในแท็ก 100 subfield a::l::Example: use \$data[tag100] for data in tag100<BR>use \$data[tag100_a] for data in tag100 subfield a");
$c[3][defval]="";

$c[4][text]="ลบเครื่องหาย Subfield::l::Remove Subfields";
$c[4][field]="removesubfield";
$c[4][fieldtype]="yesno";
$c[4][descr]="";
$c[4][defval]="yes";

$c[5][text]="HTML ส่วนหัว::l::HTML header";
$c[5][field]="htmlhead";
$c[5][fieldtype]="longtext";
$c[5][descr]="<br>".getlang("\$statname สำหรับชื่อสถิติ \$statdetail สำหรับรายละเอียดสถิติ::l::\$statname for stat name \$statdetail for stat detail");
$c[5][defval]="";

$c[6][text]="HTML ส่วนท้าย::l::HTML footer";
$c[6][field]="htmlfoot";
$c[6][fieldtype]="longtext";
$c[6][descr]="<br>".getlang("\$statname สำหรับชื่อสถิติ \$statdetail สำหรับรายละเอียดสถิติ::l::\$statname for stat name \$statdetail for stat detail");
$c[6][defval]="";


$c[7][text]="แทนที่ข้อความ::l::Replace text";
$c[7][field]="rplc";
$c[7][fieldtype]="longtext";
$c[7][descr]="<BR>".getlang("search===replacewith");
$c[7][defval]="";


$c[8][text]="Order By";
$c[8][field]="orderby";
$c[8][fieldtype]="text";
$c[8][descr]="";
$c[8][defval]="tag100";
/*

$c[5][text]="ความสูง::l::Catalogue Card Height";
$c[5][field]="h";
$c[5][fieldtype]="number";
$c[5][descr]=getlang("มิลลิเมตร::l::Millimetre");
$c[5][defval]="76.2";*/

//dsp
$dsp[1][text]="ชื่อรูปแบบ::l::Template Name";
$dsp[1][field]="name";
$dsp[1][width]="70%";

$dsp[2][text]="พิมพ์::l::Print";
$dsp[2][field]="ID";
$dsp[2][align]="center";
$dsp[2][filter]="module:localprint";
$dsp[2][width]="30%";

function localprint($wh) {
   global $subid;
   global $id;
	return "<a href='quickstattp.print.php?subid=$subid&tpidid=$wh[id]&id=$id' target=_blank class=a_btn>".getlang("Export")."</a>";
}

//echo "[$delable]";
fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","exportmode=$exportmode&id=$id&subid=$subid",$c,"",$o);
?><center><br>
	<a href="media_type.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></a></center><?php 
foot();
?>