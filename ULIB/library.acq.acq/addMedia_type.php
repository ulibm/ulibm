<?php  
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
?><BR>
                    <table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">

                             <tr valign = "top">

                            <td>
                                <div align = "center">

                                    <font face = "MS Sans Serif, Microsoft Sans Serif" size = "3"> </font>

                                </div>

                                <form name = "form1" method = "post" action = "addMedia_typeAction.php">

                                    <table width = "770" border = "0" cellspacing = "1" cellpadding = "4" align = "center" bgcolor = e3e3e3>




<tr bgcolor = "#f3f3f3">

	<td width = "27%" valign = "middle">

		<font face = "MS Sans Serif" size = "2"><?php echo getlang("ติดต่อกับบริษัท::l::Contact Company");?><br> </font></td>

	<td width = "73%">

		<font face = "MS Sans Serif" size = "2">
<select name = company>
<?php  
$s=tmq("select * from acq_company order by  name ");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[id]'>$r[name]";
}
?></select>
</font></td>

</tr>

<tr bgcolor = "#f3f3f3">

	<td width = "27%" valign = "middle">

		<font face = "MS Sans Serif" size = "2"><?php echo getlang("สถานะ::l::Status");?><br> </font></td>

	<td width = "73%">

		<font face = "MS Sans Serif" size = "2">
<select name = status>
<?php  
$s=tmq("select * from acq_acq_status order by  ordr ");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[status]'>$r[status]";
}
?></select>
</font></td>

</tr>

<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("หมายเหตุ::l::Note");?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "note"> </font></td>
</tr>
										<tr bgcolor = "#e3e3e3">

                                            <td width = "27%" valign = "top">

                                                &nbsp;</td>

                                            <td width = "73%">

                                                <font face = "MS Sans Serif" size = "2"><input type = "submit" name = "Submit2" value = "<?php echo getlang("เพิ่มข้อมูล::l::Submit");?>">
												<input type = "reset" name = "Reset" value = "<?php echo getlang("ลบข้อมูล::l::Reset");?>"><input type = "hidden" name = "sid" value = "<?php echo $sid;?>"><input type = "hidden" name = "LibID" value = "<?php echo $LibID;?>"><A HREF="media_type.php"> &nbsp;<B>Back</B></A> </font></td>

                                        </tr>

                                    </table>

                                </form>

                                <br>

                            </td>

                        </tr>

						</table>

						<?php  foot();?>