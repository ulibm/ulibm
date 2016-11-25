<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="webmenu_bibtag-clear";
        mn_lib();
if ($issave=="grantedno") {
	tmq("delete from webpage_bibtag where granted='no' ");
	echo "<FONT COLOR=orange><CENTER><B><H1>Done... (not allowed)</H1></B></CENTER></FONT>";
}
if ($issave=="clearall") {
	tmq("delete from webpage_bibtag where 1 ");
	echo "<FONT COLOR=orange><CENTER><B><H1>Done... (Clear all)</H1></B></CENTER></FONT>";
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ล้างข้อมูลการแท็ก Bib::l::Clear Bib. tagging data"));
?>
<table border = 0 cellpadding = 0 width = 700 align = center cellspacing=0>

<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="clearall">
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("ลบข้อมูลทั้งหมด::l::Clear all data");?></td>
  <td width=50% align=center class=table_td> <input type=submit value=' CLEAR ' style="color:red ; font-weight: bold"> </td>
 </tr></form>

<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="grantedno">
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("ลบข้อมูลที่ยังไม่อนุญาต::l::Clear disalled tag");?></td>
  <td width=50% align=center class=table_td> <input type=submit value=' CLEAR ' style="color:red ; font-weight: bold"> </td>
 </tr></form>

	<tr valign = "top">
	  <td colspan=2 align=center>
	  <?php  echo getlang("การกระทำนี้ไม่สามารถยกเลิกได้::l::This action cannot be undone");?>
	  </td>
</tr>
</table>
<?php 
				foot();
?>