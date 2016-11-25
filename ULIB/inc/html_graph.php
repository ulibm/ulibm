<?php // พ
function html_graph($align="H",$max,$me,$narrow=10,$long=100,$col="#001155") {
	global $dcrURL;
	$p=percent_cal($max,$me);
	$boxlong=$long;
	$long=round($boxlong*($p/100));
	//$long=round($long/100)*$boxlong;
	if ($long==0) {
		$long=1;
	}
	if ($align=="H") {
		$line="  height='$long' width='$narrow' style='width:$narrow;height:$long;display: inline; background-color: $col' ";
		$box=" height='$boxlong' width='$narrow' style='width:$narrow;height:$boxlong;inline;xfloat:left' ";
	} else {
		$line=" height='$narrow' width='$long' style='width:$long;height:$narrow;display: inline;background-color: $col;' ";
		$box=" height='$narrow' width='$boxlong' style='width:$boxlong;height:$narrow;;xfloat:left' ";
	}
	$blank="<img src='$dcrURL/neoimg/spacer.gif' border=0 width=2 height=2>";

$h="<TABLE border=0 $box cellpadding=0 cellspacing=1 bgcolor=#959595 align=center>
<TR>
	<TD valign=bottom align=left bgcolor=white ><img src='$dcrURL/neoimg/spacer.gif' border=0 width=2 height=2 $line></TD><TD bgcolor=white style='display:none'>$blank</TD>
</TR>
</TABLE>";
return $h;
}
?>