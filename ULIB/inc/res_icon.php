<?php // พ
function res_icon($mid,$addition_html="",$text="") {
	global $dcrURL;
	global $dcrs;
	$res="";
	$title=marc_gettitle($mid);
	$fulltitle=$title;
	if (strlen($title)>50) {
		$title=substr($title,0,49).'..';
	}
	$res="<TABLE $addition_html cellpadding=0 cellspacing=0 border=0 width=140 >
	<TR>
		<TD align=center><A HREF='$dcrURL"."dublin.php?ID=$mid' class=smaller>$title</A></TD>
	</TR>
	<TR>
		<TD align=center >".res_cov_dsp($mid,"no",100,"no"," style='float:none!important' ")."$text</TD>
	</TR>
	</TABLE>";
	return $res;
}
?>