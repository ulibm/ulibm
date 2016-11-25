<?php 
include("./inc/config.inc.php");// พ 
?><TABLE width=100% height=100%>
<TR>
	<TD align=center valign=middle><img src="<?php  echo $dcrURL?>inc/phpqrcode/index.php?data=<?php  echo urldecode($url)."&level=M&size=10&"?>" width=400><BR><?php  echo urldecode($url)?></TD>
</TR>
</TABLE>

