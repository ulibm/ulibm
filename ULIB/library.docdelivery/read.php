<?php 
include("../inc/config.inc.php");
include("trap.admin.php");
html_start();
function local_read($wh,$mode="",$rr) {
	$doctypedb=tmq_dump2("docdelivery_doctype","id","name");
	if (trim($wh[title])=="") {
		$wh[title]="<i>ไม่กำหนดชื่อเรื่อง</i>";
	}
	global $bydocid;
	global $byreadruleid;
	global $dcrURL;
	global $useradminid;
	global $_TBWIDTH;
	?><table width="<?php  echo $_TBWIDTH;?>" align=center>
	<?php 
	if ($mode=="readrulemode") {
		?>	<tr>
		<td class=table_td colspan=2 align=center><?php  
		if ($rr[starred]	=="yes") {
			?>(ติดดาว) <a href="read.php?byreadruleid=<?php  echo $byreadruleid;?>&unstar=yes" class=a_btn><img src="../neoimg/bibrating/s100.png" width="18" height="18" border="0" alt=""><?php  echo getlang("เอาดาวออก::l::Remove star");?></a><?php 
		} else {
			?><a href="read.php?byreadruleid=<?php  echo $byreadruleid;?>&addstar=yes" class=a_btn><img src="../neoimg/bibrating/s0.png" width="18" height="18" border="0" alt=""><?php  echo getlang("ติดดาว::l::Add star");?></a><?php 
		}
		if ($rr[deleted]=="yes") {
			?>(อยู่ในถังขยะ )<a href="read.php?byreadruleid=<?php  echo $byreadruleid;?>&undelete=yes" class=a_btn><?php  echo getlang("กู้คืนจากถังขยะ::l::Restore");?></a><?php 
		} else {
			?><a href="read.php?byreadruleid=<?php  echo $byreadruleid;?>&delete=yes" class=a_btn><?php  echo getlang("ลบทิ้ง::l::Delete");?></a><?php 
		}
		?></td>
	</tr>
		<td class=table_head >กำหนดแท็ก</td>
		<td class=table_td><form method="post" action="<?php  echo $PHP_SELF?>">
			<input type="text" name="tags" value="<?php 
			echo stripslashes($rr[tags]);;
		?>" style="width: 400"><input type="submit" value="บันทึก">
		<input type="hidden" name="byreadruleid" value="<?php  echo $byreadruleid;?>">
		<input type="hidden" name="savetags" value="yes">
		</form><br>
		<font class=smaller2>(คั่นด้วยเครื่องหมายคอมม่า)</font>
		</td>
	<?php 
	}	
	?>
	<tr>
		<td class=table_head >ประเภทเอกสาร</td>
		<td class=table_td><?php  echo stripslashes($doctypedb[$wh[type1]]); ?></td>
	</tr>
	<tr>
		<td class=table_head width=200>เรื่อง</td>
		<td class=table_td style="font-weight:bold "><?php  echo stripslashes($wh[title]); ?></td>
	</tr>
	<?php  if (trim($wh[no])!="") {?>
	<tr>
		<td class=table_head >เลขที่หนังสือ</td>
		<td class=table_td><?php  echo stripslashes($wh[no]); ?></td>
	</tr>
	<?php }?>
	<tr>
		<td class=table_head >ลงวันที่</td>
		<td class=table_td><?php  echo ymd_datestr($wh[date],"date"); ?></td>
	</tr>
	<?php  if (trim($wh[from1])!="") {?>
		<tr>
			<td class=table_head >จาก</td>
			<td class=table_td><?php  echo stripslashes($wh[from1]); ?></td>
		</tr>
	<?php }?>
	<?php  if (trim($wh[to1])!="") {?>
		<tr>
			<td class=table_head >ถึง</td>
			<td class=table_td><?php  echo stripslashes($wh[to1]); ?></td>
		</tr>
	<?php }?>
	<tr>
		<td class=table_head >ชั้นความเร็ว</td>
		<td class=table_td><?php  echo stripslashes($wh[speed]); ?></td>
	</tr>
	<tr>
		<td class=table_head >ชั้นความลับ</td>
		<td class=table_td><?php  echo stripslashes($wh[secret1]); ?></td>
	</tr>
	<tr>
		<td class=table_head >วันที่สร้างเอกสาร</td>
		<td class=table_td><?php  echo ymd_datestr($wh[dt]); ?> <font class=smaller2>(<?php  echo ymd_ago($wh[dt]); ?>)</font></td>
	</tr>
	<?php  if (trim($wh[detail])!="") {?>
		<tr>
			<td class=table_head >รายละเอียด</td>
			<td class=table_td><?php  echo stripslashes($wh[detail]); ?></td>
		</tr>
	<?php }?>
	<?php  if (trim($wh[action])!="") {?>
		<tr>
			<td class=table_head >การปฏิบัติ</td>
			<td class=table_td><?php  echo stripslashes($wh[action]); ?></td>
		</tr>
	<?php }?>
	<?php  if (trim($wh[note])!="") {?>
		<tr>
			<td class=table_head >หมายเหตุ</td>
			<td class=table_td><?php  echo stripslashes($wh[note]); ?></td>
		</tr>
	<?php }?>
		<tr>
			<td class=table_head >ผู้สร้างเอกสาร</td>
			<td class=table_td><?php  echo html_library_name($wh[loginid]); ?></td>
		</tr>
		<tr>
			<td class=table_head >ไฟล์</td>
			<td class=table_td><table cellpadding=0 cellspacing=0 border=0 width=100%>
			
			<?php  
	$s=tmq("select * from globalupload where keyid='docdelivery_docs-$wh[id]' ");
	if (tnr($s)==0) {
		echo getlang("ไม่มีไฟล์แนบมาด้วย::l::No attatched file");
	} else {
		while ($r=tfa($s)) {
			?><tr valign=top>
				<td width=24><?php  echo html_geticon($r[hidename]," width=47 height=47 "); ?></td>
				<td><a href="<?php  echo $dcrURL?>_globalupload/<?php  echo "docdelivery_docs-$wh[id]/$r[hidename]"?>" target=_blank><?php  echo stripslashes($r[filename]); ?></a><br>
				<font class=smaller><?php  echo ymd_datestr($r[dt]); ?></font> <font class=smaller2>(<?php  echo ymd_ago($r[dt]); ?>)</font></td>
			</tr><?php 
		}
	}

	?></table></td>
		</tr>
		<tr>
			<td class=table_head >ผู้รับเอกสาร</td>
			<td class=table_td><table cellpadding=0 cellspacing=0 border=0 width=100%>
			
			<?php  
				$s="select * from docdelivery_readrule where pid='$wh[id]' ";
			if ($mode=="readrulemode") {
				$s.=" and loginid='$useradminid' ";
			}
	$s=tmq($s,false);
	if (tnr($s)==0) {
		echo getlang("ไม่มีผู้รับเอกสาร::l::No Reader allowed");
	} else {
		while ($r=tfa($s)) {
			?><tr valign=top>
				<td width=24><img src="<?php  echo get_library_pic($r[loginid]) ; ?>" width=47 height=47 ></td>
				<td><?php  echo get_library_name($r[loginid]); ?></a> <?php 
				if ($r[readed]=="yes") {
					echo "<b style='color: darkgreen; font-weight: bold;'>อ่านแล้ว</b>";
				} else {
					echo "<b style='color: darkred; font-weight: bold;'>ยังไม่อ่าน</b>";
				}
			?><br>
				<font class=smaller><?php  echo ymd_datestr($r[dt]); ?></font> <font class=smaller2>(<?php  echo ymd_ago($r[dt]); ?>)</font></td>
			</tr><?php 
		}
	}

	?></table></td>
		</tr>
	</table><?php 
}


