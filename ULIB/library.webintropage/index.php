<?php 
	; 
        include ("../inc/config.inc.php");
        include ("./_REQPERM.php");

		head();
		$tmp=mn_lib();

	pagesection($tmp);
$tbname="webpage_webintropage";
$c=Array();
$c[2][text]="หัวข้อ::l::Title";
$c[2][field]="title";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="";
$c[3][field]="memid";
$c[3][fieldtype]="addcontrol";
$c[3][descr]="";
$c[3][defval]=$useradminid;

$c[7][text]="ภาพข่าว::l::Cover Image";
$c[7][field]="coverimg";
$c[7][fieldtype]="singlefile";
$c[7][descr]=" *.JPG only 800x500 px";
$c[7][defval]="";

$c[15][text]="ลิงค์ข่าวไปยัง::l::Link directly when click";
$c[15][field]="linkto";
$c[15][fieldtype]="text";
$c[15][descr]="";
$c[15][defval]="";


$c[5][text]="เริ่มต้นแสดงข่าวเมื่อ::l::Start display this news";
$c[5][field]="dtstart";
$c[5][fieldtype]="datetime";
$c[5][descr]="";
$c[5][defval]=time();

$c[6][text]="จนถึง::l::Stop display this news";
$c[6][field]="dtend";
$c[6][fieldtype]="datetime";
$c[6][descr]="";
$c[6][defval]=time()+(60*60*24*10);

$c[10][text]="";
$c[10][field]="dt";
$c[10][fieldtype]="addcontrol";
$c[10][descr]="";
$c[10][defval]=time();



///////////

$dsp[2][text]="รายการข่าว::l::News";
$dsp[2][field]="memid";
$dsp[2][filter]="module:local_display";
$dsp[2][align]="left";

function local_display($wh) {
	global $tbname;
	global $cate;
	$img=fft_upload_get($tbname,"coverimg",$wh[id]);
	//printr($img);
	$s="<img src='$img[url]' align=left width=100>";
	$wh[title]=trim($wh[title]);
	if ($wh[title]=="") {
		$wh[title]="<I>- no title -</I>";
	}
	//$s.="<A HREF='view.php?id=$wh[id]&cate=$cate'>";
			if ($wh[linkto]!="") {
				$s.= "<A HREF='$wh[linkto]' target=_blank TITLE='".stripslashes($wh[title])."'>";
			} else {
				$s.= "<A HREF='$dcrURL/library.indexphotonews/view.php?id=$wh[id]&cate=$cate' target=_top TITLE='".stripslashes($wh[title])."'>";
			}
	$s.="$wh[title]</A><BR> <FONT class=smaller>&nbsp;&nbsp;".getlang("โดย::l::By");
		$s.=" ".(get_library_name($wh[memid]));
	$s.="</FONT><FONT class=smaller2><BR>&nbsp;&nbsp;".getlang("เมื่อ::l::since");
	$s.=ymd_datestr($wh[dt]) . " (" .ymd_ago($wh[dt]).")</FONT>";
	return $s;
}



if ($fftmode=="delete") {
	@unlink("./attatch/$fftdeleteid-1.jpg");
	@unlink("./attatch/$fftdeleteid-2.jpg");
}
$addsql=" 1 "; 
if ($cate=="news") {
	$addsql=" 1 ";
}

if ($cate=="displaying") {
	$now=time();
	$addsql="  cate='news' and dtstart<=$now and dtend>=$now ";
}
if ($cate=="hide") {
	$addsql="  cate='hidden'  ";
}

if (library_gotpermission("webpage-indexphotonews")) {
	$permm="yes";
} else {
	$permm="no";
}

fixform_tablelister($tbname," $addsql ",$dsp,"$permm","$permm","$permm","cate=$cate",$c," dt desc ",$o);

				foot();
?>