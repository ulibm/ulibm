<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");

mn_lib();

$tbname="eventsreg";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ข้อความเพิ่มเติม::l::Description";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ข้อความหลัก::l::Main text";
$c[4][field]="bodys";
$c[4][fieldtype]="html";
$c[4][descr]="";
$c[4][defval]="";
$c[4][addon]="globalupload::";

$c[7][text]="ข้อความหลักท้ายเพจ::l::Footer text";
$c[7][field]="bodye";
$c[7][fieldtype]="longtext";
$c[7][descr]="";
$c[7][defval]="";


$c[5][text]="เริ่มให้สมัครเมื่อ::l::Start allow reg.";
$c[5][field]="dts";
$c[5][fieldtype]="datetime";
$c[5][descr]="";
$c[5][defval]=time();

$c[8][text]="สิ้นสุดการรับสมัคร::l::End registration";
$c[8][field]="dte";
$c[8][fieldtype]="datetime";
$c[8][descr]="";
$c[8][defval]=time()+(30*80*80*24);


$c[6][text]="จำนวนผู้เข้าร่วมสูงสุด::l::Max Participants";
$c[6][field]="maxreg";
$c[6][fieldtype]="number";
$c[6][descr]="";
$c[6][defval]="";
//dsp
/*
$dsp[4][text]="Icon::l::Icon";
$dsp[4][field]="icon";
$dsp[4][width]="10%";
*/
$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";
$dsp[2][filter]="module:localname";
/*
$dsp[3][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[3][field]="descr";
$dsp[3][width]="30%";*/

$dsp[7][text]="คำขอเพิ่มเติม::l::More Requests";
$dsp[7][field]="name";
$dsp[7][align]="center";
$dsp[7][filter]="linkout:./requests.php?pid=[value-id]";
$dsp[7][width]="15%";


$dsp[5][text]="กิจกรรมย่อย::l::Events";
$dsp[5][field]="name";
$dsp[5][align]="center";
$dsp[5][filter]="linkout:./sub.php?pid=[value-id]";
$dsp[5][width]="15%";


$dsp[6][text]="ข้อมูลผู้ใช้::l::User's Info";
$dsp[6][field]="name";
$dsp[6][align]="center";
$dsp[6][filter]="linkout:./userinfo.php?pid=[value-id]";
$dsp[6][width]="16%";

function localname($wh) {
				 global $dcrURL;
				 $c=tmq("select id from eventsreg_reg where pid='$wh[id]' and lower(isallowed)<>'yes' ");
				 $cc=tnr($c);
				 $c2=tmq("select id from eventsreg_reg where pid='$wh[id]' and lower(isallowed)='yes' ");
				 $c2c=tnr($c2);
				 return stripslashes($wh[name])." <a href='$dcrURL"."library.eventsreg/view/index.php?id=$wh[id]' target=_blank class=smaller>view</a> 
				 <a href='manreq.php?pid=$wh[id]' class=smaller>ผู้สมัคร ($cc/$c2c)</a>  ";
}

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?>