$bydocid=floor($bydocid);
$byreadruleid=floor($byreadruleid);


if ($bydocid!=0) {
	$s=tmq("select * from docdelivery_docs where id='$bydocid' ");
	if (tnr($s)==0) {
		html_dialog("Error","Document id [$bydocid] not found");
		die;
	}
	$s=tfa($s);
	local_read($s,"docsmode");
//	printr($s);
}
if ($byreadruleid!=0) {
	$s_rr_sql="select * from docdelivery_readrule where id='$byreadruleid' ";
	$s_rr=tmq($s_rr_sql);
	if (tnr($s_rr)==0) {
		html_dialog("Error","Readrule id [$byreadruleid] not found");
		die;
	}
	$s_rr=tfa($s_rr);
	$s_sql="select * from docdelivery_docs where id='$s_rr[pid]' ";
	$s=tmq($s_sql);
	if (tnr($s)==0) {
		html_dialog("Error","Document id [$s_rr[pid]] not found");
		die;
	}
	tmq("update docdelivery_readrule set readed='yes' where id='$byreadruleid' and loginid='$useradminid' ");
	if ($addstar=="yes") {
		tmq("update docdelivery_readrule set starred='yes' where id='$byreadruleid' and loginid='$useradminid' ");
	}
	if ($savetags=="yes") {
		$tags=addslashes($tags);
		tmq("update docdelivery_readrule set tags='$tags' where id='$byreadruleid' and loginid='$useradminid' ");
	}
	if ($unstar=="yes") {
		tmq("update docdelivery_readrule set starred='no' where id='$byreadruleid' and loginid='$useradminid' ");
	}
	if ($delete=="yes") {
		tmq("update docdelivery_readrule set deleted='yes' where id='$byreadruleid' and loginid='$useradminid' ");
		?>
		<script type="text/javascript">
		<!--
			self.close();
		//-->
		</script>
		<?php 
			die;
	}
	if ($undelete=="yes") {
		tmq("update docdelivery_readrule set deleted='no' where id='$byreadruleid' and loginid='$useradminid' ");
	}

	$s=tmq($s_sql);
	$s=tfa($s);
	$s_rr=tmq($s_rr_sql);
	$s_rr=tfa($s_rr);

	local_read($s,"readrulemode",$s_rr);
}

?>