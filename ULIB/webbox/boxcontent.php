<?php  

function customError($errno, $errstr, $errfile, $errline) {
  echo "<b>Error:</b> [$errno] $errstr<BR>$errfile,$errline<HR>";
}

//set error handler
//set_error_handler("customError");
 //die("here");
?><?php //พ
//print_r($_GET);die;
include("../inc/config.inc.php");
$now=time();
$id=floor($id);
$s=tmq("select * from webbox_box where id='$id'",false);
if (tmq_num_rows($s)==0) {
	uencode("<CENTER>- - -</CENTER>");
	die;
}
function localencode($buffer) {  
  // echo $buffer; die;
  	  //replace back s
      $tmp=getval("_SETTING","urlmappuller");
      $tmp=trim($tmp);
      $tmp=explodenewline($tmp);
      $tmp=arr_filter_remnull($tmp);
      while (list($k,$v)=@each($tmp)) {
         $tmp2=explode("=",$v);
         //echo "str_replace($tmp2[1],$tmp2[0],";
         $buffer=str_replace($tmp2[1],$tmp2[0],$buffer);
      }
      //echo "here";
	  //replace back e
  return (uencode( $buffer));
}

$s=tmq_fetch_array($s);

//printr($s);
ob_start("localencode");
//echo "select * from webbox_box where id='$id'";
//printr($s); die;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?><div style=" width:100%; height:100%; position: relative; top:0px ;left:0px;"><?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($s[ishide]=="yes") {
   ?><div style="background-image: url(<?php echo $dcrURL;?>webbox/disabledoverlay.png); width:100%; height:100%; position: absolute; top:0px ;left:0px; pointer-events: none;"></div><?php
}
if ($s[type]=="photogrid") { /////////////////////////////////////////////////////////////////////////////////////////////// 
		if (trim($webbox_cur_columnwidth)=="") {
			$webbox_cur_columnwidth="100%";
		}
   $boxs=tmq("select * from webbox_photogrid where boxid='$s[id]'");
   $boxr=tfa($boxs);
   $sb=tmq("select * from webbox_photogrid where boxid='$s[id]' ");
   $sbr=tfa($sb);
   $keyid="webbox_photogrid-".$boxr[id];
   //include($dcrs."webbox/photogrid/index.php");
   ?>
   


<style>
.grid<?php echo $s[id];?>-item { width: <?php echo floor($sbr[photowidth]/2);?>px; }
.grid<?php echo $s[id];?>-item--width2 { width: <?php echo floor($sbr[photowidth]);?>px; }

</style>
<!--   <div class="grid-item">...</div>
  <div class="grid-item grid-item--width2">...</div>
  -->
<div class="grid<?php echo $s[id];?>">



<?php

if (strtolower($sbr[israndom])=="yes") {
   $sg=tmq("select * from globalupload where keyid='$keyid' order by rand() ",false);
} else {
   $sg=tmq("select * from globalupload where keyid='$keyid' order by filename ",false);
}

while ($rg=tfa($sg)) {
   ?>  <div class="<?php
   $tmp=rand ( 1, 3);
   if ($tmp==2) {
      echo "grid$s[id]-item grid$s[id]-item--width2";
   } else {
      echo "grid$s[id]-item";
   }
   ?>" style="border: 1px solid white;"><img
   style="width: 100%;"
    border=0 onclick="window.open(this.src);"
    onload="photogridimageload<?php echo $s[id];?>();"
     src="<?php echo  $dcrURL."_globalupload/$rg[keyid]/$rg[hidename]";?>"></div>
<?php
}

?></div>

<script>

</script>
<?php
}

if ($s[type]=="sepper") { /////////////////////////////////////////////////////////////////////////////////////////////// 
	$sep=tmq("select * from webbox_sepper where pid='$s[id]' ");
	if (tnr($sep)!=0) {
		$sepr=tfa($sep);
		//printr($_GET);
		$tp=tmq("select * from webbox_sepper_type where code='$sepr[type1]'");
		$tp=tfa($tp);
		$str=stripslashes($tp[tp]);
		if (trim($webbox_cur_columnwidth)=="") {
			$webbox_cur_columnwidth="100%";
		}
		$str=str_replace("%dcr",($dcrURL),$str);
		$str=str_replace("[dcr]",($dcrURL),$str);
		$str=str_replace("%str",stripslashes($sepr[str]),$str);
		$str=str_replace("%descr",stripslashes($sepr[descr]),$str);
		$str=str_replace("%col2",stripslashes($sepr[col2]),$str);
		$str=str_replace("%col",stripslashes($sepr[col]),$str);
		$str=str_replace("%w",stripslashes($webbox_cur_columnwidth),$str);
		$str=str_webpagereplacer($str);
		echo $str;
	}

}

	if ($s[type]=="simplestat") { /////////////////////////////////////////////////////////////////////////////////////////////// 
		$stargerpref="webbox-simplestat-";
		$dkey=$stargerpref.date("d-m-y");
		$mkey=$stargerpref.date("m-y");
		$ykey=$stargerpref.date("y");
		barcodeval_set($dkey,floor(barcodeval_get($dkey))+1);
		barcodeval_set($mkey,floor(barcodeval_get($mkey))+1);
		barcodeval_set($ykey,floor(barcodeval_get($ykey))+1);
		?> 
<table align=center width=100% cellpadding=0 cellspacing=3 border=0>
<tr>
	<td style="padding-left: 5px;" class=smaller><?php  echo getlang("เยี่ยมชมวันนี้::l::Visitor today");?></td>
	<td align=left class=smaller> : <?php 
		echo number_format(barcodeval_get($dkey));
		?></td>
</tr>
<tr>
	<td style="padding-left: 5px;" class=smaller><?php  echo getlang("เยี่ยมชมเดือนนี้::l::Visitor this month");?></td>
	<td align=left class=smaller> : <?php 
		echo number_format(barcodeval_get($mkey));
		?></td>
</tr>

<tr>
	<td style="padding-left: 5px;" class=smaller><?php  echo getlang("เยี่ยมชมปีนี้::l::Visitor this year");?></td>
	<td align=left class=smaller> : <?php 
		echo number_format(barcodeval_get($ykey));
		?></td>
</tr>
<tr>
	<td style="padding-left: 5px;" class=smaller><?php  echo getlang("IP");?></td>
	<td align=left class=smaller> : <?php 
		echo ($IPADDR);
		?></td>
</tr>

<tr>
	<td style="padding-left: 5px;" class=smaller><?php  echo getlang("เริ่มนับเมื่อ::l::Since");?></td>
	<td align=left class=smaller> : <?php 
	if (floor(barcodeval_get($stargerpref."statstart"))==0) {
		barcodeval_set($stargerpref."statstart",time());
	}
		echo ymd_datestr(barcodeval_get($stargerpref."statstart"),"date");
		?></td>
</tr>

</table><?php 
	}
	if ($s[type]=="tab") { /////////////////////////////////////////////////////////////////////////////////////////////// tabs start
		$tabrandid="webboxtabid".$s[id];
		//echo "tab here";
		$tabssql="select * from webbox_boxtab_tabs where locate='$s[id]' and isshow='yes' order by ordr";
		$tabs=tmq($tabssql,false);
			//start gen tab btn
			?><ul id="<?php echo $tabrandid;?>" class="shadetabs"><?php 
			while ($tabr=tmq_fetch_array($tabs)) {
				?><li><a href="#" rel="tab<?php  echo $tabrandid?>_<?php  echo $tabr[id]?>" class="selected"><?php  echo str_webpagereplacer(getlang(stripslashes($tabr[name])));?></a></li><?php 
			}
			?></ul><?php 
			//end gen tab btn
			//start gen tab body
			?><div style="border:1px solid gray; width:99%; margin-bottom: 0; padding: 0px; background-image: url('./neoimg/tabbg.jpg'); background-position: right bottom;padding-bottom:0; background-repeat:no-repeat"><?php 
			$tabs=tmq($tabssql,false);
			while ($tabr=tmq_fetch_array($tabs)) {
				?><div id="tab<?php  echo $tabrandid?>_<?php  echo $tabr[id]?>" class="tabcontent"><?php 
			
			//printr($tabr);
			if ($tabr[type]=="html") {
				$sidebarrdat=tmq("select * from webbox_boxtab_content where refid='$tabr[id]' ",false);
				$sidebarrdat=tmq_fetch_array($sidebarrdat);
				$sidebarrdat[title]=getlang(trim($sidebarrdat[title]));
				//printr($sidebarrdat);
				if ($sidebarrdat[title]!="") {
					?><FONT style="border-color: 999999; border-style: dotted; border-width: 0; border-bottom-width: 3 ; font-size: 14px; font-weight: bold; display: block; width: 90%"><?php  echo stripslashes($sidebarrdat[title])?></FONT><?php 
				}
				echo "<span class=sidebarstriptagp>".str_webpagereplacer(stripslashes($sidebarrdat[body]))."</span>";
			}
			if ($tabr[type]=="rss") {
				$sidebarrdat=tmq("select * from webbox_boxtab_rss where refid='$tabr[id]' ");
				$sidebarrdat=tmq_fetch_array($sidebarrdat);
				$TEMPLATEfilename="";
				if ($sidebarrdat[rsstype]=="Photo") {
					 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-photo.txt";
				} elseif ($sidebarrdat[rsstype]=="Photo With Reflect") {
					 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-photowithreflect.txt";
				} elseif ($sidebarrdat[rsstype]=="Small Photo") {
					 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-photosmall.txt";
				} elseif ($sidebarrdat[rsstype]=="Bib and cover style") {
					 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-bibandcover.txt";
				} elseif ($sidebarrdat[rsstype]=="Text-Topic Only") {
					 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-topiconly.txt";
				} else {
					 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar.txt";
				}
				$XMLfilename = $sidebarrdat[url];
				//echo "[$XMLfilename]";
				$FeedMaxItems = floor($sidebarrdat[maxitem]);
				if ($FeedMaxItems<1) {
					$FeedMaxItems=10;
				}
				//echo "[$FeedMaxItems]";
				include("$dcrs/inc/rss2html/ulibrss.php");
				//include("$dcrs/inc/rss2html/rss2html.php");
			}
			?></div><?php 
		}
	?></div><?php 
	}
	//echo $s[type];
