<?php 
function member_showfine($useradminid2) {
	global $dcr;
	global $member_showfine_ishasfine;
	global $isatcirculation;
	global $_TBWIDTH;
	?><BR><?php 
	pagesection("รายการค่าปรับ::l::Fine","narrow");
?>
	<TABLE cellpadding = 1 cellspacing = 0 width="<?php  echo $_TBWIDTH;?>" align=center border = 1 class=table_border>
		<TR bgcolor = f2f2f2>
			<TD width = 10% align = center class=table_head><?php  echo getlang("ลำดับที่::l::No."); ?></TD>
			<TD align = center class=table_head><?php  echo getlang("ค่าปรับ::l::Fine"); ?></TD>
			<TD align = center class=table_head><?php  echo getlang("จำนวน::l::Fine"); ?></TD>
		</TR>
	<?php 
		$sql33="SELECT *  FROM fine where memberId='$useradminid2' and isdone='no'";
		$result33=tmq($sql33);
		$NRow33=tmq_num_rows($result33);
		//echo "$NRow33";
		$ix=0;
		$allfine=0;
		while ($row33=tmq_fetch_array($result33))
			{
			$topic = $row33[topic];
			$lib=$row33[lib];
			$fine=$row33[fine];
			$allfine+=$row33[fine];
			$ix++;
	?>
			<TR>
				<TD class=table_td><?php 
						echo $ix;
					?>
					.</TD>
				<TD class=table_td><?php 
				echo $topic;
			?></B></TD>
				<TD class=table_td><?php 
						echo number_format($fine);
					?></TD>
			</TR>
	<?php 
			}
		//echo "[[[ $allfine --]]]]";
		if ($allfine != 0 || $NRow33!=0)
			{
			$member_showfine_ishasfine="yes";
			echo "<tr><td align=right colspan=3  class=table_td><B style='color:red'>".getlang("รวม::l::Total")." " . number_format($allfine) . "  ".getlang("บาท::l::Baht")."</td></tr>";
				if (loginchk_lib("check")==true) {
					echo "<tr><td align=right colspan=3  class=table_td>".
					getlang("มีค่าปรับ หากต้องการชำระค่าปรับ::l::Some fine not processed to process");
					if ($isatcirculation=="yes") {
						echo " <a href='working.fine.php?memberbarcode=$useradminid2&alertfine=no'  class=a_btn>".getlang("คลิกที่นี่::l::click here")."</a>";
					} else {
						echo " <a href='/$dcr/circulation/index.php?loadfine=$useradminid2' target=_top class=a_btn>".getlang("คลิกที่นี่::l::click here")."</a>";
					}
					echo "</td></tr>";

				}
			} else {
				echo "<tr><td align=center colspan=3  class=table_td>".
				getlang("ไม่มีรายการค่าปรับ::l::No fine.")."</td></tr>";
			}
			$crule=tmq("select * from member where UserAdminID='$useradminid2' ",false);
			$crule=tmq_fetch_array($crule);
			$crule=tmq("select * from member_type where type='$crule[type]' ",false);
			$crule=tmq_fetch_array($crule);
			echo "<tr><td align=center colspan=3  class=table_td>";
			$crule[maxfine]=floor($crule[maxfine]);
			if ($crule[maxfine]==0) {
				echo getlang("สมาชิกประเภท ::l::Member type ").getlang($crule[descr]);
				echo getlang(" ไม่สามารถยืมวัสดุสารสนเทศได้ หากค้างค่าปรับ::l:: Cannot checkout items with fine.");
			} else {
				echo getlang("สมาชิกประเภท ::l::Member type ").getlang($crule[descr]);
				echo getlang(" ค้างค่าปรับได้สูงสุด  ".number_format($crule[maxfine])." ฿::l:: can checkout item when have fine lower ".number_format($crule[maxfine])." ฿.");
			}
			echo "</td></tr>";
	?>
	</TABLE>
<?php 
}
?>