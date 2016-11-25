<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("configinfo");


		?><BR><?php 
			pagesection(getlang("chmod/chown helper"));

?><TABLE align=center width=400>
<TR>
	<TD>
   apache user = 
   <a href="chmodchown.php?u=apache:apache">apache:apache</a> - 
   <a href="chmodchown.php?u=www-data:www-data">www-data:www-data</a> 
   <BR><BR><BR><HR noshade>
<pre><?php  
$s="chown www-data:www-data -R $dcrs
find $dcrs -type d -exec chmod 755 {} \;
find $dcrs -type f -exec chmod 644 {} \;";
if ($u!="") {
   $s=str_replace("www-data:www-data",$u,$s);
}
echo $s;
	?></pre>
   <HR noshade>
   
   <BR><BR><BR>
   Disclaimer: Please consult IT experts before made change file and folder permission!
</TD>
</TR>
</TABLE><BR><?php 
foot();
?>