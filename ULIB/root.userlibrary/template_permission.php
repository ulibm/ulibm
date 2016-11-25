<?php 
;
include("../inc/config.inc.php");
head();
mn_root("userlibrary");

if ($issave=="permission") {
	tmq("delete from library_permission_template where lib='$ID'  ");
	//print_r($setpperm);
	if (is_array($setpperm)) {
		reset($setpperm);
		while (list($key, $val) = each($setpperm)) {
			$key=stripslashes($key);
			$key=trim($key,"'");
			$key=stripslashes($key);
			$key=trim($key,"'");
			tmq("insert into library_permission_template set lib='$ID' , code='$key'  ");
		}
	}
}

$s=tmq("select * from library_modules_templatename where code='$ID' ");
$s=tmq_fetch_array($s);
?>

<BR>
<TABLE width=780 align=center class=table_border>
<TR>
	<TD width=200><B><?php  echo getlang("ชุดการอนุญาต::l::Permission template"); ?></B></TD>
	<TD><?php  echo $s[name]?></TD>
</TR>
<TR>

	<TD width=100><B><?php  echo getlang("Code::l::Code"); ?></B></TD>
	<TD><?php  echo $s[code]?></TD>
</TR>
</TABLE>

<CENTER><BR><B><?php  echo getlang("การตั้งค่าการอนุญาต::l::Permission setting"); ?></B><BR></CENTER>
<?php 
$s=tmq("select * from library_modules_cate where 1 order by name");
?><TABLE class=table_border width=780 align=center>
<form action="template_permission.php" method=post>
<INPUT TYPE="hidden" NAME="issave" value="permission">
<INPUT TYPE="hidden" NAME="ID" value="<?php  echo $ID?>">
<?php 
while ($r=tmq_fetch_array($s)) {
	$ss=tmq("select * from library_modules where nested='$r[code]' order by ordr,name");
	if (tmq_num_rows($ss)==0) {
		continue;
	}
	?><TR class=table_td>
	<TD colspan=2 style="font-weight: bold;"><IMG SRC="../neoimg/Play.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle> <?php  echo getlang($r[name]);?></TD>

</TR>
<?php 
	while ($rs=tmq_fetch_array($ss)) {
		$tmp=tmq("select * from library_permission_template where lib='$ID' and code='$rs[code]' ");
			?><TR  bgcolor=f2f2f2>
		<TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="../neoimg/Right.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle> <?php  echo getlang($rs[name])?></TD>
		<TD align=center <?php 
		if (tmq_num_rows($tmp)!=0) {
	  echo "bgcolor=green";
	} else {
		  echo "bgcolor=darkred";

	}
		?>>
		<?php 
		$formname="setpperm['$rs[code]']";

	if (tmq_num_rows($tmp)!=0) {
		echo "<INPUT TYPE=checkbox NAME=\"$formname\" value='yes' checked noonclick=\"checkallchild(this,$rs[code])\" style='border:0'>";
		//$disbygroup="yes";
		//echo "<A HREF=\"template_permission.php?act=add&ID=$ID&code=$r[code]\"><IMG SRC=\"../../signon/neoimg/ball_red.gif\" WIDTH=16 HEIGHT=16  BORDER=0 ></A>";
	} else {
		echo "<INPUT TYPE=checkbox NAME=\"$formname\" value='yes' noonclick=\"checkallchild(this,$rs[code])\" style='border:0'>";
		//echo "<A HREF=\"template_permission.php?act=close&ID=$ID&code=$r[code]\"><IMG SRC=\"../../signon/neoimg/ball_green.gif\" WIDTH=16 HEIGHT=16  BORDER=0 ></A>";
		//$disbygroup="no";
	}
		?>
		</TD>
	</TR>
	<?php 

	}
}
?>
<TR class=table_td>
	<TD colspan=2 style="font-weight: bold;" align=center><Input type=submit value=" Submit "> <Input type=reset value=" Reset "></TD>

</TR>
</form>
</TABLE><BR>
<CENTER><A HREF="templatename.php"><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER><?php 
foot();
?>