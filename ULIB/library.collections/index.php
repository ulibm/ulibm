<?php 
include("../inc/config.inc.php");
head();
	$_REQPERM="collections";
	$tmp=mn_lib();
	pagesection($tmp);

$tbname="collections";


$c[2][text]="ชื่อคอลเล็กชั่น::l::Collection name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[20][text]="โค้ด::l::Code";
$c[20][field]="classid";
$c[20][fieldtype]="text";
$c[20][descr]="";
$c[20][defval]="";

$c[3][text]="ข้อความเพิ่มเติม::l::Description";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[21][text]="เลือกโดยการกำหนดโดยตรงเท่านั้น::l::Set collection only by select mannually";
$c[21][field]="controlbyselect";
$c[21][fieldtype]="list:no,yes";
$c[21][descr]="";
$c[21][defval]="";

$c[4][text]="ต้องมีแท็ก E-connect หรือไม่::l::Require tag E-connect";
$c[4][field]="isreqeconnect";
$c[4][fieldtype]="list:no,yes";
$c[4][descr]="";
$c[4][defval]="no";

$c[5][text]="ประเภทวัสดุ 1::l::Media type 1";
$c[5][field]="req_mdtype1";
$c[5][fieldtype]="foreign:-localdb-,media_type,code,name,allowblank";
$c[5][descr]=" หรือ ";
$c[5][defval]="";

$c[6][text]="ประเภทวัสดุ 2::l::Media type 2";
$c[6][field]="req_mdtype2";
$c[6][fieldtype]="foreign:-localdb-,media_type,code,name,allowblank";
$c[6][descr]=" หรือ ";
$c[6][defval]="";

$c[7][text]="ประเภทวัสดุ 3::l::Media type 3";
$c[7][field]="req_mdtype3";
$c[7][fieldtype]="foreign:-localdb-,media_type,code,name,allowblank";
$c[7][descr]="";
$c[7][defval]="";

$c[9][text]="ประเภท Fulltext::l::Fulltext type";
$c[9][field]="req_fttype";
$c[9][fieldtype]="foreign:-localdb-,media_fttype,code,name,allowblank";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="สถานที่จัดเก็บ::l::Shelves";
$c[10][field]="req_place";
$c[10][fieldtype]="frm_itemplace";
$c[10][descr]="";
$c[10][defval]="";

$c[100][text]="สถานะไอเทม::l::Item status";
$c[100][field]="req_mdstatus";
$c[100][fieldtype]="foreign:-localdb-,media_mid_status,code,name";
$c[100][descr]="";
$c[100][defval]="";

$c[8][text]="Icon";
$c[8][field]="icon";
$c[8][fieldtype]="listimgfile:/neoimg/collectionicon/";
$c[8][descr]="";
$c[8][defval]="Documents.png";
$c[8][addon]="list-previewimg:$dcrURL"."neoimg/collectionicon,64,";

//dsp
function localicon($wh) {
	global $dcrURL;
	return "<img src='$dcrURL/neoimg/collectionicon/$wh[icon]' width=48 height=48>";
}

$dsp[1][text]="ไอคอน::l::Icon";
$dsp[1][filter]="module:localicon";
$dsp[1][field]="icon";
$dsp[1][width]="3%";

$dsp[2][text]="ชื่อคอลเล็กชั่น::l::Collection name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[3][field]="descr";
$dsp[3][width]="30%";



fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);


///autoupdate for ulibclient module
tmq("delete from ulibclient_module where code like 'collections-%' ");
$s=tmq("select * from $tbname order by name");
while ($r=tmq_fetch_array($s)) {
	tmq("insert into ulibclient_module set 
	code='collections-basic-$r[id]',
	name='คอลเล็กชั่น:".addslashes(getlang($r[name],"th"))." (Basic Search)::l::Collection:".addslashes(getlang($r[name],"en"))." (Basic Search)' ,
	url='collections.php?instantset=$r[id]&setforcehpmode=search'
	");
	tmq("insert into ulibclient_module set 
	code='collections-adv-$r[id]',
	name='คอลเล็กชั่น:".addslashes(getlang($r[name],"th"))." (Adv. Search)::l::Collection:".addslashes(getlang($r[name],"en"))." (Adv. Search)' ,
	url='collections.php?instantset=$r[id]&setforcehpmode=advsearch'
	");
	tmq("insert into ulibclient_module set 
	code='collections-bti-$r[id]',
	name='คอลเล็กชั่น:".addslashes(getlang($r[name],"th"))." (Browse , by Title)::l::Collection:".addslashes(getlang($r[name],"en"))." (Browse , by Title)' ,
	url='collections.php?instantset=$r[id]&setforcehpmode=browsetitle'
	");
	tmq("insert into ulibclient_module set 
	code='collections-bau-$r[id]',
	name='คอลเล็กชั่น:".addslashes(getlang($r[name],"th"))." (Browse , by Author)::l::Collection:".addslashes(getlang($r[name],"en"))." (Browse , by Author)' ,
	url='collections.php?instantset=$r[id]&setforcehpmode=browseauthor'
	");
	tmq("insert into ulibclient_module set 
	code='collections-webbox-$r[id]',
	name='คอลเล็กชั่น:".addslashes(getlang($r[name],"th"))." (Webbox)::l::Collection:".addslashes(getlang($r[name],"en"))." (Webbox)' ,
	url='collections.php?instantset=$r[id]&setforcehpmode=webbox'
	");	
}
foot();
?>