<?php  
;
      include("inc/config.inc.php");
	  html_start("no");// พ 
?><?php  
$url=urldecode($url);
$url=urldecode($url);
$url=urldecode($url);
$url=urlencode($url);

?> 
 <frameset rows="90,*">
	<frame src="_linkout.menu.php?url=<?php echo ($url);?>" scrolling=no>
	<frame src="<?php echo urldecode($url);?>" name=fulltextmedia SCROLLING=yes>
	</frameset>
</HTML>
