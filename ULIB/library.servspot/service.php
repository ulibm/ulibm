<?php 
include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

?><BR><?php 
pagesection("บริการให้ใช้จุดให้บริการ::l::Service Spot Management");
$s="select * from servicespot_room where 1 ";
if ($showonly!="") {
	$s.=" and id='$showonly' ";
	?><CENTER><A HREF="service-one.php"><?php  echo getlang("เลือกแสดงห้องอื่น::l::Service for other spot");?></A><BR></CENTER><?php 
}
	$s.=" order by name";

$s=tmq($s);
while ($r=tmq_fetch_array($s)) {

	?><TABLE width=780 align=center bgcolor=#E2E2E2>
	<TR valign=top>
		<TD width=64><?php  echo "<img src='$dcrURL/neoimg/collectionicon/$r[icon]' width=64 height=64>";?></TD>
		<TD style="padding-left: 10px;"><B style="font-size: 32px;"><?php  echo getlang($r[name])?></B><BR>
		&nbsp;&nbsp;<?php  echo getlang($r[descr])?></TD>
	</TR>
	</TABLE>

	<TABLE width=780 align=center>
	<TR>
		<TD style="padding-left: 50px;">
<TABLE width=730 align=center bgcolor=#FFFFFF border=0>
	<?php 
	$s2=tmq("select * from servicespot_client where pid='$r[id]' order by name ");	
	$i=0;
	while ($r2=tmq_fetch_array($s2)) {
		if (($i % 4) == 0) {
			echo "<TR valign=top><TD >";
		}
		$i++;
		//echo "[$i".($i % 4 )."]";
		$rand=randid();
		$url="runner.swf?clientid=$r2[id]&allowmin=$r[minutesallow]&rand=$rand";
		?><TABLE border=1 align=left>
		<TR>
			<TD class=table_head><?php  echo getlang($r2[name]);?></TD>
			</TR>
			<TR>
				<TD><object noclassid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="150" height="100" id="runner" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="<?php  echo $url;?>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="<?php  echo $url;?>" quality="high" bgcolor="#ffffff" width="150" height="100" name="runner" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object></TD>
		</TR>
		</TABLE><?php 
		if (($i % 4) == 0) {
			echo "</TD></TR>";
		}
	}
	?>
	</TABLE>
	</TD>
	</TR>
	</TABLE>
	<?php 
}
foot();
?>