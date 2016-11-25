<?php 
	include ("../inc/config.inc.php");// พ
$s=tmq("select * from ms_annouce2 where isshow='YES' and loc='".sessionval_get("msrunningsub")."' order by ordr");
?><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style><marquee scrolldelay=10 scrollamount=8><TABLE border=0 cellpadding=5 cellspacing=0 height=100%  >
	<TR><?php 
while ($r=tmq_fetch_array($s)) {
	?>
	 	<TD bgcolor="<?php  echo $r[bgcol]?>"><nobr><span style="color: #<?php  echo $r[col]?>; font-size: 75px; font-weight: bold; font-face: Tahoma;">&nbsp;&nbsp;<?php  echo $r[text]?>&nbsp;&nbsp;</span></nobr></TD>
<?php 
}
?>	</TR>
	</TABLE></marquee>