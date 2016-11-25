<?php  
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
?><BR>
                    <table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">
                        <tr valign = "top">
                            <td>
                                <form name = "form1" method = "post" action = "addMedia_typeAction.php">

                                    <table width = "780" border = "0" cellspacing = "1" cellpadding = "4" align = "center" bgcolor = e3e3e3>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"> <?php echo getlang("กรุณาเลือกวัน::l::Choose day"); ?> <br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><SELECT NAME="dat">
												<?php  
									for ($i=0;$i<=6;$i++)	 {
										$s=tmq("select * from weeklyclose where dat=$i");
										if (tmq_num_rows($s)==0) {
											echo "<option value='$i' > $thaidaystr[$i]" ;
										}
									}
									?>
												</SELECT> </font></td>
                                        </tr>
                                        <tr bgcolor = "#e3e3e3">
                                            <td width = "27%" valign = "top">
                                                &nbsp;</td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2">

<input type = "submit" name = "Submit" value = "<?php echo getlang("ตกลง::l::Submit"); ?>">
<input type = "reset" name = "Submit2" value = "<?php echo getlang("ยกเลิก::l::Reset"); ?>">
<a href="media_type.php" class=a_btn><?php echo getlang("กลับ::l::Back"); ?></a>

												<input type = "hidden" name = "sid" value = "<?php echo $sid;?>"><input type = "hidden" name = "LibID" value = "<?php echo $LibID;?>"> </font></td>
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