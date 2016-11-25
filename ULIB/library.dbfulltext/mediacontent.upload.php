<?php 
include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();
	 
  barcodeval_set("TMP-ftcontent-$useradminid-mid",$mid);
  barcodeval_set("TMP-ftcontent-$useradminid-FTCODE",$FTCODE);
	
?><CENTER><br />

<FORM METHOD=POST ACTION="">
<table border="0" cellpadding="0" cellspacing="0" width=780 align=center>
	<tr><td class=table_head width=200><?php  echo getlang("เพิ่มเนื้อหาให้::l::Adding content to");?></td>
<td><?php  echo marc_gettitle(barcodeval_get("TMP-ftcontent-$useradminid-mid"));?></td></tr>
<tr><td class=table_head>Call number</td>
<td><?php  echo marc_getcalln(barcodeval_get("TMP-ftcontent-$useradminid-mid"));?></td></tr>
<tr><td class=table_head><?php echo getlang("ประเภทเนื้อหา::l::Content type");?></td>
<td><SELECT NAME="jumpftcate"  onchange="self.location='mediacontent.upload.php?FTCODE='+this.value+'&mid=<?php  echo $mid?>'">
	<?php 
	$s=tmq("select * from media_fttype where code='$FTCODE' ");
	$s=tmq_fetch_array($s);
	echo "<OPTION VALUE='$s[code]' SELECTED>".getlang($s[name])."</OPTION>";
		$sall1=tmq("select * from media_fttype where code<>'$FTCODE' order by name ");
	while ($sall1r=tmq_fetch_array($sall1)) {
		echo "<OPTION VALUE='$sall1r[code]' >".getlang($sall1r[name]);
	}

	?>		
	</SELECT></td></tr>
<tr>
<td colspan=2 align=center><A HREF="mediacontent.php?FTCODE=<?php  echo $FTCODE;?>&mid=<?php  echo $mid;?>" class=a_btn><B><?php  echo getlang("กลับ::l::Back"); ?></B></A>
:: <A HREF="mediabasic.php?FTCODE=<?php  echo $FTCODE;?>&mid=<?php  echo $mid;?>" class=a_btn><?php  echo getlang("Basic Upload form"); ?></A>
</td></tr>

</table>
</FORM>
</CENTER>
<table width=780 align=center>
<tr><td><?php html_label('b',$mid);?></td></tr>
</table>
<?php 
uploadengine("_fulltext/$FTCODE/$mid/","allfile","randid","mediacontent");

?>
<CENTER>
<BR>

<A HREF="mediacontent.php?FTCODE=<?php  echo $FTCODE;?>&mid=<?php  echo $mid;?>" class=a_btn><B><?php  echo getlang("กลับ::l::Back"); ?></B></A></CENTER>
					  <?php 
foot();
?>