if ($s[type]=="searchbox") {
	$tmpquicksearch=strtolower(barcodeval_get("webpage-o-isshowquicksearch"));
	if ($tmpquicksearch=="yes") {
		$_QUICKSEARCHonlymember="yes";
		$tabforsearch=tmq("select * from webbox_tab where module='Searching' ");
		$tabforsearch=tfa($tabforsearch);
		$tabforsearch=$tabforsearch[id];
		?>
<form method="get" action="<?php echo $dcrURL;?>index.php" target="_top">
<input type="hidden" name="deftab" value="<?php  echo $tabforsearch; ?>">
<input type="hidden" name="fromseachboxwebbox" value="yes">
	<TABLE width=100% align=center cellpadding=0 cellspacing=0 border=0>
	<TR valign=top>
		<td align=center>
		<input ID="singlesearchbox" class="wickEnabled" type="text" style="width: 40%;" 
		placeholder="<?php  echo getlang("ป้อนคำค้นที่นี่::l::Put Keyword Here");?>"
		name="KW" value="<?php  echo $KW; ?>"
		/> 
		<?php 
		$sidx=tmq("select * from index_ctrl where searchable='yes' order by ordr",false); //printr($REQUEST);
		?>
		<select name="indexcode" ID="S_INDEXCODE">
			<?php 
			while ($sidxr=tfa($sidx)) {
				$sl="";
				if ($sidxr[code]=="kw" ) { $sl="selected";}
				echo "<option value='$sidxr[code]' $sl>".getlang($sidxr[name]);
			}
			?>
		</select>
		<input type="submit" value="Search">		
		</td>
</table>
</form><?php 
	}
}
if ($s[type]=="photoframesingle") {
$chkexist=tmq("select * from webbox_photoframesingle where pid='$s[id]' ");
if (tmq_num_rows($chkexist)==0) {
}  else {
	$wh=tmq_fetch_array($chkexist);

	$img=fft_upload_get("webbox_photoframesingle","photo",$wh[id]);
	//printr($img);
	$s="<img src='$img[url]' width=100%   ID='photoframesingle$s[id]' onclick=\"GB_showFullScreen('$wh[title]', '$dcrURL"."_photoview.php?url=".urlencode($img[url])."' )\">";
	$wh[title]=trim($wh[title]);
	if ($wh[title]=="") {
	} else {
		$s="$wh[title]<BR>$s ";
	}
	echo $s;
}
}
if ($s[type]=="googlemap") {
	$chkexist=tmq("select * from   webbox_box_googlemap where refid='$s[id]' ");
	$chkexist=tfa($chkexist);
	$chkexist[title]=trim(getlang($chkexist[title]));
	if ($chkexist[title]!="") {
		?><CENTER><B><?php  echo $chkexist[title]?></B><BR><?php 
	}	
		?><iframe width=100% height=180 src="<?php  echo $dcrURL?>webbox/_gmapdisplay.php?id=<?php  echo $s[id]?>" FRAMEBORDER="NO" BORDER=0 SCROLLING=NO ></iframe></CENTER><?php 
}
if ($s[type]=="mocalen") {
		?><CENTER><B>ปฏิทินกิจกรรม</B><BR><iframe width=100% height=180 src="<?php  echo $dcrURL?>webpage.calendar.php" FRAMEBORDER="NO" BORDER=0 SCROLLING=NO ></iframe></CENTER><?php 
}
if ($s[type]=="eventcalendar") {
	//mocalen modern calendar
	$mocals=floor(barcodeval_get("mocal-o-dayhistory")*(60*60*24));
	$mocale=floor(barcodeval_get("mocal-o-dayforward")*(60*60*24));	
	$mocals=time()-$mocals;
	$mocale=time()+$mocale;
	$slocal=tmq("select * from webpage_mocalen where isshow='yes' and dt>=$mocals and dt<=$mocale order by dt asc");
	if (tmq_num_rows($slocal)!=0) {
	 // pagesection(barcodeval_get("mocal-o-name"),"articlelist");
		$imocal=0;
		?><div style="display:block; width:100%;overflow: auto; padding: 3 3 3 3" ID=sdfasdfadsfdasf xonclick="alert(document.getElementById('sdfasdfadsfdasf').style.pixelHeight)"><?php 
		while ($r=tmq_fetch_array($slocal)) {
			$imocal++;
			if (mb_strlen($r[descr])>35) { $r[descr]=mb_substr($r[descr],0,35).'..'; }
				?><table width=135  cellpadding=3 cellspacing=1 height=100	style="float:left; width: 135"<?php 
			 if ($r[dt]==ymd_mkdt(date('j'),date('n'),date('Y'))) {
				//echo " style='border-width: 0;border-bottom-width: 1px;border-right-width: 1px; border-color:#666666; border-style: solid;' ";
			 }
	?> border=0>
	<tr><td bgcolor="<?php  echo $r[col]?>" valign=top style="padding-left: 10; cursor: hand; cursor: pointer;;
	background-image: url(<?php  echo $dcrURL?>neoimg/mocalenclip.png); background-repeat: no-repeat;"
	onclick="window.open('<?php  echo $dcrURL?>webpage.mocal.read.php?id=<?php  echo $r[id]?>','','width=550,height=500,resizable,scrollbars=yes')"
	><b style="color:white;"><?php  echo $r[title]?></b><br />
	<font color=white style='font-size: 11'><?php  echo ymd_datestr($r[dt],'shortd');?></font><br />
	<font color=white style='font-size: 11'><?php  echo $r[descr];?></font>
	<font color=white style='font-size: 11'><?php 
		$sc=tmq("select * from webpage_mocalen_resp where pid='$r[id]' ");
		if (tmq_num_rows($sc)!=0) {
			 echo "<br />".getlang("มีความเห็น::l::Got response").": <b style='font-size: 11'>" .number_format(tmq_num_rows($sc))."</b>";;;
		}
	?></font>
	</td></tr>
	<TR bgcolor="<?php  echo $r[col]?>" valign=top height=7>
		<TD style="padding: 0; margin: 0"><IMG SRC="./neoimg/mocalenclipb.png" WIDTH="135" HEIGHT="7" BORDER="0" ALT=""></TD>
	</TR>
	</table>
		<?php 
	}
	?></div>
	<?php 
	} else {
		echo " - - - - ";
	}
}
if ($s[type]=="webboardcate") {


$now=time();
$sql2 ="SELECT *  FROM webboard_boardcate where 1 "; 
if (loginchk_lib("check")!=true) {
	$sql2 = "$sql2 and isshowtouser='yes' ";
}
$sql2 = "$sql2 order by ordr,name";

$slocal=tmq($sql2);
?>
<TABLE cellpadding=0 cellspacing=1 bgcolor=999999 align=center width="100%" >

<?php  
	while ($r=tmq_fetch_array($slocal)) {
?>
<TR bgcolor=white>

	<TD class=table_td>
	<?php 
	if ($img=='protection' && loginchk_lib("check")!=true)	 {
		$link="<a href='javascript:void(0);' onclick='alert(\"".getlang("ขออภัย ท่านไม่มีรายชื่อในการเข้าดูหัวข้อนี้::l::Sorry, you cannot view this forum")."\");'>";
	} else {
		$link="<A HREF='$dcrURL/webboard/viewforum.php?ID=$r[id]'>";
	}
		echo $link;
	?><B style='font-size: 14px;'><B></B><?php  echo getlang($r[name])?></B><BR>&nbsp;&nbsp;<B></B><FONT class=smaller2><?php  echo getlang($r[descr]);?></FONT></A> 
	<?php 
	if ($r[isshowtouser]!="yes") {
		echo getlang("แสดงให้เจ้าหน้าที่เห็นเท่านั้น::l::Librarian only");
	}	
	?>
</TD>

</TR>

<?php 
	}	
?>
</TABLE><?php 
?><center><A HREF="<?php  echo $dcrURL?>webboard/search.php" class="a_btn smaller"><img src="<?php  echo $dcrURL?>webboard/search.gif" align=absmiddle border=0><?php  echo getlang("ค้นหาในเว็บบอร์ด::l::Webboard search");?></A></center>
<?php 
}
if ($s[type]=="weeklybook") {

$wlw=floor(date('t'));
$wlw=floor(date('j') / ($wlw/4));
//$wlw=@floor(26 / ($wlw/4));
//echo "[$wlw]";
if ($wlw>3) {$wlw=3;}
$wlw++;
	$wbinfo=tmq("select * from webpage_weeklybook where yea='".date("Y")."' and mon='".date("n")."' and week='".$wlw."' ");
	if (tmq_num_rows($wbinfo)!=0) {

		?><TABLE border=0 cellpadding=0 cellspacing=0 width="100%">
<TR><TD colspan=5 height=20 background="<?php  echo "$dcrURL"."neoimg/bookcase/header.jpg";?>"
align=right><FONT class=smaller COLOR="#695B3D"><?php  echo getlang("ทรัพยากรแนะนำประจำสัปดาห์::l::Matterials of the week");?>&nbsp; &nbsp;</FONT></TD></TR>
<?php 
	$wbinfo=tmq_fetch_array($wbinfo);
		echo "<TR style='background-image:url($dcrURL"."neoimg/bookcase/background.jpg);' valign=top>
		<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
		<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_left.png'></TD>
		<TD style='height: 240px; padding-bottom:20' valign=bottom>
		";
	echo res_icon($wbinfo[bibid]," style='display:inline; margin: 0 0 0 0; ' ");
	//echo $i." ".marc_gettitle($r[bibid])."<BR>";
?>

<?php 
		echo "</TD>
		<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_right.png'></TD>
		<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
		</TR>";
?>
</TABLE><?php 
		} else {
			echo "- - -";
		}

}
if ($s[type]=="webpageshowcase") {
	$localwidth=floor($webbox_cur_columnwidth);
	$divwidth=200;
	if ($localwidth<390) {
		$divwidth=$localwidth;
	}
	?><?php 
	$s2=tmq("select * from index_db where webpageshowcase='yes' and ispublish='yes' ");
	$i=0;
	while ($r2=tmq_fetch_array($s2)) {
		if (($i % 3) == 0) { echo "<TR valign=top><TD >"; }
		$i++;
		//echo "[$i".($i % 4 )."]";
		$rand=randid();
		   $r2[titl]=(marc_gettitle($r2[mid]));
		   $r2[auth]=($r2[auth]);

		if (mb_strlen($r2[titl])>35) { $r2[titl]=mb_substr($r2[titl],0,35).'..'; }
		if (mb_strlen($r2[auth])>17) { $r2[auth]=mb_substr($r2[auth],0,15).'..'; }
		?><div style="display:block; width: <?php  echo $divwidth;?>px; height: <?php  echo $divwidth+10;?>px; border: 1px #e5e5e5 solid; float: left;
		padding: 4px 4px 4px 4px; text-align: center; overflow:hidden;"><?php 
		$webreview=tmq("select * from webpage_showcase where mid='$r2[mid]' ");
		$webreviewstr="";
		if (tmq_num_rows($webreview)!=0) {
			$webreviewstr="<BR>&nbsp;<IMG SRC='./neoimg/reviewicon.png' WIDTH='20' HEIGHT='20' BORDER='0' align=absmiddle>
			<B><FONT COLOR='#000066' style='font-size: 11px;'> ".getlang("มี review::l::Got review!")."</FONT></B>";
		}
			echo "<a href='dublin.php?ID=$r2[mid]' target=_blank style='font-size: 13px; '>";
			 echo res_cov_dsp($r2[mid],$tags,150,"yes"," style='border-color:black; ;margin-right: 4; max-height: ".($divwidth-20)."px;'");
			 echo "<br>".($r2[titl])."</a><br /> <font style='font-size: 11px;'>$r2[auth]</font>";		
		
			echo $webreviewstr;
				?></div><?php 
	}
	?>
	<div clear=both style="clear:both"></div>
	<br /><a href="<?php echo $dcrURL?>getfeed.php?feed=showcase" class=feedbtn target=_blank><img align=absmiddle src="<?php echo $dcrURL?>neoimg/feed-icon-14x14.png" border=0> <?php  echo getlang("วัสดุฯแนะนำ::l::Books on showcase");?></a><?php 
}
if ($s[type]=="html") {
		$sidebarrdat=tmq("select * from   webbox_box_content where refid='$s[id]' ");
		$sidebarrdat=tmq_fetch_array($sidebarrdat);
		$sidebarrdat[title]=getlang(trim($sidebarrdat[title]));
		if ($sidebarrdat[title]!="") {
			?><FONT style="border-color: 999999; border-style: dotted; border-width: 0; border-bottom-width: 3 ; font-size: 14px; font-weight: bold; display: block; width: 90%"><?php  echo stripslashes($sidebarrdat[title])?></FONT><BR><?php 
		}
		echo "<span class=sidebarstriptagp>".stripslashes($sidebarrdat[body])."</span>";
		?><?php 
}
if ($s[type]=="rss") {
	$sidebarrdat=tmq("select * from webbox_box_rss where refid='$s[id]' ");
	$sidebarrdat=tmq_fetch_array($sidebarrdat);
	$TEMPLATEfilename="";
	if ($sidebarrdat[rsstype]=="Photo") {
		 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-photo.txt";
	} elseif ($sidebarrdat[rsstype]=="Photo With Reflect") {
		 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-photowithreflect.txt";
	} elseif ($sidebarrdat[rsstype]=="Bib and cover style") {
		 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-bibandcover.txt";
	} elseif ($sidebarrdat[rsstype]=="Small Photo") {
		 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-photosmall.txt";
	} elseif ($sidebarrdat[rsstype]=="Text-Topic Only") {
		 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar-topiconly.txt";
	} else {
		 $TEMPLATEfilename="$dcrs/inc/rss2html/tp.hpsidebar.txt";
	}
	$XMLfilename = $sidebarrdat[url];
	$FeedMaxItems = floor($sidebarrdat[maxitem]);
	if ($FeedMaxItems<1) {
		$FeedMaxItems=10;
	}
	//echo "[$FeedMaxItems]";
	//include("$dcrs/inc/rss2html/rss2html.php");
	include("$dcrs/inc/rss2html/ulibrss.php");
	echo "<BR><a href='$sidebarrdat[url]' target=_blank class=feedbtn><img align=absmiddle src='$dcrURL/neoimg/feed-icon-14x14.png' border=0> RSS</A>";
}
if ($s[type]=="photonews") {
	$indexphotonews_count="select * from webpage_indexphotonews where cate='news' and dtstart<=$now and dtend>=$now order by dt desc limit 8";
	$indexphotonews_count=tmq($indexphotonews_count,false);
	//echo tmq_num_rows($indexphotonews_count);

	if (tmq_num_rows($indexphotonews_count)!=0) {
		$ipndisplaystyle=barcodeval_get("webpage-indexphotonews_style");
		//echo "[$ipndisplaystyle]";
		$indexphoto_h=barcodeval_get("webpage-indexphotonews_setheight");
		if ($ipndisplaystyle=="Frame") {
			?><iframe width="100%" height="<?php  echo $indexphoto_h;?>" FRAMEBORDER="NO" BORDER=0 SCROLLING=NO src="./library.indexphotonews/index.external.view.php?bgcolor=A3A3A3&set_height=<?php  echo $indexphoto_h;?>&set_width=<?php  echo $webbox_cur_columnwidth?>"></iframe><?php 
		}
		//	echo "[$ipndisplaystyle]";
		if ($ipndisplaystyle=="Frame With Caption") {
			?><iframe width="100%" height="<?php  echo $indexphoto_h;?>" FRAMEBORDER="0" BORDER=0 SCROLLING=NO src="./library.indexphotonews/index.external.view2.php?bgcolor=A3A3A3&set_height=<?php  echo $indexphoto_h;?>&set_width=<?php  echo $webbox_cur_columnwidth?>"></iframe><?php 
		}
		if ($ipndisplaystyle=="Matrix") {
			$indexphoto_h=(tmq_num_rows($indexphotonews_count)*70)+35;
			?><iframe width="100%" height="<?php  echo $indexphoto_h;?>" FRAMEBORDER="NO" BORDER=0 SCROLLING=NO src="./library.indexphotonews/index.external.viewmetrix.php?bgcolor=A3A3A3&set_height=<?php  echo $indexphoto_h;?>&set_width=<?php  echo $webbox_cur_columnwidth?>"></iframe><?php 
		}
	}
}


