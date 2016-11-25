<?php 
	; 
  include ("./inc/config.inc.php");
  include ("./inc/feedcreator.class.php");

	$feed=trim($feed);
//define channel
$rss = new UniversalFeedCreator();
$rss->useCached();
$to_title=strip_tags(getlang(getval("global", "HEAD")));;
$to_title2=strip_tags(getlang(getval("global", "HEAD 2")));

		$to_title=iconvutf($to_title);
		$to_title2=iconvutf($to_title2);

$rss->title=$to_title;
$rss->description=$to_title2;
$rss->link=$dcrURL;
$rss->syndicationURL="$dcrURL/getfeed.php?feed=$feed";
  if ($feed=="") {
		 die("feed [$feed] not found");
	}



  if ($feed=="showcase") {
  //channel items/entries
	$to_title2=iconvutf(getlang("วัสดุสารสนเทศแนะนำ::l::Library's showcase"));
	$rss->description=$to_title2;
	$s=tmq("select * from index_db where remoteindex='localDB' and webpageshowcase='yes' ",false);
	while ($r=tmq_fetch_array($s)) {
    $item = new FeedItem();
		$titl=marc_gettitle($r[mid]);
		$titl=trim($titl);
		$auth=$r[auth];
		if (strlen($titl)>45) { $titl=substr($titl,0,45).'..'; }
		if (strlen($auth)>95) { $auth=substr($auth,0,95).'..'; }

		$titl=str_remspecialsign($titl);
		$auth=str_remspecialsign($auth);
		$titl=iconvutf($titl);
		$auth=iconvutf($auth);

		$tags=tmq("select * from media where ID='$r[mid]' ");
		$tags=tmq_fetch_array($tags);
		 $imgcover=res_cov_dsp($r[mid],$tags,60,"no"," style='margin: 1 1 1 1' ");
			$item->description = $imgcover;

		if ($titl=="") {
			 $titl="Untitled";
		}
   // $item->title = $titl.":".isUTF8($titl);
    $item->title = $titl;
    $item->link = "$dcrURL/dublin.php?ID=$r[mid]";
    //$item->description = $auth;
    $item->source = $rss->title;
    $item->author = $auth;
		$rss->addItem($item);
  }

}
/////////////////////////////////////////////////////////////

  if ($feed=="articlephoto") {
	/*
  //channel items/entries
  $rss->link=("$dcrURL/web/viewtopic.php?TID=$postid&amp;picalbum=yes");
	$_VAL_FILE_SAVEPATHurl=$webpageboarddcrURL."_files/";
	
  $catedata=tmq("select * from  webpage_articles where id='$postid' ");
  $catedata=tmq_fetch_array($catedata);
	$catedata[topic]=stripslashes($catedata[topic]);
	$rss->title=iconvutf($catedata[topic]);
	$to_title2=iconvutf($catedata[topic]);
	$rss->description=$to_title2;
	$s=tmq("select * from webpage_article_attatch where postid='$postid' ");
	while ($r=tmq_fetch_array($s)) {
    $item = new FeedItem();
		$titl=$r[filename];
		$titl=trim($titl);
		$thisurl=$_VAL_FILE_SAVEPATHurl."$r[hidename]";
		if (strlen($titl)>105) { $titl=substr($titl,0,105).'..'; }
		//echo "[$titl]";
		$titl=iconvutf($titl);

		if ($titl=="") {
			 $titl="Untitled";
		}
   // $item->title = $titl.":".isUTF8($titl);
    $item->title = $titl;
    $item->link = $thisurl;
    //$item->description = $auth;
		
    $item->source = $rss->title;
    $item->author = $auth;
		$rss->addItem($item);
		//
$image = new FeedImage(); 
$image->title = "dailyphp.net logo"; 
$image->url = $thisurl; 
$image->link = "http://www.dailyphp.net"; 
$image->description = "Feed provided by dailyphp.net. Click to visit."; 

//optional
$image->descriptionTruncSize = 500;
$image->descriptionHtmlSyndicated = true;

$rss->image = $image; 
//
  }
  
  //optional enclosure support
  $item->enclosure = new EnclosureItem();
  $item->enclosure->url=$dcrURL."/_tmp/logo/_weblogoicon.png";
  $item->enclosure->length=filesize($dcrs."/_tmp/logo/_weblogoicon.png");
  $item->enclosure->type=	'image/png';

  $rss->title=stripslashes($rss->title);
  $rss->description=stripslashes($rss->description);
  $rss->outputFeed("RSS2.0"); 
	*/
	echo "<"."?xml version=\"1.0\" encoding=\"utf-8\"?".">";
	?>
<rss version="2.0"
      xmlns:media="http://search.yahoo.com/mrss/"
	    xmlns:dc="http://purl.org/dc/elements/1.1/"
	   >
		 <?php 
		   $catedata=tmq("select * from  webpage_articles where id='$postid' ");
			 $thisurl="$dcrURL/web/viewtopic.php?TID=$postid&amp;picalbum=yes";
  $catedata=tmq_fetch_array($catedata);
	$catedata[topic]=stripslashes($catedata[topic]);
	$to_title=iconvutf($catedata[topic]);
		 ?>
	<channel>
		<title><?php  echo $to_title?></title>
		<link><?php  echo $thisurl?></link>
 		<description></description>
		<pubDate><?php  echo iconvutf(strip_tags(ymd_datestr(time())));?></pubDate>

		<lastBuildDate><?php  echo iconvutf(strip_tags(ymd_datestr(time())))?></lastBuildDate>
		<generator><?php  echo $dcrURL?></generator>
<?php 

$s=tmq("select * from webpage_article_attatch where postid='$postid' ");
	$_VAL_FILE_SAVEPATHurl=$webpageboarddcrURL."_files/";
	while ($r=tmq_fetch_array($s)) {
		$titl=$r[filename];
		$titl=trim($titl);
		$titl=str_remspecialsign($titl);
		if (file_exists($webpageboarddcrURL."_files/$r[hidename].thumb.jpg")) {
			$thisurl=$_VAL_FILE_SAVEPATHurl."$r[hidename].thumb.jpg";
		} else {
			$thisurl=$_VAL_FILE_SAVEPATHurl."$r[hidename]";
		}
		if (strlen($titl)>105) { $titl=substr($titl,0,105).'..'; }
		//echo "[$titl]";
		$titl=iconvutf($titl);

		if ($titl=="") {
			 $titl="Untitled";
		}
	?><item>
			<title><?php  echo (stripslashes($titl))?></title>
			<link><?php  echo $thisurl;?></link>
			<description>posted a photo &lt;img width=40 src=&quot;<?php  echo $thisurl;?>&quot; &gt;</description>
			<pubDate>Fri, 9 Feb 2007 18:09:40 -0800</pubDate>

            <media:content url="<?php  echo $thisurl;?>" 
				       type="image/jpeg"
				       height="240"
				       width="180"/>
            <media:title><?php  echo (stripslashes($titl))?></media:title>
        <media:thumbnail url="<?php  echo $thisurl;?>.thumb.jpg" height="75" width="75" />

		</item>
<?php 
	}
?>
		
</channel>
</rss><?php 
	die;
}
/////////////////////////////////////////////////////////////
  if ($feed=="webboard" && $boardcate!="") {
		$to_title=iconvutf(getlang(barcodeval_get("webboard-boardname")));
		$rss->title=$to_title;
		$catedata=tmq("select * from  webboard_boardcate where id='$boardcate' ");
		$catedata=tmq_fetch_array($catedata);
		$catedata=getlang($catedata[name]);
  	$to_title2=iconvutf(getlang("หัวข้อ: $catedata::l::Forum: $catedata"));
  	$rss->description=$to_title2;
    $s="select * from webboard_posts where nestedid=0 and boardid='$boardcate'  ";
   	$s.= " and ishide<>'yes' ";
    $s.= " order by lastactive desc limit 50 ";
		$s=tmq($s);
  		while ($r=tmq_fetch_array($s)) {
        $item = new FeedItem();
    		$titl=$r[topic];
    		$titl=trim($titl);
				
				
	if ($r[tmid]=="") {
		if ($r[memid]=="") {
			$auth= "".getlang("โดย ผู้เยี่ยมชม::l::By visitor");;
		} else {
			$auth=strip_tags(get_member_name($dat[memid]));
		}

	} else {
		$auth= strip_tags(get_library_name($dat[tmid]));
	}

    		$titl=str_remspecialsign($titl);
    		$auth=str_remspecialsign($auth);
    
    		if (strlen($titl)>105) { $titl=substr($titl,0,105).'..'; }
    		if (strlen($auth)>95) { $auth=substr($auth,0,95).'..'; }
    
    		$titl=iconvutf($titl);
    		$auth=iconvutf($auth);
    

    		if ($titl=="") {
    			 $titl="Untitled";
    		}
       // $item->title = $titl.":".isUTF8($titl);
        $item->title = $titl;
        $item->link = "$dcrURL/webboard/viewtopic.php?TID=$r[id]";
        //$item->description = $auth;
        $item->source = $rss->title;
        $item->author = $auth;
    		$rss->addItem($item);
    }
	}
		/////////////////////////////////////////////////////////////
  if ($feed=="webboardnewest" ) {
		$to_title=iconvutf(getlang(barcodeval_get("webboard-boardname")));
		$rss->title=$to_title;
		$catedata=tmq("select * from  webboard_boardcate where id='$boardcate' ");
		$catedata=tmq_fetch_array($catedata);
		$catedata=getlang($catedata[name]);
  	$to_title2=iconvutf(getlang("โพสท์ใหม่::l::Newest posts"));
  	$rss->description=$to_title2;
		$sql2 ="SELECT *  FROM webboard_boardcate where 1 "; 
    $sql2 = "$sql2 and isshowtouser='yes' ";
    $sql2 = "$sql2 order by ordr,name";
		$s1=tmq($sql2);
		$sql2="0";
		while ($r1=tmq_fetch_array($s1)) {
					$sql2.=" or boardid='$r1[id]' ";
		}
    $s="select * from webboard_posts where nestedid=0 and ($sql2) ";
   	$s.= " and ishide<>'yes' ";
    $s.= " order by lastactive desc limit 0,50 ";
		$s=tmq($s,false);
		//echo tmq_num_rows($s);
  		while ($r=tmq_fetch_array($s)) {
        $item = new FeedItem();
    		$titl=$r[topic];
    		$titl=trim($titl);
				
				
	if ($r[tmid]=="") {
		if ($r[memid]=="") {
			$auth= "".getlang("โดย ผู้เยี่ยมชม::l::By visitor");;
		} else {
			$auth=strip_tags(get_member_name($dat[memid]));
		}
	} else {
		$auth= strip_tags(get_library_name($dat[tmid]));
	}

    		$titl=str_remspecialsign($titl);
    		$auth=str_remspecialsign($auth);

    		if (strlen($titl)>105) { $titl=substr($titl,0,105).'..'; }
    		if (strlen($auth)>95) { $auth=substr($auth,0,95).'..'; }
    
    		$titl=iconvutf($titl);
    		$auth=iconvutf($auth);
    

    		if ($titl=="") {
    			 $titl="Untitled";
    		}
       // $item->title = $titl.":".isUTF8($titl);
        $item->title = $titl;
        $item->link = "$dcrURL/webboard/viewtopic.php?TID=$r[id]";
        //$item->description = $auth;
        $item->source = $rss->title;
        $item->author = $auth;
    		$rss->addItem($item);
    }

	}
	/////////////////////////////////////////////////////////////
	
  if ($feed=="bibrating") {
  //channel items/entries
	$to_title2=iconvutf(getlang("Materials by rating"));
	$rss->description=$to_title2;
	$s="select * from webpage_bibrating_sum where 1 order by votescore desc limit 50 ";
	$s=tmq($s);
	while ($r=tmq_fetch_array($s)) {
    $item = new FeedItem();
		$titl=marc_gettitle($r[bibid]);
		//$titl=iconvutf($titl);
		$titl=trim($titl);
		$auth=marc_getauth($r[bibid]);
		$auth=trim($auth);
		//$auth=iconvutf($auth);
		$titl=str_remspecialsign($titl);
		$auth=str_remspecialsign($auth);

		if (strlen($titl)>105) { $titl=substr($titl,0,105).'..'; }
		if (strlen($auth)>95) { $auth=substr($auth,0,95).'..'; }

		$titl=iconvutf($titl);
		$auth=iconvutf($auth);
		//echo "[$titl]";

		if ($titl=="") {
			 $titl=iconvutf("Untitled");
		}
   // $item->title = $titl.":".isUTF8($titl);
    $item->title = $titl;
    $item->link = "$dcrURL/dublin.php?ID=$r[bibid]";
   // $item->description = number_format($r[votescore],2)."/".number_format($r[votecount]);
    $item->description = "Rated: ".number_format($r[votescore],1);
    $item->source = iconvutf($rss->title);
    $item->author = iconvutf($auth);
		$rss->addItem($item);
  }
  

}
/////////////////////////////////////////////////////////////
if ($feed=="collection") {
	$cinfo=tmq("select * from collections where classid='$collectionid' ");
	$cinfo=tmq_fetch_array($cinfo);

	$to_title2=$to_title;
	$rss->title=iconvutf(getlang("$cinfo[name]"));
	$rss->description=$to_title;
	$usecollection=Array();
	$usecollection[$cinfo[id]]="yes";

/*	Array
(
    [3] => no
    [2] => yes
    [1] => yes
)
*/
	$search_inc_sqlcollection_quiet="yes";
	include("search.inc.sqlcollection.php");
	$s="select * from index_db where remoteindex='localDB' and  1 $collectionsql order by id desc limit 50 ";
	$s=tmq($s,false);
	while ($r=tmq_fetch_array($s)) {
    $item = new FeedItem();
		$titl=marc_gettitle($r[mid]);
		//$titl=iconvutf($titl);
		$titl=trim($titl);
		$auth=marc_getauth($r[mid]);
		$auth=trim($auth);
		//$auth=iconvutf($auth);
		$titl=str_remspecialsign($titl);
		$auth=str_remspecialsign($auth);

		if (strlen($titl)>105) { $titl=substr($titl,0,105).'..'; }
		if (strlen($auth)>95) { $auth=substr($auth,0,95).'..'; }

		$titl=iconvutf($titl);
		$auth=iconvutf($auth);
		//echo "[$titl]";

		if ($titl=="") {
			 $titl=iconvutf("Untitled");
		}
   // $item->title = $titl.":".isUTF8($titl);
    $item->title = $titl;
    $item->link = "$dcrURL/dublin.php?ID=$r[mid]";
   // $item->description = number_format($r[votescore],2)."/".number_format($r[votecount]);
   $cov=res_cov_dsp($r[mid],"no",45);
	$cov=iconvutf($cov);
   $item->description = $cov;
    $item->source = iconvutf($rss->title);
    $item->author = iconvutf($auth);
		$rss->addItem($item);
  }
}
/////////////////////////////////////////////////////////////
if ($feed=="bibreview") {

	$rss->title=iconvutf(getlang("บรรณนิทัศน์::l::Reviewed by librarian"));
	$rss->description=$to_title;

	$s="select * from webpage_showcase where length(text)>3 order by id desc limit 50 ";
	$s=tmq($s,false);
	while ($r=tmq_fetch_array($s)) {
    $item = new FeedItem();
		$titl=marc_gettitle($r[mid]);
		//$titl=iconvutf($titl);
		$titl=trim($titl);
		$auth=marc_getauth($r[mid]);
		$auth=trim($auth);
		//$auth=iconvutf($auth);
		$titl=str_remspecialsign($titl);
		$auth=str_remspecialsign($auth);

		if (strlen($titl)>105) { $titl=substr($titl,0,105).'..'; }
		if (strlen($auth)>95) { $auth=substr($auth,0,95).'..'; }

		$titl=iconvutf($titl);
		$auth=iconvutf($auth);
		//echo "[$titl]";

		if ($titl=="") {
			 $titl=iconvutf("Untitled");
		}
   // $item->title = $titl.":".isUTF8($titl);
    $item->title = $titl;
    $item->link = "$dcrURL/dublin.php?ID=$r[mid]";
   // $item->description = number_format($r[votescore],2)."/".number_format($r[votecount]);
   $cov=res_cov_dsp($r[mid],"no",45);
	$cov=iconvutf($cov);
   $item->description = $cov;
    $item->source = iconvutf($rss->title);
    $item->author = iconvutf($auth);
		$rss->addItem($item);
  }
}
 
