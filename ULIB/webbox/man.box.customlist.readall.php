<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
head();
include("topmenu.php");
mn_web("webpage");
$news=floor($news);
$cursubcate=floor($cursubcate);
//
if ($news==0) { // get cate from box info
   if ($cursubcate==0) { // subcate not clicked
      $catemap=tmq("select * from webbox_customlist_catemap where pid='$pid' ",false);
      $catemap=tfa($catemap);
      $cateparent=tmq("select * from webbox_customlist_cate where id='$catemap[cate]' ");
      $cateparent=tfa($cateparent);
      $currentcateparent=$cateparent[id];
   } else { //link from subcate link
      $subcate=tmq("select * from webbox_customlist_catesub where id='$cursubcate' ");
      $subcate=tfa($subcate);
      $cateparent=tmq("select * from webbox_customlist_cate where id='$subcate[cateid]' ");
      $cateparent=tfa($cateparent);
      $currentcateparent=$cateparent[id];
   }
} else { //get cate from news
   $s=tmq("select * from webbox_customlist_list where id='$news' and isshow='yes' ");
   $s=tfa($s);//printr($s);
   $cate=tmq("select * from webbox_customlist_catesub where id='$s[cate]' ");
   $cate=tfa($cate); //printr($cate);
   $cateparent=tmq("select * from webbox_customlist_cate where id='$cate[cateid]' ");
   $cateparent=tfa($cateparent);
   $currentcateparent=$cateparent[id];
   $cursubcate=$s[cate];
}
//echo "[cursubcate=$cursubcate]";
//printr($cateparent);
?><center>
		<table align=center width=<?php  echo $_TBWIDTH?> border=0 style="margin-top: 10px;">
		<tr valign=top><td width=200 >
		
		<table width=100% cellpadding=0 cellspacing=1 bgcolor=#eeeeee><tr><td align=center
		style="background-color: #f5f5f5; padding: 5px;;"
		><?php 
		echo "".getlang($cateparent[name])."";
		echo "<BR>";
		?></td></tr>
		<tr><td bgcolor=white style="padding: 5px;"><?php 
   $curcate=tmq("select * from   webbox_customlist_catesub where cateid='$currentcateparent' ",false);

   while ($curcater=tfa($curcate)) {
      if ($cursubcate==$curcater[id]) {
         echo "<b>";
      }
      ?> &bull; <a href='<?php echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $pid; ?>&cursubcate=<?php  echo $curcater[id]; ?>'><?php 
      echo getlang($curcater[name])."";
      ?></a><?php 
      if ($cursubcate==$curcater[id]) {
         echo "</b>";
      }

      ?><br><?php 
   }
		?></td></tr></table>
<?php 
if (loginchk_lib("check")) {
?><A HREF="<?php echo $dcrURL;?>webbox/man.box.customlist.cate.php?pid=<?php  echo $pid;?>" class="smaller a_btn"  rel="gb_page_fs[]"><?php  echo getlang("แก้ไขหัวข้อ::l::Edit category");?></a><?php 
}
?>		
		
		</td>
			<td style="margin-left: 6px;">
<?php 
$news=floor($news);
	quickeditwebtext("webbox-customlist_read_befor",$_TBWIDTH-200);