if ($s[type]=="customlist") {

$catemap=tmq("select * from webbox_customlist_catemap where pid='$s[id]' "); //die;
$catemap=tfa($catemap);
//printr($catemap);
$cate=$catemap[cate];
$showcount=floor($catemap[showcount]);
if ($showcount<1) {
	$showcount=5;
}
if ($catemap[readmoretxt]=="") {
	$catemap[readmoretxt]="ดูเพิ่มเติม::l::read more";
}
if ($catemap[displayformat]=="List") {
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_customlist_list  where cate in (select id from webbox_customlist_catesub where cateid='$cate')  and lower(isshow)='yes' "; 
	$sql2 = "$sql2 order by dt desc limit $showcount ";
   //echo $sql2; ob_end_flush(); die;
	$s2=tmq($sql2,false);
	?>
	<TABLE cellpadding=0 cellspacing=0 align=center width="100%" >

	<?php  
		while ($r=tmq_fetch_array($s2)) {
	?>
	<TR bgcolor=white>
		<TD > &nbsp;<img src="<?php  echo $dcrURL;?>neoimg/webpagemenu/<?php  echo $r[icon];?>" width=16 height=16>
		<?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.customlist.readall.php?pid=$r[pid]&news=$r[id]\" style='font-size: 12px;'>";
			echo $link;
		?><?php  echo stripslashes(getlang($r[title]));?></A> <?php 
			if ($r[tailicon]!="None.png") {	
		?> <img src="<?php  echo $dcrURL;?>neoimg/gificon/<?php  echo $r[tailicon];?>" height=12><?php 
		}	
		?>
	<font class=smaller2><?php  echo ymd_datestr($r[dt],"date");?></font>
	</TD>
	</TR>
	<?php 
		}	
	?>
	</TABLE><?php 
?>
<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div>
<?php 
	/////////////////////////////////////////////////////////////////////
}
if ($catemap[displayformat]=="Grid") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_customlist_list  where  cate in (select id from webbox_customlist_catesub where cateid='$cate')  and lower(isshow)='yes' "; 
	$sql2 = "$sql2 order by dt desc limit ".($showcount+2);

	$s2=tmq($sql2);
	$col1imgwidth=floor((floor($webbox_cur_columnwidth)*25)/100);
	$col1width=$webbox_cur_columnwidth-5;
	$col1imgwidth-=2;
?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td >
	<div style="display:inline-block; width: <?php  echo $col1width;?>px">
	<img src="<?php 
	$r2=tfa($s2);
$pid=$r2[pid];
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.customlist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";
?><div style="clear: both;"></div><?php 
	$r2=tfa($s2);
	if (trim($r2[id])!="") {
?><img src="<?php 
	$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.customlist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";

	}?></div>
<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div></td>
</tr>
</table><?php 
/////////////////////////////////////////////////////////////////////
}
if ($catemap[displayformat]=="Grid_2_column") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_customlist_list  where  cate in (select id from webbox_customlist_catesub where cateid='$cate')  and lower(isshow)='yes' "; 
	$sql2 = "$sql2 order by dt desc limit ".($showcount+2);

	$s2=tmq($sql2);
	$col1width=floor((floor($webbox_cur_columnwidth)*65)/100);
	$col2width=floor((floor($webbox_cur_columnwidth)*35)/100);
	$col1imgwidth=floor((floor($webbox_cur_columnwidth)*25)/100);
	$col1width-=2;
	$col1imgwidth-=2;
