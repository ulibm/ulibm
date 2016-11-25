<?php 
include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();
	 
  barcodeval_set("TMP-ftcontent-$useradminid-mid",$mid);
  barcodeval_set("TMP-ftcontent-$useradminid-FTCODE",$FTCODE);
	?>
	<CENTER><br />

<table border="0" cellpadding="0" cellspacing="0" width=780 align=center>
<FORM METHOD=POST ACTION="">
	<tr><td class=table_head width=200><?php  echo getlang("เพิ่มเนื้อหาให้::l::Adding content to");?></td>
<td><?php  echo marc_gettitle(barcodeval_get("TMP-ftcontent-$useradminid-mid"));?></td></tr>
<tr><td class=table_head>Call number</td>
<td><?php  echo marc_getcalln(barcodeval_get("TMP-ftcontent-$useradminid-mid"));?></td></tr>
<tr><td class=table_head><?php echo getlang("ประเภทเนื้อหา::l::Content type");?></td>
<td><SELECT NAME="jumpftcate"  onchange="self.location='mediabasic.php?FTCODE='+this.value+'&mid=<?php  echo $mid?>'">
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
:: <A HREF="mediacontent.upload.php?FTCODE=<?php  echo $FTCODE;?>&mid=<?php  echo $mid;?>" class=a_btn><?php  echo getlang("Normal Upload form"); ?></A>
</td></tr>
</FORM></table>
</CENTER>
<TABLE width=780 align=center>
<?php 
for ($i=0;$i<=5;$i++) {
?>
	<TR>
		<TD><iframe width=750 height=60 src="mediabasic.upload.php?FTCODE=<?php  echo $FTCODE;?>&mid=<?php  echo $mid;?>"></iframe></TD>
	</TR>
<?php 
}	
?>
	</TABLE>
	
	<table width=780 align=center>
<tr><td><?php html_label('i',$mid);?></td></tr>
</table>
<CENTER>
<BR>

<A HREF="mediacontent.php?FTCODE=<?php  echo $FTCODE;?>&mid=<?php  echo $mid;?>" class=a_btn><B><?php  echo getlang("กลับ::l::Back"); ?></B></A></CENTER>

<?php 
foot();
?>