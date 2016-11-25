<?php 
	; 
        include ("../inc/config.inc.php");
        include ("./_REQPERM.php");
        include ("./cfg.inc.php");
		/*if (barcodeval_get("webpage-indexphotonews_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}*/
		head();
		if (loginchk_lib("check")) {
			mn_lib();
		} else {
			mn_web("indexphotonews");
		}
		if ($cate=="") {
			$cate="news";
		}
		include($dcrs."webbox/topmenu.php");

?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php include("menu.php");?></TD>
	<TD><?php 
	pagesection($catenamedb[$cate],"article");
$tbname="webpage_indexphotonews";
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
$c[7][descr]=" *.JPG only 570x".barcodeval_get("webpage-indexphotonews_setheight")." px";
$c[7][defval]="";

$c[15][text]="ลิงค์ข่าวไปยัง::l::Link directly when click";
$c[15][field]="linkto";
$c[15][fieldtype]="text";
$c[15][descr]=getlang("หากใส่ URL ในช่องนี้จะลิงค์ไปยัง URL โดยตรงโดยไม่เห็นเนื้อหาข่าว::l::Link to this URL directly when click");
$c[15][defval]="";

$c[11][text]="ไฟล์แนบ::l::Attatch file";
$c[11][field]="attatchfile";
$c[11][fieldtype]="singlefile";
$c[11][descr]="";
$c[11][defval]="";

$c[3][text]="จัดไว้ที่::l::Set Category";
$c[3][field]="cate";
$c[3][fieldtype]="list:news,Hidden";
$c[3][descr]="";
$c[3][defval]="";

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

$c[4][text]="รายละเอียด::l::Detail";
$c[4][field]="text";
$c[4][fieldtype]="html";
$c[4][addon]="globalupload::";
$c[4][descr]="";
$c[4][defval]="";

$c[14][text]="";
$c[14][field]="memid";
$c[14][fieldtype]="addcontrol";
$c[14][descr]="";
$c[14][defval]=$useradminid;


///////////

$dsp[2][text]="รายการข่าว::l::News";
$dsp[2][field]="memid";
$dsp[2][filter]="module:local_display";
$dsp[2][align]="left";

function local_display($wh) {
	global $dcrURL;
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


$o[tablewidth]="100%";

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

$html_htmlarea_width=610;
fixform_tablelister($tbname," $addsql ",$dsp,"$permm","$permm","$permm","cate=$cate",$c," dt desc ",$o);

	?></TD>
</TR>
</TABLE>
<?php 
				foot();
?>