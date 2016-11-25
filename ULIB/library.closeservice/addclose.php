<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
?><BR>
                    <table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">
<form action=addcloseAction.php mothod=post>                        <tr valign = "top">
                            <td>
                                    <table width = "780" align=center border = "0" cellspacing = "1" cellpadding = "4" align = "center"bgcolor=e3e3e3>

<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"> <?php  echo getlang(" สาขาห้องสมุด ::l::Campus"); ?><br> </font></td>
	<td width = "73%"><?php frm_libsite("managing",$managing); ?>
</td></tr>
<tr bgcolor = "#f3f3f3">
	<td width = "27%" valign = "middle">
		<font face = "MS Sans Serif" size = "2"> <?php  echo getlang(" วัน เดือน ปี ::l::Date month year"); ?><br> </font></td>
	<td width = "73%">
		<font face = "MS Sans Serif" size = "2">
		<select name = Fdat><?php 
				for ($i=1; $i <= 31; $i++) { 
				$s = "";
				if ($i==date("d")) {
					$s = "selected";
				}
					echo "<option value='$i' $s>$i"; 
				}
			?></select>
		<select name = Fmon><?php 
				for ($i=1; $i <= 12; $i++)
					{
					$s = "";
					if ($i==date("m")) {
						$s = "selected";
					}
					echo "<option value='$i' $s>";
					echo $thaimonstr[$i];
					}
			?></select>
		<select name = Fyea><?php 
				echo "<option value='-1' >".getlang("ทุกปี::l::Every year"); 
				 for ($i=$_MSTARTY; $i <= $_MENDY; $i++) { 
				echo "<option value='$i' >$i"; }
                                                    ?></select> </font></td>
</tr>
                                        <tr>
                                            <td>
                                                <font face = "MS Sans Serif" size = -2><?php  echo getlang("คำอธิบาย::l::Description"); ?></td>
                                            <td>
                                                <input type = text name = descr size = 65></td></tr>
                                        <tr bgcolor = "#f2f2f2">
                                            <td width = "27%" valign = "top">
                                    &nbsp;</td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2">
												<input type = "submit" name = "Submit2" value = "<?php  echo getlang("เพิ่มข้อมูล::l::Submit"); ?>">
												<input type = "reset" name = "Reset" value = "<?php  echo getlang("ลบข้อมูล::l::Reset"); ?>">
												<a href="closeservice.php?managing=<?php echo $managing;?>" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></a>
												<input type = "hidden" name = "sid" value = "<?php  echo $sid;?>"><input type = "hidden" name = "LibID" value = "<?php  echo $LibID;?>"> </font></td>
                                        </tr>
                                    </table>
                                </form>
                                <br>
                            </td>
                        </tr>
                    </table>
<?php 
foot();
?>