<?php 
function viewtopicrow($r,$mode="normal") {
	global $_tmid;
	global $kw;
	global $ismanager;
	global $_topicstatus;
	global $row_per_page;
if ($r[ishide]=="yes" && $ismanager !=true  ) {
	return;
}
?>
<TR bgcolor=white valign=top>
	<TD >
	<?php 
echo ymd_datestr($r[dt],'shortd');
?><!-- <?php 
if (strpos($r[viewers],",$_tmid,")===false) {
	$img="red-small";
} else {
	$img="green-small";
}

?><IMG SRC="./<?php  echo $img?>.gif" BORDER="0" <?php  echo $_topicstatus[$img];?>> --></TD>

	<TD noclass=table_td>
	<?php 
	if ($mode=="pin") {
		echo "<B>".getlang("ปักหมุด::l::Pinned")."</B>:";
	}
	if ($kw!="") {
		$r[topic]=str_replace($kw,"<U>$kw</U>",$r[topic]);
	}
		echo "<A HREF='viewtopic.php?TID=$r[id]'>";
	?><FONT  COLOR="#556480"><font style='font-size: 16px;font-weight:bold'><?php  echo str_censor($r[topic]);?></font></A><BR><?php 
	if ($r[ishide]=="yes" && $ismanager==true)	 {
		echo "[<A HREF=\"viewtopic.realdelete.php?setdelete=$r[id]\" style=\"color: darkred; font-weight: bold;\">".getlang("ลบทิ้ง::l::Delete")."</A>] ";
		echo "[<A HREF=\"viewtopic.undelete.php?setdelete=$r[id]\" style=\"color: darkgreen; font-weight: bold;\">".getlang("แสดงข้อความนี้::l::Unhide")."</A>] ";
	}
$tmp=tmq("select * from webboard_posts where nestedid='$r[id]' and ishide<>'yes' ");
	$anscount=tnr($tmp);

	if ($anscount>$row_per_page) {
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo pageengine(1,$anscount,"viewtopic.php?TID=$r[id]","","nohtml");
	}
	?></TD>
	<TD align=center noclass=table_td><?php 
	echo "$anscount";
	$tmp=tmq("select * from webboard_posts where nestedid='$r[id]' and ishide='yes' ");
	$anscount2=tnr($tmp);
	if ($anscount2!=0) {
		echo "<nobr>(".getlang("ซ่อน::l::Hidden")." $anscount2)</nobr>";
	}
	?></TD>
	<TD align=center noclass=table_td><?php 
	if ($r[tmid]=="") {
		if ($r[memid]=="") {
			echo "".getlang("โดย ผู้เยี่ยมชม::l::By visitor");;
		} else {
			echo "".get_member_name($r[memid]);;
		}
	} else {
		echo get_library_name($r[tmid]); 
	}
	?></TD>
	<TD align=center noclass=table_td style='font-size: 12px;'><?php 
	if ($mode=="search") {
		$tmp=tmq("select * from webboard_boardcate where id='$r[boardid]' limit 1 ");
		$tmp=tfa($tmp);
		echo "<nobr style='font-size: 12px;'>".getlang($tmp[name]);
	} else {
		$tmp=tmq("select * from webboard_posts where nestedid='$r[id]' and ishide<>'yes' order by lastactive desc limit 1 ");
		if (tnr($tmp)==0) {
			echo "<FONT  COLOR=darkgray style='font-size: 12px;'>".getlang("ยังไม่มีผู้ตอบ::l::No reply")."</FONT>";
		} else {
			$tmp=tfa($tmp);
			if ($tmp[tmid]=="") {
				echo ymd_datestr($tmp[dt],"shortdt");
				if ($tmp[memid]=="") {
					echo "<BR>".getlang("โดย ผู้เยี่ยมชม::l::By visitor");;
				} else {
					echo "<BR>".get_member_name($tmp[memid]);;
				}
			} else {
				echo ymd_datestr($tmp[dt],"shortdt");
				echo "<BR><nobr><FONT COLOR=777777  style='font-size: 12px;'> ".getlang("โดย ::l::By ")." ".get_library_name($tmp[tmid])."</FONT></nobr>";
			}
		}
	}
	?></TD>

	</TD>
</TR>

<?php 
}
?>