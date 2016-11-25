<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_book";
	$tmp=mn_lib();
	pagesection($tmp);
//echo $fpath;

if ($resetmemory=="yes") {
	tmq("delete from barcode_val where classid like 'importmemory-book-%' ");
	tmq("delete from barcode_valmem where classid like 'importmemory-book-%' ");
}

function local_form($wh) {
		?><nobr><?php 
	for ($i=1;$i<=10;$i=$i+2) {
		local_form_sub($wh,$i);
	}
		?></nobr><?php 
}
function local_form_sub($wh,$i) {
	?><!-- [<?php  echo $i?>] --><INPUT TYPE="text" NAME="<?php  echo $wh;?>[<?php  echo $i?>]" size=3 maxlength=500 
	value="<?php  echo barcodeval_get("importmemory-book-$wh-$i"); ?>"
	><SELECT NAME="<?php  echo $wh;?>[<?php  echo $i+1?>]">
	<?php 
	$tmp=barcodeval_get("importmemory-book-$wh-".($i+1));
	if ($tmp!="") {
		echo "<option value='$tmp'>$tmp";
	}
	echo "<option value='EMPTY'>EMPTY";
	for ($i=1;$i<=70;$i++) {
		echo "<option value='[data$i]'>data$i";
	}
	?>
	</SELECT><?php 
}
?><BR><CENTER><B><?php  echo getlang("กรุณาโยงฟิลด์ที่นำเข้ามาได้ กับข้อมูลวัสดุฯ โดยเลือกจากชื่อฟิลด์::l::Please specific relation between imported field name and Material fields"); ?></B></CENTER>
<BR>
<TABLE width="<?php  echo $_TBWIDTH;?>" align=center border=0 cellpadding=1 cellspacing=1  bgcolor=000000>
<?php 
$s=tmq("select * from importer_book_tmp limit 0,8");
echo "<TR bgcolor=f2f2f2>";
for ($i=1;$i<=70;$i++) {
	echo "<TD align=center><B>data$i</B></TD>";
}
echo "</TR>";

while ($r=tmq_fetch_array($s)) {
	echo "<TR bgcolor=f2f2f2>";
	for ($i=1;$i<=70;$i++) {
		$k="data$i";
		if ($r[$k]!="") {
			echo "<TD><nobr>$r[$k]</nobr></TD>";
		} else {
			echo "<TD bgcolor=white align=center>-</TD>";
		}
	}

	echo "</TR>";
}
?>
</TABLE>
<BR>
<TABLE align=center width="<?php  echo $_TBWIDTH?>">
<FORM METHOD=POST ACTION="step5.php" onsubmit= "return confirm('Please Confirm your action');">
<?php 
$maps=tmq("select * from importer_book_map where    (tp like '%[data]%' ) order by ordr,fid");
while ($smap=tmq_fetch_array($maps)) {
	?>
<TR valign=top>
	<TD class=table_td><?php  echo getlang($smap[name]); ?> [<?php  echo getlang($smap[classid]); ?>]</TD>
	<TD><nobr><?php  local_form($smap[classid]);?></nobr></TD>
</TR>
	<?php 
}
?>
<TR>
	<TD colspan=2 align=center><BR><INPUT TYPE="submit" value="  Next  "> <a href="step4.php?resetmemory=yes" style="color:darkred" onclick="return confirm('Please Confirm');"><?php  echo getlang("รีเซ็ตค่าที่จำไว้::l::Reset remembered value")?></a></TD>
</TR>
</FORM>
</TABLE>
<BR><BR>
<?php  foot();
?>