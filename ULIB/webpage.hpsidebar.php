<?php 
$sidebars=tmq("select * from webpage_hpsidebar where isshow='yes' and locate='$webpage_hpsidebarmode' order by ordr",false);

$limitFeedTitleLength=5;
while ($sidebarr=tmq_fetch_array($sidebars)) {
	if ($sidebarr[type]=="html") {
		?><!-- ITEM:<?php  echo $sidebarr[name]?> --><?php 
		$sidebarrdat=tmq("select * from webpage_hpsidebar_content where refid='$sidebarr[id]' ");
		$sidebarrdat=tmq_fetch_array($sidebarrdat);
		$sidebarrdat[title]=getlang(trim($sidebarrdat[title]));
		//printr($sidebarrdat);
		if ($sidebarrdat[title]!="") {
			?><FONT style="border-color: 999999; border-style: dotted; border-width: 0; border-bottom-width: 3 ; font-size: 20px; font-weight: bold; display: block; width: 90%"><?php  echo stripslashes($sidebarrdat[title])?></FONT><BR><?php 
		}
		echo "<span class=sidebarstriptagp>".stripslashes($sidebarrdat[body])."</span>";
		?><?php 
	}
	if ($sidebarr[type]=="weeklybook") {

$wlw=floor(date('t'));
$wlw=floor(date('j') / ($wlw/4));
//$wlw=@floor(26 / ($wlw/4));
//echo "[$wlw]";
if ($wlw>3) {$wlw=3;}
$wlw++;
	$wbinfo=tmq("select * from webpage_weeklybook where yea='".date("Y")."' and mon='".date("n")."' and week='".$wlw."' ");
	if (tmq_num_rows($wbinfo)==0) {
		continue;
	}
		?><TABLE border=0 cellpadding=0 cellspacing=0 width="210">
<TR><TD height=20 background="<?php  echo "$dcrURL"."neoimg/bookcase/header.jpg";?>" colspan=5
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
	}
	if ($sidebarr[type]=="mocalen") {
		?><CENTER><B>ปฏิทินกิจกรรม</B><BR><iframe width=200 height=180 src="<?php  echo $dcrURL?>webpage.calendar.php" FRAMEBORDER="NO" BORDER=0 SCROLLING=NO ></iframe></CENTER><?php 
		//include("$dcrs/webpage.inc.mocal.php");
	}
	if ($sidebarr[type]=="tab") { /////////////////////////////////////////////////////////////////////////////////////////////// tabs start
		$tabrandid="tabja".randid();
		//echo "tab here";
		$tabssql="select * from webpage_hpsidebar_tabs where locate='$sidebarr[id]' and isshow='yes' order by ordr";
		$tabs=tmq($tabssql,false);
			if ($_HPSIDEBARTAB_htmled!="yes") {
				?><link rel="stylesheet" type="text/css" href="./js/tabcontent.css" />
				<script type="text/javascript" src="./js/tabcontent.js">/************************************************ Tab Content script v2.2-  Dynamic Drive DHTML code library (www.dynamicdrive.com)* This notice MUST stay intact for legal use* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code***********************************************/</script><?php 
			}
			//start gen tab btn
			?><ul id="<?php echo $tabrandid;?>" class="shadetabs"><?php 
			while ($tabr=tmq_fetch_array($tabs)) {
				?><li><a href="#" rel="tab<?php  echo $tabrandid?>_<?php  echo $tabr[id]?>" class="selected"><?php  echo getlang(stripslashes($tabr[name]));?></a></li><?php 
			}
			?></ul><?php 
			//end gen tab btn
			//start gen tab body
			?><div style="border:1px solid gray; width:200px; margin-bottom: 1em; padding: 10px; background-image: url('./neoimg/tabbg.jpg'); background-position: right bottom;padding-bottom:20;"><?php 
			$tabs=tmq($tabssql,false);
			while ($tabr=tmq_fetch_array($tabs)) {
				?><div id="tab<?php  echo $tabrandid?>_<?php  echo $tabr[id]?>" class="tabcontent"><?php 
			
			//printr($tabr);
			if ($tabr[type]=="html") {
				$sidebarrdat=tmq("select * from webpage_hpsidebar_tabs_content where refid='$tabr[id]' ",false);
				$sidebarrdat=tmq_fetch_array($sidebarrdat);
				$sidebarrdat[title]=getlang(trim($sidebarrdat[title]));
				//printr($sidebarrdat);
				if ($sidebarrdat[title]!="") {
					?><FONT style="border-color: 999999; border-style: dotted; border-width: 0; border-bottom-width: 3 ; font-size: 20px; font-weight: bold; display: block; width: 90%"><?php  echo stripslashes($sidebarrdat[title])?></FONT><?php 
				}
				echo "<span class=sidebarstriptagp>".stripslashes($sidebarrdat[body])."</span>";
			}
			if ($tabr[type]=="rss") {
				$sidebarrdat=tmq("select * from webpage_hpsidebar_tabs_url where refid='$tabr[id]' ");
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
				
				$FeedMaxItems = floor($sidebarrdat[maxitem]);
				if ($FeedMaxItems<1) {
					$FeedMaxItems=10;
				}
				//echo "[$FeedMaxItems]";
				//include("$dcrs/inc/rss2html/rss2html.php");
				include("$dcrs/inc/rss2html/ulibrss.php");
			}
			?></div><?php 
		}
	?></div><?php 

		?>
<script type="text/javascript">

var countries=new ddtabcontent("<?php echo $tabrandid;?>")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>

<?php 
	} /////////////////////////////////////////////////////////////////////////////////////////////// tabs end
	if ($sidebarr[type]=="rss") {
		$sidebarrdat=tmq("select * from webpage_hpsidebar_url where refid='$sidebarr[id]' ");
		$sidebarrdat=tmq_fetch_array($sidebarrdat);
		//echo "";printr($sidebarrdat); echo "[$XMLfilename]";// die;
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
	}
	echo "<img src='./neoimg/spacer.gif' width=190 height=6 border=0><BR>";
}
?>