<?php 
; //พ
      include("inc/config.inc.php");
	  html_start("no");
?><?php 
$url=urldecode($url);
$url=urldecode($url);
$url=urldecode($url);
$url=urlencode($url);
	$urlstat=explode('/',$url);
	//printr($urlstat);
	$statid=$urlstat[count($urlstat)-2];
	$statfttype=$urlstat[count($urlstat)-3];
	statordr_add("ft_resid","$statid");
	stat_add("ft_fttype",$statfttype);

	
	//dspcontrol
	/*$ext=explode('.',$url);


	$ext=$ext[count($ext)-1];
	$ext=strtolower($ext);*/
$tmp=pathinfo($url);
//printr($tmp);	
$ext=$tmp[extension];
	$ext=strtolower($ext);

$extc=tmq("select * from dbfulltext_subext where ext='$ext'");
	if (tmq_num_rows($extc)==0) {
		 $exturl=urldecode($url);
	} else {
		$extc=tmq_fetch_array($extc);
	  $extc=tmq("select * from dbfulltext_cate where code='$extc[parent]'");
		if (tmq_num_rows($extc)==0) {
  		 $exturl=urldecode($url);
  	} else {
			$extc=tmq_fetch_array($extc);
			$exturl="dublin.linkout.dspcon.php?mode=$extc[code]&url=".urlencode($url);;
		}
	}
	//printr($ext);	
	
	
	?> 
 <frameset rows="100,*">
	<frame src="dublin.linkout.menu.php?url=<?php  echo ($url);?>" scrolling=no>
	<frame src="<?php  echo ($exturl);?>" name=fulltextmedia SCROLLING=yes>
	</frameset>
</HTML>
