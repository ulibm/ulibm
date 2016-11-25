<?php 
;
      include("inc/config.inc.php"); //พ
	  html_start();
		if ($mode=="") {
			 redir(urldecode($url));
			 die;
		}

	  $extc=tmq("select * from dbfulltext_cate where code='$mode'");
		if (tmq_num_rows($extc)==0) {
			 redir(urldecode($url));
			 die;
  	} else {
			$extc=tmq_fetch_array($extc);
			$extc[dsp]=stripslashes($extc[dsp]);
			$url=urldecode($url);
			$usecode=str_replace('[[url]]',$url,$extc[dsp]);
			$usecode=str_replace('[[url]]',$url,$usecode);
			$usecode=str_replace('[[url]]',$url,$usecode);
			$usecode=str_replace('[[url]]',$url,$usecode);
			$usecode=str_replace('[[url]]',$url,$usecode);
			$usecode=str_replace('[[url]]',$url,$usecode);
			$usecode=str_replace('[[url]]',$url,$usecode);
			$usecode=str_replace('[[url]]',$url,$usecode);
			$usecode=str_replace('[[url]]',$url,$usecode);
			
			$usecode=str_replace('[[dcrurl]]',$dcrURL,$usecode);
			$usecode=str_replace('[[dcrurl]]',$dcrURL,$usecode);
			$usecode=str_replace('[[dcrurl]]',$dcrURL,$usecode);
			
						
			?><table bgcolor=ffffff cellpadding=0 cellspacing=5 align=center width=100% height=100%><tr><td bgcolor=eeeeee  align=center><?php 
			echo $usecode;
			?></td></tr></table><?php 
		}

?>