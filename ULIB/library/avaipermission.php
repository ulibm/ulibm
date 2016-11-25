<?php 
;
include("../inc/config.inc.php");
head();
$_REQPERM="mainmenu";
mn_lib();


$s=tmq("select * from library where UserAdminID='$useradminid' ");
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
<?php 
if (strtolower($s[isallowall])=="yes") {
?><TR>
	<TD colspan=2 style="color: darkgreen; font-weight: bold;"><?php  echo getlang("คุณสามารถใช้งานได้ทุกระบบ::l::You can use all modules"); ?></TD>
</TR><?php 
}
?>
</TABLE>
<?php 

if (strtolower($s[isallowall])=="yes") {
$isallowall="yes";
//foot();
//die;
}



$defmenu=$s[defmenu];
?>

<?php 
$topcate=tmq("select distinct topcate from library_modules_cate where 1 order by topcate");
$topcatedb=tmq_dump2("library_modules_topcate","code","name");
//printr($topcatedb);
while ($topcater=tfa($topcate)) {
	pagesection($topcatedb[$topcater[topcate]]);
	///////////////////////////////////////////////////////////////////////////////////////
$s=tmq("select * from library_modules_cate where topcate='$topcater[topcate]' order by name");
?><TABLE class=table_border width=780 align=center>

<?php 
while ($r=tmq_fetch_array($s)) {
	$ss=tmq("select * from library_modules where nested='$r[code]' order by ordr");
	if (tmq_num_rows($ss)==0) {
		continue;
	}
	?><TR class=table_td>
	<TD style="font-weight: bold; " ><IMG SRC="../neoimg/Play.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle> <?php  echo getlang($r[name]);?></TD>
	<TD width=25>
	-</TD>

</TR>
<?php 
	while ($rs=tmq_fetch_array($ss)) {
	
			$tmp=tmq("select * from library_permission where lib='$useradminid' and code='$rs[code]' ");

	if (tmq_num_rows($tmp)!=0 || $rs[code]==$defmenu) {
		$hasperm=true;
	} else {
		$hasperm=false;
	}
   if ($isallowall=="yes") {
		$hasperm=true;
   }
			?><TR  bgcolor=f2f2f2>
		<TD 
 <?php 
			if ($hasperm==true)	 {
				?> style="background-color: #F5FFF5; color: #666666;"<?php 
			} else {
				?> style="background-color: #FFEEEE; color: darkred; font-weight: bold;"<?php 
			}
			?>>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="../neoimg/Right.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle
			> <?php  echo getlang($rs[name]);
			if ($rs[code]==$defmenu)	 {
				echo " <I>(".getlang("เมนูเริ่มต้น::l::Default menu").")</I>";;
			}
			if ($hasperm==true)	 {
			} else {
				?> X<?php 
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

</TABLE></form>
<BR>
<CENTER><A HREF="mainadmin.php" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER><?php 
foot();
?>