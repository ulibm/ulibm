<?PHP
  // define script parameters
  $BLOGURL    = $XMLfilename;
  $NUMITEMS   = $FeedMaxItems;
  $TIMEFORMAT = "j F Y, g:ia";
  $CACHEFILE  = $dcrs."/_tmp/rsstmp/" . md5($BLOGURL);
  $CACHETIME  = 4; // hours

  // download the feed iff a cached version is missing or too old
  if(!file_exists($CACHEFILE) || ((time() - filemtime($CACHEFILE)) > 3600 * $CACHETIME)) {
    if($feed_contents = file_get_contents($BLOGURL)) {
      // write feed contents to cache file
      $fp = fopen($CACHEFILE, 'w');
      fwrite($fp, $feed_contents);
      fclose($fp);
    }
  }

  //echo($dcrs."inc/rss2html/class.myrssparser.php");
  include_once($dcrs."inc/rss2html/class.myrssparser.php");
  $rss_parser = new myRSSParser($CACHEFILE);
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
	$tp=file_get_contents($TEMPLATEfilename);
	//echo $TEMPLATEfilename;
	//echo $tp;
   $tpa=explode("~~~BeginItemsRecord~~~",$tp);
   $tphead=$tpa[0];
   $tpbody=$tpa[1];
   $tpbodya=explode("~~~EndItemsRecord~~~",$tpbody);
   $tpbody=$tpbodya[0];
   //echo "<hr>$tphead<hr>$tpbody<hr>";
  // read feed data from cache file
  $feeddata = $rss_parser->getRawOutput();
  extract($feeddata['RSS']['CHANNEL'][0], EXTR_PREFIX_ALL, 'rss');

  // display leading image
  /*if(isset($rss_IMAGE[0]) && $rss_IMAGE[0]) {
    extract($rss_IMAGE[0], EXTR_PREFIX_ALL, 'img');
    echo "<p><a title=\"{$img_TITLE}\" href=\"{$img_LINK}\"><img src=\"{$img_URL}\" alt=\"\"></a></p>\n";
  }*/
$tphead=str_replace("~~~FeedTitle~~~",$rss_TITLE,$tphead);
$tphead=str_replace("~~~FeedDescription~~~",$rss_DESCRIPTION,$tphead);
  // display feed title
  /*echo "<h4><a title=\"",htmlspecialchars($rss_DESCRIPTION),"\" href=\"{$rss_LINK}\" target=\"_blank\">";
  echo htmlspecialchars($rss_TITLE);
  echo "</a></h4>\n";*/
  //echo "[$sidebarrdat[encode]]";
  if ($sidebarrdat[encode]=="tis620") {
   $tphead=iconvth($tphead);
  }
  if ($sidebarrdat[encode]=="utf8") {
   $tphead=iconvutf($tphead);
  }
  echo stripslashes($tphead);
  // display feed items
  $count = 0;
  foreach($rss_ITEM as $itemdata) {
  $thistp=$tpbody;
  $thistp=str_replace("~~~ItemLink~~~",$itemdata['LINK'],$thistp);
  $thistp=str_replace("~~~ItemTitle~~~",$itemdata['TITLE'],$thistp);
  $thistp=str_replace("~~~ItemDescription~~~",$itemdata['DESCRIPTION'],$thistp);

    //echo "<p><b><a href=\"{$itemdata['LINK']}\" target=\"_blank\">";
    //echo htmlspecialchars(stripslashes($itemdata['TITLE']));
    //echo "</a></b><br>\n";
   // echo htmlspecialchars(stripslashes($itemdata['DESCRIPTION'])),"<br>\n";
   // echo "<i>",date($TIMEFORMAT, strtotime($itemdata['PUBDATE'])),"</i></p>\n\n";
  if ($sidebarrdat[encode]=="tis620") {
   $thistp=iconvth($thistp);
  }
  if ($sidebarrdat[encode]=="utf8") {
   $thistp=iconvutf($thistp);
  }
     echo stripslashes($thistp);
    if(++$count >= $NUMITEMS) break;
  }

  // display copyright information
  //echo "<p><small>&copy; {",htmlspecialchars($rss_COPYRIGHT),"}</small></p>\n";
  //	echo $tp;

?>
