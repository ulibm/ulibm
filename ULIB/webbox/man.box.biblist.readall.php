<?php 
	; 
        include ("../inc/config.inc.php");

html_start();
head();
include("topmenu.php");
mn_web("webpage");
$news=floor($news);
$cursubcate=trim($cursubcate);
include("man.box.biblist.inc.php");
//
$showcount=100;
   if ($cursubcate=="") { // subcate not clicked
      $catemap=tmq("select * from webbox_biblist_catemap where pid='$pid' ",false);
      $catemap=tfa($catemap);
      $cursubcate=$catemap[cate];
   } else { //link from subcate link

   }
   
if ($cursubcate=="last30d") { 
   $ylist=tmq("SELECT DISTINCT FROM_UNIXTIME(lastdtitem, '%Y-%m') As ylist FROM media order by ylist desc limit 12");
   $ylistlimitstr="";
   while ($ylistr=tfa($ylist)) {
      $ya=explode("-",$ylistr[ylist]);
      if (floor($ya[0])<2000) continue;
      if ($ylistselected=="") {
         $ylistselected=$ylistr[ylist];
      }
      //print_r($ylistr); echo "<br>";
      if ($ylistselected==$ylistr[ylist]) { $ylistlimitstr.= "<b>"; }
      $ylistlimitstr.=" <nobr><a href='$dcrURL"."webbox/man.box.biblist.readall.php?pid=$pid&cursubcate=$cursubcate&ylistselected=$ylistr[ylist]' class='a_btn smaller'>".$thaimonstr[floor($ya[1])]." ".getlang(($ya[0]+543)."::l::".$ya[0])."</a></nobr>";
      if ($ylistselected==$ylistr[ylist]) { $ylistlimitstr.= "</b>"; }      
   }
}
if ($cursubcate=="mostborrowed") { 
   $ylist=tmq("SELECT DISTINCT FROM_UNIXTIME(edt, '%Y-%m') As ylist FROM checkout_log order by ylist desc limit 12");
   $ylistlimitstr="";
   while ($ylistr=tfa($ylist)) {
      $ya=explode("-",$ylistr[ylist]);
      if (floor($ya[0])<2000) continue;
      if ($ylistselected=="") {
         $ylistselected=$ylistr[ylist];
      }
      //print_r($ylistr); echo "<br>";
      if ($ylistselected==$ylistr[ylist]) { $ylistlimitstr.= "<b>"; }
      $ylistlimitstr.=" <nobr><a href='$dcrURL"."webbox/man.box.biblist.readall.php?pid=$pid&cursubcate=$cursubcate&ylistselected=$ylistr[ylist]' class='a_btn smaller'>".$thaimonstr[floor($ya[1])]." ".getlang(($ya[0]+543)."::l::".$ya[0])."</a></nobr>";
      if ($ylistselected==$ylistr[ylist]) { $ylistlimitstr.= "</b>"; }      
   }
}
if ($ylistselected!="") {
	$afilter[last30d][sql]=" FROM_UNIXTIME(lastdtitem, '%Y-%m')='$ylistselected' ";
	$afilter[last30d][order]=" ulibnote like '%,cover,%' desc, lastdtitem desc ";
	
}
 
$biblistsql="select distinct ID from media where lower(ispublish)='yes' and ".$afilter[$cursubcate][sql]." order by ".$afilter[$cursubcate][order]."  limit $showcount";
if ($afilter[$cursubcate][fullsql]!="") {
   $biblistsql=$afilter[$cursubcate][fullsql];
}
$biblistsql=str_replace("%LIMITSQL"," FROM_UNIXTIME(edt, '%Y-%m')='$ylistselected' ",$biblistsql);
$biblistsql=str_replace("%LIMITNUM"," limit $showcount ",$biblistsql);

//echo "[cursubcate=$cursubcate]";
//printr($cateparent);
?><center>
		<table align=center width=<?php  echo $_TBWIDTH?> border=0 style="margin-top: 10px;">
		<tr valign=top><td width=300 >
		
		<table width=100% cellpadding=0 cellspacing=1 bgcolor=#eeeeee><tr><td align=center
		style="background-color: #f5f5f5; padding: 5px;;"
		><?php 

@reset($afilter);
   while (list($k,$v)=each($afilter)) {
      if ($cursubcate==$k) {
         echo "<b>";
      }
      ?> &bull; <a href='<?php echo $dcrURL?>webbox/man.box.biblist.readall.php?pid=<?php  echo $pid; ?>&cursubcate=<?php  echo $k; ?>' class=smaller2><?php 
      echo getlang($v[name])."";
      ?></a><?php 
      if ($cursubcate==$k) {
         echo "</b>";
      }

      ?><br><?php 
   }
		?></td></tr></table>

		</td>
			<td style="margin-left: 6px;">
