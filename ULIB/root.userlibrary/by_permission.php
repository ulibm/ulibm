<?php 
;
include("../inc/config.inc.php");
html_start();
mn_root("userlibrary");

?>

<CENTER><B><?php  echo getlang("การอนุญาตตามสิทธิ์::l::View by permission"); ?></B><BR></CENTER>
<TABLE xclass=table_border width=1000 align=center>
<tr><td width=50%></td><td>
<div style="position: fixed; background-color: white;"><iframe width=500 name=checkerif style="height: calc(100% - 100px);"></iframe></div>
</td></tr>
<tr><td width=50%>




<?php 
$topcate=tmq("select distinct topcate from library_modules_cate where 1 order by topcate");
$topcatedb=tmq_dump2("library_modules_topcate","code","name");
//printr($topcatedb);
while ($topcater=tfa($topcate)) {
	echo "<table width=100%><tr><td><BR><font style='font-size: 26px; font-weight: bold; color: #777777;'>".getlang($topcatedb[$topcater[topcate]])."</font>   <BR><BR></td></tr></table>";
   //pagesection($topcatedb[$topcater[topcate]]);
	///////////////////////////////////////////////////////////////////////////////////////
$s=tmq("select * from library_modules_cate where topcate='$topcater[topcate]' order by name");
?><TABLE class=table_border width=500 align=center>


<?php 
while ($r=tmq_fetch_array($s)) {
	$ss=tmq("select * from library_modules where nested='$r[code]' order by ordr");
	if (tmq_num_rows($ss)==0) {
		continue;
	}
	?><TR class=table_td>
	<TD style="font-weight: bold; " ><IMG SRC="../neoimg/Play.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle> <?php  echo getlang($r[name]);?></TD>


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
			?>><a style='text-decoration:none' target=checkerif href="by_permission_check.php?permid=<?php echo $rs[code];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC="../neoimg/Right.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle> <?php  echo getlang($rs[name]);
			if ($rs[code]==$defmenu)	 {
				echo " <I>(".getlang("เมนูเริ่มต้น::l::Default menu").")</I>";;
			}?></a> </TD>

	</TR>
	<?php 

	}
}
///////////////////////////////////////////////////////////////////////////////////
}
?>

</TABLE>


</td><td><td></table>
<BR>


<CENTER><A HREF="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></A>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</CENTER><?php 
foot();
?>