?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td width="<?php  echo $col1imgwidth;?>" style="width:<?php  echo $col1imgwidth;?>px;">
	<div style="display:inline-block; width: <?php  echo $col1width;?>px"><?php  //echo $col1width;?>
	<img src="<?php 
	$r2=tfa($s2);
$pid=$r2[pid];
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.customlist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";
?><div style="clear: both;"></div><?php 
	$r2=tfa($s2);
	if (trim($r2[id])!="") {
?><img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=0><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.customlist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>ก";

	}?>
</div>
</td>
	<td width="<?php  echo $col2width;?>"><div style="display:inline-block; width: <?php  echo $col2width;?>">
	<?php  //echo $col2width;?><?php 
while ($r2=tfa($s2)) {
	?>
<img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="20" style="float: left; margin-right: 5px; margin-top: 5px; max-height: 20px;" border=1><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.customlist.readall.php?pid=$r2[pid]&news=$r2[id]\"  class=smaller>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller2>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "</font>
			<div style='clear: both;'></div>";
}
?>
</div>

</td>
</tr>
</table><div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div><?php 
/////////////////////////////////////////////////////////////////////
}

if ($catemap[displayformat]=="2_Columns") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_customlist_list  where  cate in (select id from webbox_customlist_catesub where cateid='$cate')  and lower(isshow)='yes' "; 
	$sql2 = "$sql2 order by dt desc limit ".($showcount);

	$s2=tmq($sql2);

