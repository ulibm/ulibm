<?php  //พ
	; set_time_limit(600);

        include ("../inc/config.inc.php");

function local_isbeenthere($url) {
	$s=tmq("select id from sitemap_temp where url='$url' ");
	if (tnr($s)==0) {
		return false;
	}
	return true;
}
function local_isbeenthere_done($url) {
	$s=tmq("select id from sitemap_temp where url='$url' and isdone='yes' ");
	if (tnr($s)==0) {
		return false;
	}
	return true;
}
function local_crawl_page() {
	$s=tmq("select * from sitemap_temp where isdone='no' ");
	if (tnr($s)==0) {
		?> all is done;<?php 
		redir("index.php?create=yes",0);
		die;
	}
	$s=tfa($s);
	$url=$s[url];
	global $basepath; 
	global $maxcrawllevel; 
	global $dcrURL; 
	$urla=explode("#",$url);
	$url=$urla[0];
	$url=trim($url);
	echo "<br>[$url]<br>";

	$basepathchk=strtolower(substr($url,0,strlen($basepath)));
	if (strtolower($basepath)!=$basepathchk) { // off site
		echo "OFF BASEPATH1$basepath!=$basepathchk\n";
		return;
	}
	//depth check
	if (floor($s[depth1]+1)<=floor(barcodeval_get("setdepth"))) {
	////////////////////////check ct s
	 # the request
	  $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/html')); 
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');

	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_exec($ch);

	  # get the content type
	  $tmpct= curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		$tmpct=trim($tmpct);
		if (substr($tmpct,0,strlen("text/html;"))!="text/html;") {
			echo "<b style='color:darkred;'>not.html</b> ";
			tmq("update sitemap_temp set isdone='bad' where id='$s[id]' ",false);
			
		} else {
		
				///////////////////////check ct e
				$str = file_get_contents($url);
				$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
				$regexp="/$regexp/siU";
				preg_match_all($regexp,$str,$matches);
				//echo '<pre>';
				//print_r($matches);    /* For All matches*/
				//For Text Name
				@reset($matches);
				while (list($k,$v)=each($matches[0])) {
					$pos = strpos($matches[0][$k], "nofollow");
					if ($pos === false) {
						//echo "The string '$findme' was not found in the string '$mystring'";
						//continue;
						/*
						echo "\n".$matches[0][$k]."0-";
						echo "\n".$matches[1][$k]."1-";
						echo "\n".$matches[2][$k]."2-";
						echo "\n".$matches[3][$k]."3-";
						echo "\n".$matches[4][$k]."4-
						";*/
						//$matches[0][$k]=strip_tags($matches[0][$k]);
						$matches[2][$k]=trim($matches[2][$k],".'\" ");
						$pos1 = strpos($matches[2][$k], "http://");
						$pos2 = strpos($matches[2][$k], "http://");
						$pos3 = strpos($matches[2][$k], "ftp://");
						if ($pos1 === false && $pos2 === false && $pos3 === false) {
							$matches[2][$k]=ltrim($matches[2][$k],"/");
							$matches[2][$k]=$basepath.$matches[2][$k];
						}
						$urllocal=$matches[2][$k];
						$urla=explode("#",$urllocal);
						$urllocal=$urla[0];
						$urllocal=trim($urllocal);
						//$seen[$urllocal] = true;

						$basepathchk=strtolower(substr($urllocal,0,strlen($basepath)));
						if (strtolower($basepath)!=$basepathchk) { // off site
							//echo "OFF BASEPATH 2 $basepath!=$basepathchk<br>";
						} else {
							//echo "adding $urllocal<br>";
							$chkcc=tmq("select id from sitemap_temp where url='$urllocal' ");
							if (tnr($chkcc)==0) {
								tmq("insert into sitemap_temp set url='$urllocal',depth1='".($s[depth1]+1)."' ");
								echo "<b  style='color:darkgreen;'>adding</b> ";
							} else {
								echo "<b  style='color:gray;'>dup</b> ";
							}
						}
					} else {
					}
					//print_r($v);
					//local_crawl_page($href, $local_depth - 1,$nodeval);
				}
		}
	} else {
		echo "<b style='color:darkred;'>DEPTH&gt;".floor(barcodeval_get("setdepth"))."</b> ";
	}
	tmq("update sitemap_temp set isdone='yes' where id='$s[id]' ",false);
	//printr($matches); //output : Akki Khambhata


       // 

	//echo "$local_depth - $url ;$nodeval <br>";
    //echo "$local_depth - URL:",$url,PHP_EOL,"CONTENT:",PHP_EOL;//,$dom->saveHTML(),PHP_EOL,PHP_EOL;
}
$maxcrawllevel=9; // max 9
$basepath=$dcrURL;
//local_crawl_page("$dcrURL", 1);
$basepath="http://202.28.32.22/msuact/";
		if ($firsttimesubmit=="yes") {
			barcodeval_set("setdepth",floor($setdepth));
			tmq("delete from sitemap_temp;",true);
			tmq("insert into sitemap_temp set url='http://202.28.32.22/msuact/index.php' ");

			local_crawl_page();
			redir("gen.php",0);
		} else {
			local_crawl_page();
			local_crawl_page();
			local_crawl_page();
			local_crawl_page();
			local_crawl_page();
			local_crawl_page();
			local_crawl_page();
			local_crawl_page();
			local_crawl_page();
			local_crawl_page();
			$c=tmq("select id from sitemap_temp where isdone='yes' ");
			echo "<HR noshade> Processed ".tnr($c)."<br>";;
			$c=tmq("select id from sitemap_temp where isdone='no' ");
			echo " Waiting ".tnr($c)."<br>";;
			redir("gen.php",0);
		}

?>