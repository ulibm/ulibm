<?php 
;
include("../inc/config.inc.php");
head();
mn_root("userlibrary");

if ($issave=="permission") {
	tmq("delete from library_permission where lib='$ID'  ");
	//print_r($setpperm);
	if (is_array($setpperm)) {
		reset($setpperm);
		while (list($key, $val) = each($setpperm)) {
			$key=stripslashes($key);
			$key=trim($key,"'");
			$key=stripslashes($key);
			$key=trim($key,"'");
			tmq("insert into library_permission set lib='$ID' , code='$key'  ");
		}
	}
}

$s=tmq("select * from library where UserAdminID='$ID' ");
$s=tmq_fetch_array($s);
?>

<BR>
<TABLE width=780 align=center class=table_border>
<TR>
	<TD width=100><B><?php  echo getlang("ชื่อเจ้าหน้าที่::l::Librarian"); ?></B></TD>
	<TD><?php  echo $s[UserAdminName]?></TD>
</TR>
<TR>

	<TD width=100><B><?php  echo getlang("รหัสล็อกอิน::l::Loginid"); ?></B></TD>
	<TD><?php  echo $s[UserAdminID]?></TD>
</TR>
</TABLE>
<?php 
$defmenu=$s[defmenu];
?>
<BR>
<TABLE width=780 align=center class=table_border>
<form action="permission.php" method=post>
<INPUT TYPE="hidden" NAME="ID" value="<?php  echo $ID?>">
<TR valign=top>
	<TD width=200><B><?php  echo getlang("รูปแบบการอนุญาต::l::Permission template"); ?></B></TD>
	<TD><select name="permset" ID="permset" onchange="self.location='permission.php?ID=<?php  echo $ID?>&loadpermset='+this.value;">
	<option value=""><?php  echo getlang("กรุณาเลือก::l::Please select");?>
	<?php 
	$s=tmq("select * from library_modules_templatename order by name");
	while ($r=tmq_fetch_array($s) ) {
		$sl="";
		if ($loadpermset==$r[code]) {
			$sl="selected";
		}
		?><option value="<?php  echo $r[code]; ?>" <?php  echo $sl; ?>><?php  echo getlang($r[name]);?><?php 
	}
	?>	
	</select> <a href="templatename.php?ID=<?php  echo $ID?>" class=a_btn><?php  echo getlang("รูปแบบการอนุญาต::l::Permission template"); 
	?></a>
	:  <a href="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back"); 
	?></a>
	<?php 
		if ($loadpermset!='') {
			echo "<br>".getlang("หลังจากโหลดรูปแบบการอนุญาต กรุณาตรวจสอบและกดบันทึก::l::After load permission template , please review and save");
		}
	?></TD>
</TR>
</form>
</TABLE><BR>
<TABLE width=780 align=center class=table_border>
<form action="copypermission.php" method=post>
<INPUT TYPE="hidden" NAME="ID" value="<?php  echo $ID?>">
<TR valign=top>
	<TD width=300> <?php echo getlang("หรือ::l::or")?> <B><?php  echo getlang("ตั้งสิทธิ์ให้เหมือนกับผู้ใช้ต่อไปนี้::l::Copy permission from"); ?></B></TD>
	<TD><select name="sourceperm" ID="sourceperm" >
	<?php 
	$s=tmq("select * from library where UserAdminID<>'$ID' order by UserAdminName");
	while ($r=tmq_fetch_array($s) ) {
		?><option value="<?php  echo $r[UserAdminID]; ?>" ><?php  echo getlang($r[UserAdminName]);?><?php 
	}
	?>	
	</select> <INPUT TYPE="submit" value=OK></TD>
</TR>
</form>
</TABLE>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function checkallchild(wh,pid) {
	//alert(wh.checked);
	<?php 
	$s=tmq("select * from library_modules_cate where 1  ");
	while ($r=tfa($s)) {
		?>
		if (pid=="<?php  echo $r[code]?>") {
			<?php  
			$s2=tmq("select * from library_modules where nested='$r[code]' ");	
			while ($r2=tfa($s2)) {
				?>
				tmp=getobj("chkboxid<?php  echo $r2[id];?>");
				tmp.checked=wh.checked;
<?php 
			}
			?>
		}	
		<?php 
	}
	?>
	}
//-->
</SCRIPT>
<CENTER><BR><B><?php  echo getlang("การตั้งค่าการอนุญาต::l::Permission setting"); ?></B><BR></CENTER>
<form action="permission.php" method=post>