?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td width="<?php  echo $col1imgwidth;?>" style="width:<?php  echo $col1imgwidth;?>px;">
	
	<?php 
	
while ($r2=tfa($s2)) {
   ?><div style="display:block; width: calc(49%); height: 120px; float: left;">
   <a href="<?php echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $pid; ?>&news=<?php  echo $r2[id]; ?>"><img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" style="width:calc(30%);; float: left; margin: 10px; margin-top: 5px; height: 100px;" border=0>

<?php  echo stripslashes($r2[title]);?></a>
<?php echo "<br><font class=smaller2>";
         echo stripslashes($r2[descr])."<BR>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "</font>"; ?>
</div><?php 
}
	?>

</td>
</tr>
</table><div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div><?php 
/////////////////////////////////////////////////////////////////////
}

if ($catemap[displayformat]=="1_Row") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_customlist_list  where  cate in (select id from webbox_customlist_catesub where cateid='$cate')  and lower(isshow)='yes' "; 
	$sql2 = "$sql2 order by dt desc limit 3";//.($showcount+2);

	$s2=tmq($sql2);

?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td>
<?php  while ($r2=tfa($s2)) {?>
	<div style="display:block; width: calc(31%); float:left; margin: 6px; "><?php  //echo $col1width;?>
	<img src="<?php 
	//$r2=tfa($s2);
$pid=$r2[pid];
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" style="width:100%;float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($webbox_cur_columnwidth/3)*0.5;?>px" border=0><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.customlist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: normal;;' class=smaller>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a>";
			//echo ymd_datestr($r2[dt],"shortd");
			//echo "<br>";
			//echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			//echo "</font>";
?>
</div>
<?php 
 }
?>

<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div></td>
</tr>
</table><?php 
/////////////////////////////////////////////////////////////////////
}

if ($catemap[displayformat]=="Sliding_Cover") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_customlist_list  where  cate in (select id from webbox_customlist_catesub where cateid='$cate')  and lower(isshow)='yes' "; 
	$sql2 = "$sql2 order by dt desc limit $showcount";//.($showcount+2);

	$s2=tmq($sql2);

?><marquee onmouseover="stop();" onmouseout="start();"><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	
<?php  while ($r2=tfa($s2)) {?><td>
	<div style="display:block; width: 150; height:200 ; float:left; margin: 6px; "><?php  //echo $col1width;?>
	<?php 
	$link="<a href=\"$dcrURL"."webbox/man.box.customlist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;' TITLE=\"".addslashes($r2[title])."\">";
	echo $link;
			?>
	<img src="<?php 
	//$r2=tfa($s2);
$pid=$r2[pid];
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" style="width:100%; height:100%; float: left; margin-right: 5px; margin-top: 5px; " border=0><?php 
			
			//echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a>";
			//echo ymd_datestr($r2[dt],"shortd");
			//echo "<br>";
			//echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			//echo "</font>";
?>
</div>
</td><?php 
 }
?>

</tr>
</table></marquee>
<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div><?php 
/////////////////////////////////////////////////////////////////////
}

}


