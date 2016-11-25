<?php 
;
        include ("../inc/config.inc.php");
html_start();
$_REQPERM="webbox";
mn_lib();

$localcatehead="yes";
$parent=floor($parent);

pagesection("จัดการข้อมูล เมนูเว็บไซต์::l::Manage Webpage Menu");
function loca_path($id) {
	if (floor($id)==0) {
		echo  "<a href='h_menu.php?parent=$id'>Main</a>  ";
		return;
	}
	$s=tmq("select * from webbox_topmenu where id='$id'");
	$s=tfa($s);
	loca_path($s[parent]);
	echo " -&gt; ";
	echo "<a href='h_menu.php?parent=$id'>".getlang(stripslashes($s[name]))."</a>";
	//printr($s);
}
if ($parent!=0) {
	$s=tmq("select * from webbox_topmenu where id='$parent' ");
	$s=tfa($s);
	?><center><?php  //echo getlang("เมนูย่อยของ::l::Manage sub menu")." : ".stripslashes($s[name]);
	
	loca_path($s[id]);

?></center><?php 
}


$tbname="webbox_topmenu";


$c[2][text]="ข้อความ::l::Text";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[7][text]="ข้อความอธิบาย::l::Description";
$c[7][field]="descr";
$c[7][fieldtype]="text";
$c[7][descr]="แสดงเมื่อเอาเมาส์วาง::l::Display on mouse over";
$c[7][defval]="";

$c[3][text]="เรียงลำดับ::l::Order";
$c[3][field]="ordr";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="";



$c[9][text]="ประเภท::l::Type";
$c[9][field]="type";
$c[9][fieldtype]="foreign:-localdb-,webbox_topmenu_type,code,name";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="แสดงเมนูนี้หรือไม่::l::Show this menu";
$c[10][field]="isshow";
$c[10][fieldtype]="list:yes,no";
$c[10][descr]="";
$c[10][defval]="yes";

$c[11][text]="";
$c[11][field]="parent";
$c[11][fieldtype]="addcontrol";
$c[11][descr]="";
$c[11][defval]=$parent;

$c[12][text]="AccessKey";
$c[12][field]="accesskey";
$c[12][fieldtype]="text";
$c[12][descr]="";
$c[12][defval]="";
/*
$c[11][text]="บทความในหัวข้อ เรียงตามอะไร::l::Order articles by";
$c[11][field]="orderby";
$c[11][fieldtype]="list:lastactive,topicname";
$c[11][descr]="";
$c[11][defval]="yes";*/
/*
$c[8][text]="Icon";
$c[8][field]="icon";
$c[8][fieldtype]="listimgfile:/neoimg/webpagemenu/";
$c[8][descr]="";
$c[8][defval]="Folder_Generic.png";
$c[8][addon]="list-previewimg:$dcrURL"."/neoimg/webpagemenu,64,";
*/
//dsp
/*
function localicon($wh) {
	global $dcrURL;
	return "<img src='$dcrURL/neoimg/webpagemenu/$wh[icon]' width=48 height=48>";
}

$dsp[1][text]="ไอคอน::l::Icon";
$dsp[1][filter]="module:localicon";
$dsp[1][field]="icon";
$dsp[1][width]="5%";*/

$dsp[5][text]="order::l::order";
$dsp[5][field]="ordr";
$dsp[5][width]="5%";

$dsp[2][text]="ข้อความ::l::Text";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[4][text]="จัดการ::l::Manage";
$dsp[4][field]="id";
$dsp[4][align]="center";
$dsp[4][filter]="module:localmanage";
$dsp[4][width]="30%";

$dsp[3][text]="ประเภท::l::Type";
$dsp[3][align]="center";
$dsp[3][field]="type";
$dsp[3][filter]="foreign:-localdb-,webbox_topmenu_type,code,name";
$dsp[3][width]="20%";

function localmanage($wh) {
   $addall="";
   if (trim($wh[accesskey])!="") {
      $addall.="[<b style='color:red'>$wh[accesskey]</b>] ";
   }
   
   
	$addallc=tnr(tmq("select * from webbox_topmenu where parent='$wh[id]' "));
	$addall.="<a href='index.php?parent=$wh[id]' class='a_btn smaller2' >".getlang("เมนูย่อย::l::Sub menu")." ($addallc)</a><br>";
	if ($wh[type]=="webboard") {
		return "<CENTER>$addall<A HREF='h_menu_descr.php?id=$wh[id]'><B>".getlang("แก้ไขตัวเลือก::l::Manage options")."</B></A></CENTER>";
	}
	if ($wh[type]=="wiki") {
		$inf=tmq("select * from webbox_topmenu_wiki  where refid='$wh[id]' ");
		if (tmq_num_rows($inf)==0) {
			$addstr=getlang("ยังไม่ได้กำหนดหัวข้อ::l::Not spec. Wiki");;
		} else {
			$addstr=tmq_fetch_array($inf);
			$addstr=mb_substr($addstr[text],0,20).'..,';
		}
		return "<CENTER>$addall<FONT  COLOR=666666 class=smaller2>[$addstr]<BR></FONT><A HREF='h_menu_wiki.php?id=$wh[id]'><B>".getlang("แก้หัวเรื่อง Wiki::l::Edit Wiki Topic")."</B></A></CENTER>";
	}
	if ($wh[type]=="content") {
		return "<CENTER>$addall<A HREF='h_menu_content.php?id=$wh[id]'><B>".getlang("จัดการเนื้อหา::l::Manage")."</B></A></CENTER>";
	}
	if ($wh[type]=="list") {
		return "<CENTER>$addall<A HREF='h_menu_list.php?pid=$wh[id]'><B>".getlang("จัดการรายการ::l::Manage List")."</B></A></CENTER>";
	}
	if ($wh[type]=="url") {
		$inf=tmq("select * from webbox_topmenu_url  where refid='$wh[id]' ");
		if (tmq_num_rows($inf)==0) {
			$addstr=getlang("ยังไม่ได้กำหนด URL::l::Not spec. url");;
		} else {
			$addstr=tmq_fetch_array($inf);
			$addstr=mb_substr($addstr[url],0,20).'..,'.$addstr[target].'';
		}

		return "<CENTER>$addall<FONT  COLOR=666666 class=smaller2>[$addstr]<BR></FONT><A HREF='h_menu_url.php?id=$wh[id]'><B>".getlang("แก้ไขการเชื่อมโยง::l::Edit Url")."</B></A></CENTER>";
	}
	return "$addall&nbsp;";
}

fixform_tablelister($tbname," 1 and parent='$parent'  ",$dsp,"yes","yes","yes","mi=$mi&parent=$parent",$c," ordr ");

foot();

?>