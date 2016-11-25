<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();

?><BR><BR><TABLE width=750 align=center>
<FORM METHOD=POST ACTION="searching.php" name="yazform">
<TR>
	<TD align=center><B><?php  echo getlang("กรุณาเลือกเซิร์ฟเวอร์::l::Please choose server"); ?></B></TD>
</TR>

<TR>
	<TD>
	<TABLE width=750 align=center border=0>

		
<TR valign=top>	<?php 
$s=tmq("select * from yaz_sv  where isshow='YES' order by ordr,name");
$i=0;
while ($r=tmq_fetch_array($s)) {
	$i++;
	echo "<TD><input type='checkbox'  name='z39host[]' value='$r[id]' style=\"border-width: 0px;\" >"; 
	
	echo "<input type='hidden' name='z39hostconnect[$r[id]]' value='$r[server]:$r[port]";
	if ($r[db]!="") {
		echo "/$r[db]";
	}
	echo "' /> $r[name]  ";
	echo "<input type='hidden' name='z39hostname[$r[id]]' value='<B>$r[name]</B>' ></TD>";
	if (($i % 2) ==0) {
		echo "	</TR><TR valign=top>";
	}
}
?>	</TABLE>
</TD>
</TR>
<SCRIPT LANGUAGE="JavaScript">
<!--
function local_none(wh) {
	
	for (i=0; i<wh.length; i++) {
		wh[i].checked=false;
		//alert(x.checked);
	}
}
function local_all(wh) {
	for (i=0; i<wh.length; i++) {
		wh[i].checked=true;
		//alert(x.checked);
	}
}
//-->
</SCRIPT>
<TR>
	<TD align=center><INPUT TYPE="button" value="<?php  echo getlang("เลือกทั้งหมด::l::Select all"); ?>" 
	onclick="local_all(document.forms['yazform']['z39host[]'])">
	 <INPUT TYPE="button" value="<?php  echo getlang("ไม่เลือกเลย::l::Select none"); ?>" onclick="local_none(document.forms['yazform']['z39host[]'])"><BR><BR></TD>
</TR>
<TR>
	<TD align=center><B><?php  echo getlang("กรุณาป้อนคำค้น::l::Enter keyword"); ?></B></TD>
</TR>
<TR>
	<TD align=center>		<select name="field">
		<?php 
			$fieldmap["Title"] = "@attr 1=4";
			$fieldmap["Any"] = "@attr 1=1016";
			$fieldmap["Author"] = "@attr 1=1003";
			$fieldmap["ISBN"] = "@attr 1=7";
			$fieldmap["ISSN"] = "@attr 1=8";
			$fieldmap["Abstract"] = "@attr 1=62";

			while (list($key,$value) = each($fieldmap)) {
				echo '<option value="';
				echo $value;
				echo '">';
				echo $key;
				echo '</option>';
			}
		?>
		</select>

&nbsp;
<input type="text" size="30" name="query" /></TD>
</TR>
<TR>
	<TD align=center>    <input type="submit" name="action" value="Search" /></TD>
</TR>

</FORM>
</TABLE><BR><BR><BR>

<CENTER>
<?php  echo getlang(" ขณะนี้ในฐานข้อมูล มีรายการที่ถูกบันทึกไว้แล้วจำนวน ::l::Currently "); ?><?php  echo number_format(tmq_num_rows(tmq("select id from yaz_saved")));?> <?php  echo getlang("รายการ::l:: records in database"); ?> <A HREF="yazlist.php" target=_parent class=a_btn><?php  echo getlang("คลิกที่นี่เพื่อจัดการ::l::Click here to manage"); ?></A>
 </CENTER><BR><BR>
<?php 
foot();
?> 