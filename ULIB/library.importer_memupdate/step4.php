<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="importer_memupdate";
        mn_lib();
if ($resetmemory=="yes") {
	tmq("delete from barcode_val where classid like 'importupdatememory-member-%' ");
	tmq("delete from barcode_valmem where classid like 'importupdatememory-member-%' ");
}

if ($fromxlsmelt=="yes") {
}
			pagesection(getlang("อัพเดทข้อมูลสมาชิก::l::Update Member Records"));
//echo $fpath;
function local_form($wh) {
	for ($i=1;$i<=5;$i++) {
		local_form_sub($wh.$i);
	}
}
function local_form_sub($wh) {
	?><SELECT NAME="<?php  echo $wh;?>">
	<?php 
	$tmp=barcodeval_get("importupdatememory-member-$wh");
	if ($tmp!="") {
		echo "<option value='$tmp'>$tmp";
	}

	echo "<option value='EMPTY'>EMPTY";
	echo "<option value='SPACE'>SPACE";
	for ($i=1;$i<=30;$i++) {
		echo "<option value='data$i'>data$i";
	}
	?>
	</SELECT><?php 
}
function local_form2($wh,$fid) {
	?><SELECT NAME="<?php  echo $wh;?>">
	<?php 
	$tmp=barcodeval_get("importupdatememory-member-$fid");
	if ($tmp!="") {
		echo "<option value='$tmp'>$tmp";
	}

	echo "<option value='EMPTY'>EMPTY";
	for ($i=1;$i<=30;$i++) {
		echo "<option value='data$i'>data$i";
	}
	?>
	</SELECT><?php }?><BR><CENTER><B><?php  echo getlang("กรุณาโยงฟิลด์ที่นำเข้ามาได้ กับข้อมูลสมาชิก โดยเลือกจากชื่อฟิลด์::l::Please specific relation between imported field name and member fields"); ?></B></CENTER>
<BR>
<TABLE width=770 align=center border=0 cellpadding=1 cellspacing=1  bgcolor=000000>
<?php 
$s=tmq("select * from importer_memupdate_tmp limit 0,8");
echo "<TR bgcolor=f2f2f2>";
for ($i=1;$i<=30;$i++) {
	echo "<TD align=center><B>data$i</B></TD>";
}
echo "</TR>";

while ($r=tmq_fetch_array($s)) {
	echo "<TR bgcolor=f2f2f2>";
	for ($i=1;$i<=30;$i++) {
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
<TABLE align=center width=650>
<FORM METHOD=POST ACTION="step5.php" onsubmit= "return confirm('Please Confirm your action');">
<TR valign=top>
	<TD>Barcode</TD>
	<TD><?php  local_form("barcode");?>**</TD>
</TR>
<TR valign=top>
	<TD><?php  echo getlang("ชื่อ-สกุล::l::Name - Last name"); ?></TD>
	<TD><?php  local_form("name");?></TD>
</TR>
<TR valign=top>
	<TD><?php  echo getlang("คำนำหน้า::l::Prefix"); ?></TD>
	<TD><?php  local_form("prefix");?></TD>
</TR>
<TR valign=top>
	<TD><?php  echo getlang("ที่อยู่::l::Address"); ?></TD>
	<TD><?php  local_form("address");?></TD>
</TR>
<TR valign=top>
	<TD><?php  echo getlang("รหัสผ่าน::l::Password"); ?></TD>
	<TD><?php  local_form("password");?></TD>
</TR>
<TR valign=top>
	<TD><?php  echo getlang("อีเมล์::l::Email"); ?></TD>
	<TD><?php  local_form("email");?></TD>
</TR>
<TR valign=top>
	<TD><?php  echo getlang("เบอร์โทรศัพท์::l::Tel."); ?></TD>
	<TD><?php  local_form("tel");?></TD>
</TR>
<?php 
$s=tmq("select * from member_customfield where lower(isshow)='yes' or fid='FP' order by fid ");
while ($r=tfa($s)) {
	?><TR valign=top>
	<TD><?php  echo getlang($r[name]); ?>*</TD>
	<TD><?php  local_form2("cust[".$r[fid]."]",$r[fid]);?></TD>
</TR><?php 
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