<?php 
$news=floor($news);
	quickeditwebtext("webbox-biblist_read_befor",$_TBWIDTH-300);

echo $ylistlimitstr;

?><div style='clear:both;'></div><?php 
$s=tmq($biblistsql);
if ($setdspcurcate=="yes") {
   barcodeval_set("webbox-currentcatedspformat-$cursubcate",$setsetdspcurcateval);
}
$currentcatedspformat=barcodeval_get("webbox-currentcatedspformat-$cursubcate");
if ($currentcatedspformat=="") {
   $currentcatedspformat="Grid";
}
/////////////////////////////////////////////////////////////////////////
if ($currentcatedspformat=="Grid") {
	$w30=floor(700*0.15);
while ($r=tfa($s)) {
$tmptitle= stripslashes(marc_gettitle($r[ID]));
if (trim($tmptitle)=="") continue;
   ?><div style="display:block; width: 320px; height: 130px; float: left; margin-top: 12px; overflow: hidden;">
   <a href="<?php echo $dcrURL?>dublin.php?ID=<?php  echo $r[ID]; ?>" target=_blank><?php 
   $img=res_cov_dsp($r[ID],"","$h","no","",'width:'.$w30.'px; display:inline-block; height:120px; float: left; margin: 10px; margin-top: 5px; ');
	//printr($img);
	echo $img;
	//$r2=tfa($s2);
?>

<?php  echo $tmptitle; ?></a></div><?php 
}
?><div style="clear:both"></div>
<?php 
}
if ($currentcatedspformat=="Cover") {
while ($r=tfa($s)) {
   ?><div style="display:block; width: 225; height: 300px; float: left; text-align:center; overflow: hidden;  text-overflow: ellipsis;">
   <a href="<?php echo $dcrURL?>dublin.php?ID=<?php  echo $r[ID]; ?>" target=_blank class=smaller><?php 
	//$r2=tfa($s2);
   $img=res_cov_dsp($r[ID],"","180","no","",'width: 200px; display:inline-block; height:250px;  margin: 10px; margin-top: 5px; ');
	//printr($img);
	echo $img;
?><BR>

<nobr><?php  echo stripslashes(marc_gettitle($r[ID]));?></nobr></a></div><?php 
}
?><div style="clear:both"></div>
<?php 
}
if ($currentcatedspformat=="Tile") {
$liststr="<table width=100%>";
while ($r=tfa($s)) {
   ?><div style="display:block; width: 155; height: 155; float: left; text-align:center; padding: 2px;">
   <a href="<?php echo $dcrURL?>webbox/man.box.biblist.readall.php?pid=<?php  echo $pid; ?>&news=<?php  echo $r[id]; ?>"
   TITLE="<?php  echo stripslashes($r[title]);?>"
   ><img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_biblist_list","coverimg",$r[id]);
	echo $imgurl[url];
?>" style="width: 155; margin: 5px; margin-top: 5px; height: 155;" border=0><BR>

<?php  //echo stripslashes($r[title]);?>
</a></div><?php 
$liststr.="<tr><td align=right>".ymd_datestr($r[dt],"shortd")." </td><td>: <a href='$dcrURL"."webbox/man.box.biblist.readall.php?pid=$pid&news=$r[id]'> ".stripslashes($r[title])."</a></td>";
}
$liststr.="</table><BR>";

?><div style="clear:both"></div>
<?php 
echo "<BR><hr noshade>";
echo $liststr;
}
/////////////////////////////////////////////////////////////////////////
	quickeditwebtext("webbox-biblist_read_after-$cursubcate",$_TBWIDTH-300);
	quickeditwebtext("webbox-biblist_read_after",$_TBWIDTH-300);



?><div style="clear:both"></div>

<?php 
if (loginchk_lib("check")) {
?><table align=center width=100%><tr><td>
<form action="<?php  echo $dcrURL;?>webbox/man.box.biblist.readall.php" method=get>
<input type=hidden name="pid" value="<?php  echo $pid;?>">
<input type=hidden name="news" value="<?php  echo $news;?>">
<input type=hidden name="cursubcate" value="<?php  echo $cursubcate;?>">
<input type=hidden name="setdspcurcate" value="yes">
<?php  echo getlang("รูปแบบการแสดงรายการ::l::List Style");
	form_quickedit("setsetdspcurcateval",$currentcatedspformat,"list:Grid,Cover");
?> <input type=submit>
</form>
</td></tr></table><?php 
}
?>
</td>
		</tr>
		</table><?php 

		foot(); die;
		
		
		
		
		
		
		
		
		
		
		
		
		

?>