/////////////////////////////////////////////////////////////
if ($feed=="bibcomment") {

	$rss->title=iconvutf(getlang("Book Comment"));
	$rss->description=$to_title;

	$s="select distinct bibid  from webpage_bookcomment where length(body)>5 order by id desc limit 50 ";
	$s=tmq($s,false);
	while ($r=tmq_fetch_array($s)) {
    $item = new FeedItem();
		$titl=marc_gettitle($r[bibid]);
		//$titl=iconvutf($titl);
		$titl=trim($titl);
		if ($titl=="") {
			continue;
		}
		$auth=marc_getauth($r[bibid]);
		$auth=trim($auth);
		//$auth=iconvutf($auth);
		$titl=str_remspecialsign($titl);
		$auth=str_remspecialsign($auth);

		if (strlen($titl)>105) { $titl=substr($titl,0,105).'..'; }
		if (strlen($auth)>95) { $auth=substr($auth,0,95).'..'; }

		$titl=iconvutf($titl);
		$auth=iconvutf($auth);
		//echo "[$titl]";

		if ($titl=="") {
			 $titl=iconvutf("Untitled");
		}
   // $item->title = $titl.":".isUTF8($titl);
    $item->title = $titl;
    $item->link = "$dcrURL/dublin.php?ID=$r[bibid]";
   // $item->description = number_format($r[votescore],2)."/".number_format($r[votecount]);
   $cov=res_cov_dsp($r[bibid],"no",45);
	$cov=iconvutf($cov);
   $item->description = $cov;
    $item->source = iconvutf($rss->title);
    $item->author = iconvutf($auth);
		$rss->addItem($item);
  }
} /////////////////////////////////////////////////////////////////////////////