if($news!=0) {
	quickeditwebtext("webbox-customlist_read_befor-$currentcateparent",$_TBWIDTH-200);
	$s=tmq("select * from webbox_customlist_list where id='$news' and isshow='yes' ");
	if (tnr($s)==1) {
		$s=tfa($s);
		?>
		
		
		<table align=center width=100% border=0>
		<tr>
			<td><?php 
			echo "<font style=\"font-size: 22px;\">".stripslashes($s[title])."</font>";
		echo "<br>";
			echo "<font class=smaller>".ymd_datestr($s[dt],"date")."</font>";
			if (loginchk_lib("check")) {
				?><a href="<?php  echo $dcrURL;?>webbox/man.box.customlist.php?pid=<?php  echo $s[pid]?>&cate=<?php  echo $pid?>&fftmode=edit&ffteditid=<?php  echo $s[id]?>&startrow=0" class=a_btn target=_blank><?php  echo getlang("แก้ไข::l::Edit");?></a><?php 
			}
			echo "<br>";
         $oldvals=tmq("select * from   webbox_customlist_catesub where id='$s[cate]' ",false);
         $oldvals=tfa($oldvals);
         $oldvalsparent=tmq("select * from webbox_customlist_cate where id='$oldvals[cateid]' ",false);
         $oldvalsparent=tfa($oldvalsparent);		
         echo "<font class=smaller>$oldvalsparent[name] -&gt; $oldvals[name]</font>";;		
			echo "<br>";
			echo "<font class=smaller>".getlang("โดย::l::by")." ".html_library_name($s[loginid])."</font>";
			echo "<br>";
			echo stripslashes(stripslashes($s[body]));
			if (strtolower($s[globalslideshow])=="yes") {
				html_ugallery("webbox_customlist_list-$s[id]",800);
			}
		?></td>
		</tr>
		</table>
		<?php 
	}
}
echo "<br>";
if (floor($cursubcate)==0) {
   $s=tmq("select * from webbox_customlist_list where cate in (select id from webbox_customlist_catesub where cateid='$currentcateparent') and isshow='yes'");
} else {
   $s=tmq("select * from webbox_customlist_list where cate='$cursubcate' and isshow='yes'");
}
if ($setdspcurcate=="yes") {
   barcodeval_set("webbox-currentcatedspformat-$cursubcate",$setsetdspcurcateval);
}
$currentcatedspformat=barcodeval_get("webbox-currentcatedspformat-$cursubcate");
if ($currentcatedspformat=="") {
   $currentcatedspformat="Grid";
}
/////////////////////////////////////////////////////////////////////////
if ($currentcatedspformat=="Grid") {
while ($r=tfa($s)) {
   ?><div style="display:block; width: 370px; height: 120px; float: left;">
   <a href="<?php echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $pid; ?>&news=<?php  echo $r[id]; ?>"><img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r[id]);
	echo $imgurl[url];
?>" style="width:calc(30%);; float: left; margin-right: 5px; margin-top: 5px; height: 100px;" border=0>

<?php  echo stripslashes($r[title]);?></a></div><?php 
}
?><div style="clear:both"></div>
<?php 
}
if ($currentcatedspformat=="Cover") {
while ($r=tfa($s)) {
   ?><div style="display:block; width: 250; height: 300px; float: left; text-align:center">
   <a href="<?php echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $pid; ?>&news=<?php  echo $r[id]; ?>"><img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r[id]);
	echo $imgurl[url];
?>" style="width: 180; margin: 5px; margin-top: 5px; height: 250px;" border=0><BR>

<?php  echo stripslashes($r[title]);?></a></div><?php 
}
?><div style="clear:both"></div>
<?php 
}
if ($currentcatedspformat=="Tile") {
$liststr="<table width=100%>";
while ($r=tfa($s)) {
   ?><div style="display:block; width: 155; height: 155; float: left; text-align:center; padding: 2px;">
   <a href="<?php echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $pid; ?>&news=<?php  echo $r[id]; ?>"
   TITLE="<?php  echo stripslashes($r[title]);?>"
   ><img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r[id]);
	echo $imgurl[url];
?>" style="width: 155; margin: 5px; margin-top: 5px; height: 155;" border=0><BR>

<?php  //echo stripslashes($r[title]);?>
</a></div><?php 
$liststr.="<tr><td align=right>".ymd_datestr($r[dt],"shortd")." </td><td>: <a href='$dcrURL"."webbox/man.box.customlist.readall.php?pid=$pid&news=$r[id]'> ".stripslashes($r[title])."</a></td>";
}
$liststr.="</table><BR>";

?><div style="clear:both"></div>
<?php 
echo "<BR><hr noshade>";
echo $liststr;
}
/////////////////////////////////////////////////////////////////////////
	quickeditwebtext("webbox-customlist_read_after-$cursubcate",$_TBWIDTH-200);
	quickeditwebtext("webbox-customlist_read_after",$_TBWIDTH-200);



?><div style="clear:both"></div>

<?php 
if (loginchk_lib("check")) {
?><table align=center width=100%><tr><td>
<form action="<?php  echo $dcrURL;?>webbox/man.box.customlist.readall.php" method=get>
<input type=hidden name="pid" value="<?php  echo $pid;?>">
<input type=hidden name="news" value="<?php  echo $news;?>">
<input type=hidden name="cursubcate" value="<?php  echo $cursubcate;?>">
<input type=hidden name="setdspcurcate" value="yes">
<?php  echo getlang("รูปแบบการแสดงรายการ::l::List Style");
	form_quickedit("setsetdspcurcateval",$currentcatedspformat,"list:Grid,Cover,Tile");
?> <input type=submit>
</form>
</td></tr></table><?php 
}
?>
</td>
		</tr>
		</table><?php 

		foot(); die;
		
		
		
		
		
		
		
		
		
		
		
		
		


//printr($catemap);
$cate=$catemap[cate];
$catedb=tmq_dump2("webbox_customlist_cate","id","name");
pagesection($catedb[$cate]);

$tbname="webbox_customlist_list";


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
$c[15][fieldtype]="foreign:-localdb-,webbox_customlist_cate,id,name";
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
	<a href=\"$dcrURL"."webbox/man.box.customlist.readall.php?pid=$pid&news=$wh[id]\">".
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
<a href="man.box.customlist.php?pid=<?php  echo $s[pid]?>&cate=<?php  echo $s[cate]?>&fftmode=add&startrow=0" class=a_btn target=_top><?php  echo getlang("เพิ่มรายการใหม่::l::Add new");?></a>
</td></tr></table><?php 
}
fixform_tablelister($tbname," 1 and cate='$cate' ",$dsp,"no","no","no","pid=$pid&cate=$cate",$c," id desc ");

quickeditwebtext("webbox-customlist_read_foot","$_TBWIDTH");


foot();
?>