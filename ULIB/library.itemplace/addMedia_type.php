<?php  
;
include("../inc/config.inc.php");
head();
$_REQPERM="itemplace";
$tmp=mn_lib();
?><BR>
<table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">

<tr valign = "top">

<td>
<form name = "form1" method = "post" action = "addMedia_typeAction.php">

<table width = "780" border = "0" cellspacing = "1" cellpadding = "4" align = "center" bgcolor = e3e3e3>

	<tr bgcolor = "#f3f3f3">

		<td width = "27%" valign = "middle">

			<font face = "MS Sans Serif" size = "2"><?php echo getlang("สาขาห้องสมุด::l::Library campus"); ?><br> </font></td>

		<td width = "73%">

			<font face = "MS Sans Serif" size = "2"><input type = hidden name = "main" value='<?php echo $libsite?>'> <B><?php echo get_libsite_name($libsite)?></B> </font></td>

	</tr>

	<tr bgcolor = "#f3f3f3">

		<td width = "27%" valign = "middle">

			<font face = "MS Sans Serif" size = "2"><?php echo getlang("อักษรย่อ::l::Code"); ?><br> </font></td>

		<td width = "73%">

			<font face = "MS Sans Serif" size = "2"><input type = text name = "code">  </font></td>

	</tr>

	<tr bgcolor = "#f3f3f3">

		<td width = "27%" valign = "middle">

			<font face = "MS Sans Serif" size = "2"><?php echo getlang("เลขเรียกประจำคอลเลกชั่น::l::Callnumber for collection"); ?><br> </font></td>

		<td width = "73%">

			<font face = "MS Sans Serif" size = "2"><input type = text name = "collcode">  </font></td>

	</tr>

	<tr bgcolor = "#f3f3f3">
		<td width = "27%" valign = "middle">
			<font face = "MS Sans Serif" size = "2"><?php echo getlang("ชื่อเต็ม::l::Name"); ?><br> </font></td>
		<td width = "73%">
			<font face = "MS Sans Serif" size = "2"><input type = text name = "name"> </font></td>
	</tr>
	<tr bgcolor = "#f3f3f3">
		<td width = "27%" valign = "middle">
			<font face = "MS Sans Serif" size = "2"><?php echo getlang("อนุญาตขอยืม::l::Allow request"); ?><br> </font></td>
		<td width = "73%">
			<font face = "MS Sans Serif" size = "2"><?php form_quickedit("isrq","","yesno");?></font></td>
	</tr>
	<!-- <tr bgcolor = "#f3f3f3">
		<td width = "27%" valign = "middle">
			<font face = "MS Sans Serif" size = "2"><?php echo getlang("เป็นสถานที่หลักของทรัพยากร::l::Default location for"); ?><br> </font></td>
		<td width = "73%">
			<font face = "MS Sans Serif" size = "2"><?php frm_restype("defformattype","","");?></font></td>
	</tr> -->
	<tr bgcolor = "#e3e3e3">

		<td width = "27%" valign = "top">

			&nbsp;</td>

		<td width = "73%">

			<font face = "MS Sans Serif" size = "2"><input type = "submit" name = "Submit2" value = "<?php echo getlang("เพิ่มข้อมูล::l::Submit"); ?>"> <input type = "reset" name = "Reset" value = "<?php echo getlang("ลบข้อมูล::l::Reset"); ?>"><input type = "hidden" name = "LibID" value = "<?php echo $LibID;?>">  <A HREF="media_type.php"><?php echo getlang("กลับ::l::Back"); ?></A> </font></td>

	</tr>

</table>

</form>
<BR>
</td>

</tr>

</table>
<?php  
foot();
?>