if ($s[type]=="biblist") {
//echo "herehereherehere"; 
//echo($dcrs."/webbox/man.box.biblist.inc.php"); //die;
require_once($dcrs."/webbox/man.box.biblist.inc.php"); ;
//printr($afilter);
//   echo "BIBLIST;";
$catemap=tmq("select * from webbox_biblist_catemap where pid='$s[id]' ",false); //die;
$catemap=tfa($catemap);
//printr($catemap);

$cate=$catemap[cate];
$showcount=floor($catemap[showcount]);
if ($showcount<1) {
	$showcount=5;
}
$biblistsql="select distinct ID from media where lower(ispublish)='yes' and ".$afilter[$catemap[cate]][sql]." order by ".$afilter[$catemap[cate]][order]."  limit $showcount";
if ($afilter[$catemap[cate]][fullsql]!="") {
   $biblistsql=$afilter[$catemap[cate]][fullsql];
   $ylist=tmq("SELECT DISTINCT FROM_UNIXTIME(edt, '%Y-%m') As ylist FROM checkout_log order by ylist desc limit 1");
   $ylistr=tfa($ylist);
   $ylistrselected=$ylistr[ylist];   
   if (trim($ylistrselected)=="") {
      $ylistrselected=date("Y-m");
   }
}
$biblistsql=str_replace("%LIMITSQL"," FROM_UNIXTIME(edt, '%Y-%m')='$ylistrselected' ",$biblistsql);
$biblistsql=str_replace("%LIMITNUM"," limit $showcount ",$biblistsql);
//echo $biblistsql;
if ($catemap[readmoretxt]=="") {
	$catemap[readmoretxt]="ดูเพิ่มเติม::l::read more";
}
if ($catemap[displayformat]=="List") {
/////////////////////////////////////////////////////////////////////
	$now=time();
   //echo $sql2; ob_end_flush(); die;
	$s2=tmq($biblistsql,false);
	?>
	<TABLE cellpadding=0 cellspacing=0 align=center width="100%" >

	<?php  
		while ($r=tmq_fetch_array($s2)) {
	?>
	<TR bgcolor=white>
		<TD > &nbsp;&bull;
		<?php 
			$link="<a href=\"$dcrURL"."dublin.php?ID=$r[ID]\" target=_blank class=smaller>";
			echo $link;
		?><?php  echo stripslashes(marc_gettitle($r[ID]));?></A> <?php 
			
		?>

	</TD>
	</TR>
	<?php 
		}	
	?>
	</TABLE><?php 
?>
<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.biblist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div>
<?php 
	/////////////////////////////////////////////////////////////////////
}

if ($catemap[displayformat]=="2_Columns") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();

	$s2=tmq($biblistsql);

?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td width="<?php  echo $col1imgwidth;?>" style="width:<?php  echo $col1imgwidth;?>px;">
	
	<?php 
	$w30=floor($webbox_cur_columnwidth*0.15);
	$w49=floor($webbox_cur_columnwidth*0.49);
	$h15=floor($w30*1.49);
	$h=floor($w30*1.3);
while ($r2=tfa($s2)) {
   ?><div style="display:block; width: <?php  echo $w49?>px; height: <?php  echo $h15;?>px; float: left; overflow: hidden; ">
   <a href="<?php echo $dcrURL?>dublin.php?ID=<?php  echo $r2[ID]; ?>" class=smaller2 target=_blank><?php 
   	$img=res_cov_dsp($r2[ID],"","$h","no","",'width:'.$w30.'px; display:inline-block; height:'.$h.'px; float: left; margin: 10px; margin-top: 5px;');
	//printr($img);
	echo $img;
    echo stripslashes(marc_gettitle($r2[ID]));?></a>

</div><?php 
}
	?>

</td>
</tr>
</table><div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.biblist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div><?php 
/////////////////////////////////////////////////////////////////////
}

if ($catemap[displayformat]=="1_Row") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$s2=tmq($biblistsql);

?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td>
<?php 
	$w=floor($webbox_cur_columnwidth*0.15);
	$h=floor($webbox_cur_columnwidth*0.25);
	$himg=floor($webbox_cur_columnwidth*0.2);
   
 while ($r2=tfa($s2)) {?>
	<div style="display:block; width: <?php echo $w?>px; height: <?php echo $h?>px; float:left; margin: 6px; overflow: hidden;text-overflow: ellipsis;"><?php  //echo $col1width;?>
	<?php 
	//$r2=tfa($s2);
$pid=$r2[pid];
	$img=res_cov_dsp($r2[ID],"","100%","no","",'width:'.($w-4).'px; height:'.($himg).'px; float: left; margin-right: 5px; margin-top: 5px; margin-left: 2px;');
	//printr($img);
	echo $img;
	//echo $imgurl[url];
	
			$link="<a href=\"$dcrURL"."dublin.php?ID=$r2[ID]\" target=_blank style='xxxxfont-size: 12px; font-weight: normal;;' class=smaller><nobr>";
			echo $link;
			echo str_webpagereplacer(stripslashes(marc_gettitle( $r2[ID])));
			echo "</nobr></a>";
			//echo ymd_datestr($r2[dt],"shortd");
			//echo "<br>";
			//echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			//echo "</font>";
?>
</div>
<?php 
 }
?>

<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.biblist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div></td>
</tr>
</table><?php 
/////////////////////////////////////////////////////////////////////
}

if ($catemap[displayformat]=="Sliding_Cover") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();

	$s2=tmq($biblistsql);

?><marquee onmouseover="stop();" onmouseout="start();"><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	
<?php  while ($r2=tfa($s2)) {?><td>
	<div style="display:block; width: 150; height:200 ; float:left; margin: 6px; "><?php  //echo $col1width;?>
	<?php 
	$link="<a href=\"$dcrURL"."dublin.php?ID=$r2[ID]\"  TITLE=\"".addslashes(marc_gettitle($r2[ID]))."\" target=_blank>";
	echo $link;
			?>
<?php 
	//$r2=tfa($s2);
$pid=$r2[pid];

	$img=res_cov_dsp($r2[ID],"","145","no","",'height:195px!important; float: left; margin-right: 5px; margin-top: 5px; ');
	//printr($img);
	echo $img;

			//echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a>";
			//echo ymd_datestr($r2[dt],"shortd");
			//echo "<br>";
			//echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			//echo "</font>";
?>
</div>
</td><?php 
 }
?>

</tr>
</table></marquee>
<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.biblist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div><?php 
/////////////////////////////////////////////////////////////////////
}

}



