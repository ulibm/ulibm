<?php  //พ
include("../inc/config.inc.php");
html_start();
?><TABLE cellpadding=0 cellspacing=0>
<TR valign=top>
	<TD><iframe src="calendar.calendar.php" width=200 height=240 FRAMEBORDER="no" BORDER=0
 id="iframe_calendar" SCROLLING=NO style="border-color: #AAAAAA;border-style: solid;border-width: 1"></iframe></TD>
	<TD>&nbsp;</TD>
	<TD><iframe src="calendar.dsp.php?yea=<?php echo date('Y')?>&mon=<?php echo date('m')?>&dat=<?php echo date('d')?>" width=430 height=240 FRAMEBORDER="no" BORDER=0 name=caldsp
 id="caldsp" SCROLLING=YES style="border-color: #AAAAAA;border-style: solid;border-width: 1"></iframe></TD>
</TR>
</TABLE>