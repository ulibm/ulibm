<?php 
include("../inc/config.inc.php");
include("trap.admin.php");
html_start();
  pagesection("แสดงเนื้อหาที่แนบมา::l::Show Attatched Contents","fulltext");
?><center><?php 
res_brief_dsp($MID);
if ($bcode!="") {
echo marc_getmidcalln($bcode);
}
?></center><table align=center cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH;?>">
<?php 
	$s=tmq("select * from globalupload where keyid='$keyid' ");
	if (tnr($s)==0) {
		echo getlang("ไม่มีไฟล์แนบมาด้วย::l::No attatched file");
	} else {
		while ($r=tfa($s)) {
			?><tr valign=top>
				<td width=24><?php  echo html_geticon($r[hidename]," width=56 height=56 "); ?></td>
				<td><a href="<?php  echo $dcrURL?>_linkout.php?url=<?php  echo urlencode($dcrURL."_globalupload/$keyid/$r[hidename]");?>" target=_blank><?php  echo stripslashes($r[filename_auto]); ?> <?php  echo stripslashes($r[filename]); ?></a><br>
				<font class=smaller><?php  echo ymd_datestr($r[dt]); ?></font> <font class=smaller2>(<?php  echo ymd_ago($r[dt]); ?>)</font></td>
			</tr><?php 
		}
	}
?>
</table>