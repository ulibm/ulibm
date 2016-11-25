<?php  //พ
function bitem_get_chaininfo($ID,$mid) {
	global $dcrURL;
		$chain=tmq("select distinct chain from chainerlink where fromid='$ID' and frommid='$mid' ",false);
	//echo tmq_num_rows($chain);
	if (tmq_num_rows($chain)!=0) {
		$chainnamedb=tmq_dump("chainer","code","fromtxt");
		?>
		<TR>
			<TD colspan=2 align=right valign=top class=table_td><img src="<?php  echo $dcrURL?>neoimg/morearrow.png" border=0 ></TD>
			<TD colspan=3 class=table_td><?php 
		while ($chainr=tmq_fetch_array($chain)) {
			$chaini=tmq("select * from chainerlink where fromid='$ID' and frommid='$mid' and chain='$chainr[chain]' ",false);
			echo "<B style='font-size:13; color:666666;'>".getlang($chainnamedb[$chainr[chain]])."</B><BR>";
			while ($chainir=tmq_fetch_array($chaini)) {
				echo "&nbsp;&nbsp;&bull;&nbsp;<A HREF='$dcrURL/dublin.php?ID=$chainir[destid]' target=_blank><FONT style='font-size:13; color:#13437D;'>".marc_gettitle($chainir[destid])." / ".marc_getauth($chainir[destid])."</FONT></A><BR>";
			}
		}			
		?></TD>
		</TR>
		<?php 
	}
}
?>