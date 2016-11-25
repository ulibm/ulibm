<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
head();
include("topmenu.php");
mn_web("webpage");
?><center><?php 
$news=floor($news);
if($news!=0) {
	quickeditwebtext("webbox-newslist_read_befor","$_TBWIDTH");

	$s=tmq("select * from webbox_newslist_list where id='$news' and isshow='yes' ");
	if (tnr($s)==1) {
		$s=tfa($s);
		?>
		<table align=center width=<?php  echo $_TBWIDTH-200;?>>
		<tr>
			<td><?php 
			echo "<font style=\"font-size: 22px;\">".stripslashes($s[title])."</font>";
		echo "<br>";
			echo ymd_datestr($s[dt],"date");
			if (loginchk_lib("check")) {
				?><a href="<?php  echo $dcrURL;?>webbox/man.box.newslist.php?pid=<?php  echo $s[pid]?>&cate=<?php  echo $pid?>&fftmode=edit&ffteditid=<?php  echo $s[id]?>&startrow=0" class=a_btn target=_blank><?php  echo getlang("แก้ไข::l::Edit");?></a><?php 
			}
			echo "<br>";
			echo getlang("โดย::l::by")." ".html_library_name($s[loginid]);
			echo "<br>";
			echo str_webpagereplacer(stripslashes($s[body]));
			if (strtolower($s[globalslideshow])=="yes") {
				html_ugallery("webbox_newslist_list-$s[id]",800);
			}
		?></td>
		</tr>
		</table>
		<?php 
	}
}

	quickeditwebtext("webbox-newslist_read_after","$_TBWIDTH");


$catemap=tmq("select * from webbox_newslist_catemap where pid='$pid' ");
$catemap=tfa($catemap);
//printr($catemap);
$cate=$catemap[cate];
$catedb=tmq_dump2("webbox_newslist_cate","id","name");
pagesection(getlang("หัวข้อ::l::Category").":".$catedb[$cate]);

$tbname="webbox_newslist_list";


$c[2][text]="ชื่อเรื่อง::l::Title";
$c[2][field]="title";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="เนื้อหา::l::Body";
$c[3][field]="body";
$c[3][fieldtype]="html";
$c[3][addon]="globalupload::";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="วันเวลา::l::Date";
$c[4][field]="dt";
$c[4][fieldtype]="date";
$c[4][descr]="";
$c[4][defval]=time();


$c[9][text]="autoofficer";
$c[9][field]="loginid";
$c[9][fieldtype]="autoofficer";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="Icon";
$c[10][field]="icon";
$c[10][fieldtype]="listimgfile:/neoimg/webpagemenu/";
$c[10][descr]="";
$c[10][defval]="Folder_Generic.png";
$c[10][addon]="list-previewimg:$dcrURL"."/neoimg/webpagemenu,64,";

$c[11][text]="แสดงรายการนี้หรือไม่::l::Show this item";
$c[11][field]="isshow";
$c[11][fieldtype]="yesno";
$c[11][descr]="";
$c[11][defval]="yes";

$c[12][text]="Icon";
$c[12][field]="tailicon";
$c[12][fieldtype]="listimgfile:/neoimg/gificon/";
$c[12][descr]="";
$c[12][defval]="None.png";
$c[12][addon]="list-previewimg:$dcrURL"."/neoimg/gificon,32,";

$c[14][text]="-";
$c[14][field]="pid";
$c[14][fieldtype]="addcontrol";
$c[14][descr]="";
$c[14][defval]=$pid;

$c[15][text]="หัวข้อข่าว::l::Category";
$c[15][field]="cate";
$c[15][fieldtype]="foreign:-localdb-,webbox_newslist_cate,id,name";
$c[15][descr]="";
$c[15][defval]=$cate;

//dsp

$dsp[2][text]="ชื่อเรื่อง::l::Title";
$dsp[2][field]="title";
$dsp[2][width]="30%";
$dsp[2][filter]="module:localtitle";
function localtitle($wh) {
	global $dcrURL;
	global $pid;
	return "<img src='$dcrURL/neoimg/webpagemenu/$wh[icon]' width=24 height=24> 
	<a href=\"man.box.newslist.readall.php?pid=$pid&news=$wh[id]\">".
		stripslashes($wh[title])."</a> (".ymd_datestr($wh[dt],"date").")";
}

/*
$dsp[9][text]="แสดง?::l::Show?";
$dsp[9][field]="isshow";
$dsp[9][filter]="switchsingle";
$dsp[9][width]="10%";
*/

if (loginchk_lib("check")) {
?><table align=center width=<?php  echo $_TBWIDTH?>><tr><td>
<a href="man.box.newslist.php?pid=<?php  echo $s[pid]?>&cate=<?php  echo $s[cate]?>&fftmode=add&startrow=0" class=a_btn target=_top><?php  echo getlang("เพิ่มรายการใหม่::l::Add new");?></a>
</td></tr></table><?php 
}
fixform_tablelister($tbname," 1 and cate='$cate' ",$dsp,"no","no","no","pid=$pid&cate=$cate",$c," id desc ");

quickeditwebtext("webbox-newslist_read_foot","$_TBWIDTH");


foot();
?>