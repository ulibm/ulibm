<?php 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="lastdatecheckout";
        mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("วันสุดท้ายที่ห้องสมุดรับคืน::l::Library's last checkin date"));
if ($issave=="yes") {
	barcodeval_set("lastdatecheckoutin",form_pickdt_get("lastdatecheckoutin"));
}
?>
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("วันสุดท้ายที่ห้องสมุดรับคืน::l::Library's last checkin date");?></td>
  <td width=50% align=center class=table_td><?php  form_quickedit("lastdatecheckoutin",barcodeval_get("lastdatecheckoutin"),"date"); ?></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
		foot();
?>