if ($s[type]=="newslist") {

$catemap=tmq("select * from webbox_newslist_catemap where pid='$s[id]' ");
$catemap=tfa($catemap);
//printr($catemap);
$cate=$catemap[cate];
$showcount=floor($catemap[showcount]);
if ($showcount<1) {
	$showcount=5;
}
if ($catemap[readmoretxt]=="") {
	$catemap[readmoretxt]="ดูเพิ่มเติม::l::read more";
}

if ($catemap[displayformat]=="List") {
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_newslist_list  where cate='$cate'  and isshow='yes' "; 
	$sql2 = "$sql2 order by dt desc limit $showcount ";

	$s2=tmq($sql2);
	?>
	<TABLE cellpadding=0 cellspacing=0 align=center width="100%" >

	<?php  
		while ($r=tmq_fetch_array($s2)) {
	?>
	<TR bgcolor=white>
		<TD > &nbsp;<img src="<?php  echo $dcrURL;?>neoimg/webpagemenu/<?php  echo $r[icon];?>" width=16 height=16>
		<?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.newslist.readall.php?pid=$r[pid]&news=$r[id]\" style='font-size: 12px;'>";
			echo $link;
		?><?php  echo stripslashes(getlang($r[title]));?></A> <?php 
			if ($r[tailicon]!="None.png") {	
		?> <img src="<?php  echo $dcrURL;?>neoimg/gificon/<?php  echo $r[tailicon];?>" height=12><?php 
		}	
		?>
	<font class=smaller2><?php  echo ymd_datestr($r[dt],"date")?></font>
	</TD>
	</TR>
	<?php 
		}	
	?>
	</TABLE><?php 
?> 
<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div>
<?php 
	/////////////////////////////////////////////////////////////////////
}
if ($catemap[displayformat]=="Grid") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_newslist_list  where cate='$cate'  and isshow='yes' "; 
	$sql2 = "$sql2 order by dt desc limit ".($showcount+2);

	$s2=tmq($sql2);
	$col1imgwidth=floor((floor($webbox_cur_columnwidth)*25)/100);
	$col1width=$webbox_cur_columnwidth-5;
	$col1imgwidth-=2;
?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td >
	<div style="display:inline-block; width: <?php  echo $col1width;?>px">
	<img src="<?php 
	$r2=tfa($s2);//printr($r2);
$pid=$r2[pid];
	$imgurl=fft_upload_get("webbox_newslist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.newslist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			echo $link;
			echo iconvth((( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";
?><div style="clear: both;"></div><?php 
	$r2=tfa($s2);
	if (trim($r2[id])!="") {
?><img src="<?php 
	$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_newslist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.newslist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";

	}?></div>
<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div>
</td>
</tr>
</table><?php 
/////////////////////////////////////////////////////////////////////
}
if ($catemap[displayformat]=="Grid_2_column") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_newslist_list  where cate='$cate'  and isshow='yes' "; 
	$sql2 = "$sql2 order by dt desc limit ".($showcount+2);

	$s2=tmq($sql2);
	$col1width=floor((floor($webbox_cur_columnwidth)*65)/100);
	$col2width=floor((floor($webbox_cur_columnwidth)*35)/100);
	$col1imgwidth=floor((floor($webbox_cur_columnwidth)*25)/100);
	$col1width-=2;
	$col1imgwidth-=2;
?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td width="<?php  echo $col1imgwidth;?>" style="width:<?php  echo $col1imgwidth;?>px;">
	<div style="display:inline-block; width: <?php  echo $col1width;?>px"><?php  //echo $col1width;?>
	<img src="<?php 
	$r2=tfa($s2);
$pid=$r2[pid];
	$imgurl=fft_upload_get("webbox_newslist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.newslist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";
?><div style="clear: both;"></div><?php 
	$r2=tfa($s2);
	if (trim($r2[id])!="") {
?><img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_newslist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.newslist.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";

	}?>
</div>
</td>
	<td width="<?php  echo $col2width;?>"><div style="display:inline-block; width: <?php  echo $col2width;?>">
	<?php  //echo $col2width;?><?php 
while ($r2=tfa($s2)) {
	?>
<img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_newslist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="20" style="float: left; margin-right: 5px; margin-top: 5px; max-height: 20px;" border=1><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.newslist.readall.php?pid=$r2[pid]&news=$r2[id]\"  class=smaller>";
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller2>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "</font>
			<div style='clear: both;'></div>";
}
?>
</div>
<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div>

</td>
</tr>
</table><?php 
/////////////////////////////////////////////////////////////////////
}

}

if ($s[type]=="topmenulist") {

$catemap=tmq("select * from webbox_topmenulist_catemap where pid='$s[id]' ");
$catemap=tfa($catemap);
$gettopmenuid=tmq("select * from webbox_topmenu_list where id='$catemap[cate]' ");
$gettopmenuid=tfa($gettopmenuid);
$gettopmenuid=tmq("select * from webbox_topmenu where id='$gettopmenuid[pid]' ");
$gettopmenuid=tfa($gettopmenuid);
$gettopmenuid=$gettopmenuid[id];
//printr($gettopmenuid);
//printr($catemap);
$cate=$catemap[cate];
$showcount=floor($catemap[showcount]);
if ($showcount<1) {
	$showcount=5;
}
if ($catemap[readmoretxt]=="") {
	$catemap[readmoretxt]="ดูเพิ่มเติม::l::read more";
}


if ($catemap[displayformat]=="2_Columns") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_customlist_list  where  cate in (select id from webbox_customlist_catesub where cateid='$cate')  and lower(isshow)='yes' "; 
	$sql2 = "$sql2 order by dt desc limit ".($showcount);

	$s2=tmq($sql2);

?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td width="<?php  echo $col1imgwidth;?>" style="width:<?php  echo $col1imgwidth;?>px;">
	
	<?php 
	
while ($r2=tfa($s2)) {
   ?><div style="display:block; width:  calc(49%);; height: 120px; float: left;">
   <a href="<?php echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $pid; ?>&news=<?php  echo $r2[id]; ?>"><img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_customlist_list","coverimg",$r2[id]);
	echo $imgurl[url];
?>" style="width:calc(30%);; float: left; margin: 10px; margin-top: 5px; height: 100px;" border=0>

<?php  echo stripslashes($r2[title]);?></a>
<?php echo "<br><font class=smaller2>";
         echo stripslashes($r2[descr])."<BR>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "</font>"; ?>
</div><?php 
}
	?>

</td>
</tr>
</table><div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div><?php 
/////////////////////////////////////////////////////////////////////
}

if ($catemap[displayformat]=="List") {
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_topmenu_list_sub  where pid='$cate'  and isshow='yes' "; 
	$sql2 = "$sql2 order by dt desc limit $showcount ";

	$s2=tmq($sql2);
	?>
	<TABLE cellpadding=0 cellspacing=0 align=center width="100%" >

	<?php  
		while ($r=tmq_fetch_array($s2)) {
	?>
	<TR bgcolor=white>
		<TD > &nbsp;<img src="<?php  echo $dcrURL;?>neoimg/webpagemenu/<?php  echo $r[icon];?>" width=16 height=16>
		<?php 
		$link="<a href=\"$dcrURL"."index.php?viewtopmenulist=yes&listid=$gettopmenuid&readid=$r[id]\" style='font-size: 12px;'>";
      if ($r[directurl]=="") {
         $link= "<a href=\"$r[directurl]\" target=_blank  style='font-size: 12px;'>";
      }
	  echo $link;
		?><?php  echo stripslashes(getlang($r[title]));?></A> <?php 
			if ($r[tailicon]!="None.png") {	
		?> <img src="<?php  echo $dcrURL;?>neoimg/gificon/<?php  echo $r[tailicon];?>" height=12><?php 
		}	
		?>
	<font class=smaller2><?php  echo ymd_datestr($r[dt],"date")?></font>
	</TD>
	</TR>
	<?php 
		}	
	?>
	</TABLE><?php 
?>

<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div>
<?php 
	/////////////////////////////////////////////////////////////////////
}
if ($catemap[displayformat]=="Grid") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_topmenu_list_sub  where pid='$cate'  and isshow='yes' "; 
	$sql2 = "$sql2 order by dt desc limit ".($showcount+2);

	$s2=tmq($sql2);
	$col1imgwidth=floor((floor($webbox_cur_columnwidth)*25)/100);
	$col1width=$webbox_cur_columnwidth-5;
	$col1imgwidth-=2;
?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td >
	<div style="display:inline-block; width: <?php  echo $col1width;?>px">
	<img src="<?php 
	$r2=tfa($s2);
$pid=$r2[pid];
	$imgurl=fft_upload_get("webbox_topmenu_list_sub","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."index.php?viewtopmenulist=yes&listid=$gettopmenuid&readid=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			  if ($r2[directurl]!="") {
				 $link= "<a href=\"$r2[directurl]\" target=_blank  style='font-weight: bold;'>";
			  }
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";
?><div style="clear: both;"></div><?php 
	$r2=tfa($s2);
	if (trim($r2[id])!="") {
?><img src="<?php 
	$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_topmenu_list_sub","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."index.php?viewtopmenulist=yes&listid=$gettopmenuid&readid=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			  if ($r2[directurl]!="") {
				 $link= "<a href=\"$r2[directurl]\" target=_blank  style='font-weight: bold;;'>";
			  }
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";

	}?></div>
<div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div>
</td>
</tr>
</table><?php 
/////////////////////////////////////////////////////////////////////
}
if ($catemap[displayformat]=="Grid_2_column") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_topmenu_list_sub  where pid='$cate'  and isshow='yes' "; 
	$sql2 = "$sql2 order by dt desc limit ".($showcount+2);

	$s2=tmq($sql2);
	$col1width=floor((floor($webbox_cur_columnwidth)*65)/100);
	$col2width=floor((floor($webbox_cur_columnwidth)*35)/100);
	$col1imgwidth=floor((floor($webbox_cur_columnwidth)*25)/100);
	$col1width-=2;
	$col1imgwidth-=2;
?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td width="<?php  echo $col1imgwidth;?>" style="width:<?php  echo $col1imgwidth;?>px;">
	<div style="display:inline-block; width: <?php  echo $col1width;?>px"><?php  //echo $col1width;?>
	<img src="<?php 
	$r2=tfa($s2);
$pid=$r2[pid];
	$imgurl=fft_upload_get("webbox_topmenu_list_sub","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."index.php?viewtopmenulist=yes&listid=$gettopmenuid&readid=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			  if ($r2[directurl]!="") {
				 $link= "<a href=\"$r2[directurl]\" target=_blank  style='font-weight: bold;;'>";
			  }
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";
?><div style="clear: both;"></div><?php 
	$r2=tfa($s2);
	if (trim($r2[id])!="") {
?><img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_topmenu_list_sub","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="<?php  echo $col1imgwidth;?>" style="float: left; margin-right: 5px; margin-top: 5px; max-height: <?php  echo floor($col1imgwidth*0.75);?>px;" border=1><?php 
			$link="<a href=\"$dcrURL"."index.php?viewtopmenulist=yes&listid=$gettopmenuid&readid=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;'>";
			  if ($r2[directurl]!="") {
				 $link= "<a href=\"$r2[directurl]\" target=_blank  style='font-weight: bold;;'>";
			  }
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "<br>";
			echo str_webpagereplacer(stripslashes(getlang( $r2[descr])));
			echo "</font>";

	}?>
</div>
</td>
	<td width="<?php  echo $col2width;?>"><div style="display:inline-block; width: <?php  echo $col2width;?>">
	<?php  //echo $col2width;?><?php 
while ($r2=tfa($s2)) {
	?>
<img src="<?php 
	//$r2=tfa($s2);
	$imgurl=fft_upload_get("webbox_topmenu_list_sub","coverimg",$r2[id]);
	echo $imgurl[url];
?>" width="20" style="float: left; margin-right: 5px; margin-top: 5px; max-height: 20px;" border=1><?php 
			$link="<a href=\"$dcrURL"."index.php?viewtopmenulist=yes&listid=$gettopmenuid&readid=$r2[id]\"  class=smaller>";
			  if ($r2[directurl]!="") {
				 $link= "<a href=\"$r2[directurl]\" target=_blank  class=smaller>";
			  }
			echo $link;
			echo str_webpagereplacer(stripslashes(getlang( $r2[title])));
			echo "</a><br><font class=smaller2>";
			echo ymd_datestr($r2[dt],"shortd");
			echo "</font>
			<div style='clear: both;'></div>";
}
?>
</div>

</td>
</tr>
</table><div style='clear: both;'></div>
<div align=right>
&nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.customlist.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang($catemap[readmoretxt]);?></A>
</div><?php 
/////////////////////////////////////////////////////////////////////
}

}

if ($s[type]=="calendar2") {

$catemap=tmq("select * from webbox_calendar2_catemap where pid='$s[id]' ");
$catemap=tfa($catemap);
//printr($catemap);
$cate=$catemap[cate];
$showcount=floor($catemap[showcount]);
if ($showcount<1) {
	$showcount=5;
}

if ($catemap[displayformat]=="List") {
/////////////////////////////////////////////////////////////////////
	$now=time();
	$sql2 ="SELECT *  FROM webbox_calendar2_list  where cate='$cate'  and isshow='yes' "; 
	$sql2 = "$sql2 order by dt desc limit $showcount";

	$s2=tmq($sql2);
	?>
	<TABLE cellpadding=0 cellspacing=0 align=center width="100%" >

	<?php  
		while ($r=tmq_fetch_array($s2)) {
	?>
	<TR bgcolor=white>
		<TD > &nbsp;<img src="<?php  echo $dcrURL;?>neoimg/webpagemenu/<?php  echo $r[icon];?>" width=16 height=16>
		<?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.calendar2.readall.php?pid=$r[pid]&news=$r[id]\" style='font-size: 12px;'>";
			echo $link;
		?><?php  echo stripslashes(getlang($r[title]));?></A> <?php 
			if ($r[tailicon]!="None.png") {	
		?> <img src="<?php  echo $dcrURL;?>neoimg/gificon/<?php  echo $r[tailicon];?>" height=12><?php 
		}	
		?>
	<font class=smaller2><?php  echo ymd_datestr($r[dt],"date")?></font>
	</TD>
	</TR>
	<?php 
		}	
	?>
	</TABLE><?php 
?> &nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.calendar2.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo getlang("ดูกิจกรรมทั้งหมด::l::View all");?></A>
<?php 
	/////////////////////////////////////////////////////////////////////
}
if ($catemap[displayformat]=="Grid") {
	//printr($_GET);
/////////////////////////////////////////////////////////////////////
	$now=time();
   //tmq("set names 'tis620';",true);
	$sql2 ="SELECT *  FROM webbox_calendar2_list  where cate='$cate'  and isshow='yes' "; 
	$sql2 = "$sql2 order by dt desc limit $showcount";
	$s2=tmq($sql2,false);
	$col1imgwidth=floor((floor($webbox_cur_columnwidth)*30)/100);
	$col1imgwidth-=2;
	$col2width=floor((floor($webbox_cur_columnwidth)*70)/100);
	$col2width-=2;
?><table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr valign=top>
	<td style="padding: 3px 3px 3px 3px;">
	<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<?php  while ($r2=tfa($s2)) {// printr($r2);
	$pid=$r2[pid];?>
	<tr valign=top>
		<td align=right style="border: 0px solid #999999; border-right-width: 1px;border-bottom-width: 1px; padding-right: 7px;">	<div style="display:inline-block; width: <?php  echo $col1imgwidth;?>px; font-size: 48px;">
		<font style="font-size: 12px;"><?php  echo iconvth($thaimonstrbrief[floor(date("m",$r2[dt]))]);?><br></font>
		<?php  echo iconvth(date("j",$r2[dt]));?>
		</div>
</td>
		<td style="border: 0px solid #999999; border-bottom-width: 1px;"><div style="display:inline-block; width: <?php  echo $col2width;?>px; padding-left: 3px;"><?php 
			$link="<a href=\"$dcrURL"."webbox/man.box.calendar2.readall.php?pid=$r2[pid]&news=$r2[id]\" style='xxxxfont-size: 12px; font-weight: bold;;' class=smaller>";
			echo $link;
			echo iconvth(str_webpagereplacer(stripslashes(getlang( $r2[title]))));
			echo "</a><br><font class=smaller2>";
			echo iconvth(str_webpagereplacer(stripslashes(getlang( $r2[descr]))));
			echo "<br>";
			echo iconvth(ymd_datestr($r2[dt],"time"));
			echo "</font>";
	
?></div></td>
	</tr>
	<?php  }?>
	</table>
 &nbsp;&nbsp;&nbsp;<A HREF="<?php  echo $dcrURL?>webbox/man.box.calendar2.readall.php?pid=<?php  echo $s[id]?>" target=_blank class="smaller2"><?php  echo iconvth(getlang("กิจกรรมทั้งหมด::l::View all"));?></A>
</td>
</tr>
</table><?php 
/////////////////////////////////////////////////////////////////////
}
}




?></div><?php


ob_end_flush();
?>