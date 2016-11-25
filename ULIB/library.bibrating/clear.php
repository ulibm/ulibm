<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="webmenu_bibrating-clear";
        mn_lib();
if ($issave=="yes") {
	tmq("delete from webpage_bibrating_log");
	tmq("delete from webpage_bibrating_sum");
	echo "<FONT COLOR=orange><CENTER><B><H1>Done...</H1></B></CENTER></FONT>";
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ล้างข้อมูลการให้คะแนน Bib::l::Clear Bib. rating data"));
?>
<table border = 0 cellpadding = 0 width = 700 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

<tr valign = "top">
	<td class=table_head> <?php  echo getlang("ยืนยันการลบข้อมูล::l::Confirm clear data");?></td>
  <td width=50% align=center class=table_td> <input type=submit value=' CLEAR ' style="color:red ; font-weight: bold"> </td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center>
	  <?php  echo getlang("การกระทำนี้ไม่สามารถยกเลิกได้::l::This action cannot be undone");?>
	  </td>
</tr></form>
</table>
<?php 
				foot();
?>