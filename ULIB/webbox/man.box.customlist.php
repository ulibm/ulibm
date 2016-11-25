<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
	 $_REQPERM="webbox";
	 mn_lib();
$setnewscate=floor($setnewscate);
if ($setnewscate!=0) {
	tmq("delete from webbox_customlist_catemap where pid='$pid' ");
	tmq("insert into webbox_customlist_catemap set pid='$pid',cate='$setnewscate',displayformat='$displayformat',showcount='$showcount',readmoretxt='$readmoretxt' ");
}

$catemap=tmq("select * from webbox_customlist_catemap where pid='$pid' ");
$catemap=tfa($catemap);
//printr($catemap);
$cate=$catemap[cate];
$catedb=tmq_dump2("webbox_customlist_cate","id","name");
pagesection(getlang("ดึงข่าวจากหัวข้อ::l::Pull news from").":".$catedb[$cate]);
?>
                <div align = "center">
<?php 
if ($issave=="yes") {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.location.reload();
	//-->
	</SCRIPT><?php 
	die;
}


$tbname="webbox_customlist_list";


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

$c[15][text]="หัวข้อข่าว::l::Category";
$c[15][field]="cate";
$c[15][fieldtype]="foreignwithsub:-localdb-,webbox_customlist_cate,id,name,allowblank:-localdb-,webbox_customlist_catesub,id,name:id,cateid";
$c[15][descr]="";
$c[15][defval]=$cate;

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
   global $dcrURL;
	$tmp= "<a href='$dcrURL"."webbox/man.box.customlist.readall.php?pid=$wh[pid]&news=$wh[id]' target=_blank>".$wh[title]."</a> (".ymd_datestr($wh[dt],"date").")";
   $oldvals=tmq("select * from   webbox_customlist_catesub where id='$wh[cate]' ",false);
   $oldvals=tfa($oldvals);
   $oldvalsparent=tmq("select * from webbox_customlist_cate where id='$oldvals[cateid]' ",false);
   $oldvalsparent=tfa($oldvalsparent);	
   $tmp.="<BR><font class=smaller>$oldvalsparent[name] -&gt; $oldvals[name]</font>";
	return $tmp;
}


$dsp[9][text]="แสดง?::l::Show?";
$dsp[9][field]="isshow";
$dsp[9][filter]="switchsingle";
$dsp[9][width]="10%";


?><center><form method="post" action="man.box.customlist.php">
<input type="hidden" name="pid" value="<?php  echo $pid?>">
	<?php  echo getlang("ให้กล่องนี้ดึงข้อมูลจาก::l::Pull news for this box from ");
	form_quickedit("setnewscate",$cate,"foreign:-localdb-,webbox_customlist_cate,id,name");
	?> <input type="submit" value="Save"> <a href="man.box.customlist.cate.php?pid=<?php  echo $pid;?>" class="smaller a_btn"><?php  echo getlang("จัดการ::l::Manage")?></a><br>
	<?php 
	echo getlang("รูปแบบการแสดง::l::Display"); 
	form_quickedit("displayformat",$catemap[displayformat],"list:List,Grid,Grid_2_column,1_Row,2_Columns,Sliding_Cover");
	echo getlang("จำนวนรายการที่แสดง ::l::Number of news "); 
	form_quickedit("showcount",$catemap[showcount],"number");
	echo "<br>";
	echo getlang("ข้อความอ่านต่อ ::l::Read more text "); 
	form_quickedit("readmoretxt",$catemap[readmoretxt],"text");
	?>
</form></center><?php 
if ($cate=="") {
	html_dialog("Checking",getlang("กรุณาเลือกหัวข้อข่าวด้านบนก่อน::l::Choose category first"));
	die;
}

fixform_tablelister($tbname," 1 and cate in (select id from webbox_customlist_catesub where cateid='$cate') ",$dsp,"yes","yes","yes","pid=$pid&cate=$cate",$c,"  dt desc "," limit 7");



?>