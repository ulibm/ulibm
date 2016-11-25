<?php 
	; 
        include ("../inc/config.inc.php");

html_start();


$catedb=tmq_dump2("webbox_topmenu_list","id","name");
//printr($catedb);
pagesection(getlang("ดึงข่าวจากหัวข้อ::l::Pull news from").":".$catedb[$pid]);
?>
                <div align = "center">
<?php 

$tbname="webbox_topmenu_list_sub";


$c[2][text]="ชื่อเรื่อง::l::Title";
$c[2][field]="title";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[16][text]="ภาพหลัก::l::Cover Image";
$c[16][field]="coverimg";
$c[16][fieldtype]="singlefile";
$c[16][descr]="";
$c[16][defval]="";

$c[17][text]="ข้อความเพิ่มเติม::l::Short Description";
$c[17][field]="descr";
$c[17][fieldtype]="longtext";
$c[17][descr]="";
$c[17][defval]="";

$c[20][text]="ลิงค์ไปยัง URL::l::Direct Link to URL";
$c[20][field]="directurl";
$c[20][fieldtype]="text";
$c[20][descr]="";
$c[20][defval]="";

$c[3][text]="เนื้อหา::l::Body";
$c[3][field]="body";
$c[3][fieldtype]="html";
$c[3][addon]="globalupload::";
$c[3][descr]="";
$c[3][defval]="";

$c[19][text]="แสดงรูปทั้งหมดแบบ Slideshow::l::Slideshow all attatched photo";
$c[19][field]="globalslideshow";
$c[19][fieldtype]="yesno";
$c[19][descr]="";
$c[19][defval]="";

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

//dsp
function localicon($wh) {
	global $dcrURL;
	return "<img src='$dcrURL/neoimg/webpagemenu/$wh[icon]' width=24 height=24>";
}

$dsp[5][text]="icon";
$dsp[5][field]="icon";
$dsp[5][filter]="module:localicon";
$dsp[5][width]="5%";

$dsp[2][text]="ชื่อเรื่อง::l::Title";
$dsp[2][field]="title";
$dsp[2][width]="30%";
$dsp[2][filter]="module:localtitle";
function localtitle($wh) {
	return $wh[title]." (".ymd_datestr($wh[dt],"date").")";
}


$dsp[9][text]="แสดง?::l::Show?";
$dsp[9][field]="isshow";
$dsp[9][filter]="switchsingle";
$dsp[9][width]="10%";


fixform_tablelister($tbname," 1 and pid='$pid' ",$dsp,"yes","yes","yes","pid=$pid&parentpid=$parentpid",$c,"  dt desc "," ");

?><b><a href="h_menu_list.php?pid=<?php  echo $parentpid;?>"><center><?php  echo getlang("กลับ::l::Back");?></center></a></b><?php 


?>