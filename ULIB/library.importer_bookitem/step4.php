<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_bookitem";
	$tmp=mn_lib();
	pagesection($tmp);
//echo $fpath;
function local_form($wh) {
	local_form_sub($wh.$i);
}
function local_form_sub($wh) {
	?><SELECT NAME="<?php  echo $wh;?>">
	<?php 
	echo "<option value='EMPTY'>EMPTY";

	for ($i=1;$i<=50;$i++) {
		echo "<option value='data$i'>data$i";
	}
	?>
	</SELECT><?php 
}
?><BR><CENTER><B><?php  echo getlang("กรุณาโยงฟิลด์ที่นำเข้ามาได้ กับข้อมูลไอเทม โดยเลือกจากชื่อฟิลด์::l::Please specific relation between imported field name and Items fields"); ?></B></CENTER>
<BR>
<TABLE width=770 align=center border=0 cellpadding=1 cellspacing=1  bgcolor=000000>
<?php 
$s=tmq("select * from importer_bkitems_tmp limit 0,8");
echo "<TR bgcolor=f2f2f2>";
for ($i=1;$i<=50;$i++) {
	echo "<TD align=center><B>data$i</B></TD>";
}
echo "</TR>";

while ($r=tmq_fetch_array($s)) {
	echo "<TR bgcolor=f2f2f2>";
	for ($i=1;$i<=50;$i++) {
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
<TABLE align=center width=550>
<FORM METHOD=POST ACTION="step5.php" onsubmit= "return confirm('Please Confirm your action');">

<TR valign=top>
	<TD><?php  echo getlang("ID ของวัสดุ::l::Material's ID"); ?></TD>
	<TD><?php  local_form("matid");?></TD>
</TR>
<TR valign=top>
	<TD><?php  echo getlang("บาร์โค้ดไอเทม::l::Items's Barcode"); ?></TD>
	<TD><?php  local_form("barcode");?></TD>
</TR>
<TR valign=top>
	<TD><?php  echo getlang("ราคา::l::Items's Price"); ?></TD>
	<TD><?php  local_form("iprice");?></TD>
</TR>
<TR>
	<TD colspan=2 align=center><BR><INPUT TYPE="submit" value="  Next  "></TD>
</TR>
</FORM>
</TABLE>
<BR><BR>
<?php  foot();
?>