if ($feed=="membermatfeed") {
$chk=tmq("select * from member where UserAdminID='$memid' and publishbookinfo='yes' ");
if (tmq_num_rows($chk)==0 && loginchk_lib("check")==false) {
	die("user not publish their info.");
}
	$moddb[favbook]="หนังสือในรายการโปรด::l::My Favourite books";
	$moddb[comment]="แสดงความเห็น::l::Commented";
	$moddb[tagged]="ให้แท็ก::l::Tagged";
	$moddb[rating]="ให้คะแนน::l::Give Rating";

	$rss->title=iconvutf(getlang($moddb[$mode]));
	$memname=get_member_name($memid);
	$memname=str_remspecialsign($memname);
	$memname=iconvutf($memname);

	$rss->description=strip_tags($memname);


	if ($mode=="favbook") {
		$s=tmq("select * from webpage_memfavbook where memid='$memid' order by rand(); ");
	}
	if ($mode=="comment") {
		$s=tmq("select distinct bibid from webpage_bookcomment where memid='$memid' order by rand(); ");
	}
	if ($mode=="tagged") {
		$s=tmq("select * from webpage_bibtag where memid='$memid' order by bibid, rand(); ");
	}
	if ($mode=="rating") {
		$s=tmq("select * from  webpage_bibrating_log where memid='$memid' order by rand(); ");
	}


	while ($r=tmq_fetch_array($s)) {
    $item = new FeedItem();
		$titl=marc_gettitle($r[bibid]);
		//$titl=iconvutf($titl);
		$titl=trim($titl);
		if ($titl=="") {
			continue;
		}
		$auth=marc_getauth($r[bibid]);
		$auth=trim($auth);
		//$auth=iconvutf($auth);
		$titl=str_remspecialsign($titl);
		$auth=str_remspecialsign($auth);

		if (strlen($titl)>105) { $titl=substr($titl,0,105).'..'; }
		if (strlen($auth)>95) { $auth=substr($auth,0,95).'..'; }

		$titl=iconvutf($titl);
		//$auth=iconvutf($auth);
		//echo "[$titl]";

		if ($titl=="") {
			 $titl=iconvutf("Untitled");
		}
   // $item->title = $titl.":".isUTF8($titl);
    $item->title = $titl;
    $item->link = "$dcrURL/dublin.php?ID=$r[bibid]";
   // $item->description = number_format($r[votescore],2)."/".number_format($r[votecount]);
   $cov=res_cov_dsp($r[bibid],"no",45);
	$cov=iconvutf($cov);
   $item->description = $cov;
    $item->source = iconvutf($rss->title);
    $item->author = iconvutf($auth);
		$rss->addItem($item);
  }
} /////////////////////////////////////////////////////////////////////////////
  
  //optional enclosure support
  $item->enclosure = new EnclosureItem();
  $item->enclosure->url=$dcrURL."/_tmp/logo/_weblogoicon.png";
  $item->enclosure->length=filesize($dcrs."/_tmp/logo/_weblogoicon.png");
  $item->enclosure->type=	'image/png';

  $rss->title=stripslashes($rss->title);
  $rss->description=stripslashes($rss->description);
  $rss->outputFeed("RSS2.0"); 

/////////////////////////////////////////////////////////////
//$rss->saveFeed("ATOM1.0", "news/feed.xml"); 
//Valid parameters are RSS0.91, RSS1.0, RSS2.0, PIE0.1 (deprecated),
// MBOX, OPML, ATOM, ATOM1.0, ATOM0.3, HTML, JS
?>