<?php 
$topcate=tmq("select distinct topcate from library_modules_cate where 1 order by topcate");
$topcatedb=tmq_dump2("library_modules_topcate","code","name");
//printr($topcatedb);
while ($topcater=tfa($topcate)) {
	pagesection($topcatedb[$topcater[topcate]]);
	///////////////////////////////////////////////////////////////////////////////////////
$s=tmq("select * from library_modules_cate where topcate='$topcater[topcate]' order by name");
?><TABLE class=table_border width=780 align=center>
<INPUT TYPE="hidden" NAME="issave" value="permission">
<INPUT TYPE="hidden" NAME="ID" value="<?php  echo $ID?>">
<TR class=table_td>
	<TD colspan=2 style="font-weight: bold;" align=center><Input type=submit value=" Submit "> <Input type=reset value=" Reset "></TD>

</TR>
<?php 
while ($r=tmq_fetch_array($s)) {
	$ss=tmq("select * from library_modules where nested='$r[code]' order by ordr");
	if (tmq_num_rows($ss)==0) {
		continue;
	}
	?><TR class=table_td>
	<TD style="font-weight: bold; " ><IMG SRC="../neoimg/Play.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle> <?php  echo getlang($r[name]);?></TD>
	<TD width=25>
	<INPUT TYPE=checkbox NAME="" style='border-width:0'  onclick="checkallchild(this,'<?php  echo $r[code];?>')" ID="master<?php  echo $r[code];?>"></TD>

</TR>
<?php 
	while ($rs=tmq_fetch_array($ss)) {
	if ($loadpermset!="") {
		$tmp=tmq("select * from library_permission_template where lib='$loadpermset' and code='$rs[code]' ");
	} else {
		$tmp=tmq("select * from library_permission where lib='$ID' and code='$rs[code]' ");
	}
			?><TR  bgcolor=f2f2f2>
		<TD  <?php 
			if ($rs[code]==$defmenu)	 {
				?> bgcolor=#FFCE9D<?php 
			}
			?>><label for="chkboxid<?php  echo $rs[id];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="../neoimg/Right.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle> <?php  echo getlang($rs[name]);
			if ($rs[code]==$defmenu)	 {
				echo " <I>(".getlang("เมนูเริ่มต้น::l::Default menu").")</I>";;
			}?></label> </TD>
		<TD align=center <?php 
			if ($rs[code]==$defmenu)	 {
				?> bgcolor=#FF9933<?php 
			} else {
					if (tmq_num_rows($tmp)!=0) {
            	  echo "bgcolor=ddffdd";
            	} else {
            		  echo "bgcolor=ffdddd";
            	}
			}
			?>
			
			>
		<?php 
		$formname="setpperm['$rs[code]']";

	if (tmq_num_rows($tmp)!=0 || $rs[code]==$defmenu) {
		echo "<INPUT TYPE=checkbox NAME=\"$formname\" ID='chkboxid$rs[id]' value='yes' checked style='border-width:0' parentid='$r[code]'  ";
		if ($rs[code]==$defmenu) {
			echo " onclick=\"this.checked=true;\" ";
		}
		echo ">";
		//$disbygroup="yes";
		//echo "<A HREF=\"template_permission.php?act=add&ID=$ID&code=$r[code]\"><IMG SRC=\"../../signon/neoimg/ball_red.gif\" WIDTH=16 HEIGHT=16  BORDER=0 ></A>";
	} else {
		echo "<INPUT TYPE=checkbox NAME=\"$formname\" ID='chkboxid$rs[id]' value='yes' style='border-width:0' parentid='$r[code]'>";
		//echo "<A HREF=\"template_permission.php?act=close&ID=$ID&code=$r[code]\"><IMG SRC=\"../../signon/neoimg/ball_green.gif\" WIDTH=16 HEIGHT=16  BORDER=0 ></A>";
		//$disbygroup="no";
	}
		?>
		</TD>
	</TR>
	<?php 

	}
}
///////////////////////////////////////////////////////////////////////////////////
}
?>
<TR class=table_td>
	<TD colspan=2 style="font-weight: bold;" align=center><Input type=submit value=" Submit "> <Input type=reset value=" Reset "></TD>

</TR>
</TABLE></form>
<BR>
<CENTER><A HREF="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER><?php 
foot();
?>