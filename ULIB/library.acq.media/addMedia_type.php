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

		<font face = "MS Sans Serif" size = "2"><?php echo getlang("ใช้งบประมาณ::l::Use budget"); ?><br> </font></td>

	<td width = "73%">

		<font face = "MS Sans Serif" size = "2">
<select name = setbudget>
<?php  
$s=tmq("select * from acq_setbudget order by  yea,major ");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[id]'>$r[yea]-$r[major]";
	$tmp="select sum(price*amount) as pp from acq_media where setbudget ='$r[id]' ";
	$tmp=tmq($tmp);
	$tmp=tmq_fetch_array($tmp);
	echo " (".getlang("เหลืองบประมาณ::l::Available")." ".number_format($r[val]-$tmp[pp])."/$r[val])";
}
?></select>
</font></td>

</tr>

<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("ชื่อเรื่อง::l::Title"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "d_titl"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("ชื่อผู้แต่ง::l::Author"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "d_auth"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("ปีพิมพ์::l::Year"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "d_yea"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("สำนักพิมพ์::l::Publisher"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "d_publ"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2">ISBN<br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "d_isbn"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("พิมพ์/จัดทำครั้งที่::l::Edition"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "d_edition"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("พิมพ์ลักษณ์::l::Imprint"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "d_imprint"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("ประเภทวัสดุสารสนเทศ::l::Material type"); ?> <br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "d_mdtype"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("หมายเหตุ::l::Note"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "note"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("จำนวน::l::Quanity"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "amount" value=1> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"><?php echo getlang("ราคา::l::Price"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2"><input type = text name = "Fprice"> </font></td>
</tr>
<tr bgcolor = "#f3f3f3">
	<td colspan=2 align=center>
		<font face = "MS Sans Serif" size = "2"><input type = button onclick="openchk(this.form)" value=" <?php echo getlang("ตรวจสอบความซ้ำซ้อน::l::Check for duplication"); ?> "> </font></td>
</tr>
<SCRIPT LANGUAGE="JavaScript">
<!--
function openchk(wh) {
window.open('checkdup.php?d_titl='+wh.d_titl.value+'&d_isbn='+wh.d_isbn.value,"checkdup","top=200,left=250,width=350,height=400");
}
//-->
</SCRIPT>
										<tr bgcolor = "#e3e3e3">

                                            <td width = "27%" valign = "top">

                                                &nbsp;</td>

                                            <td width = "73%">

                                                <font face = "MS Sans Serif" size = "2">
<input type = "submit" name = "Submit" value = "<?php echo getlang("ตกลง::l::Submit"); ?>">
<input type = "reset" name = "Submit2" value = "<?php echo getlang("ยกเลิก::l::Reset"); ?>">
<a href="media_type.php" class=a_btn><?php echo getlang("กลับ::l::Back"); ?></a>


												<input type = "hidden" name = "sid" value = "<?php echo $sid;?>"><input type = "hidden" name = "LibID" value = "<?php echo $LibID;?>">
 </font></td>

                                        </tr>

                                    </table>

                                </form>

                                <br>

                            </td>

                        </tr>

						</table>

						<?php  foot();?>