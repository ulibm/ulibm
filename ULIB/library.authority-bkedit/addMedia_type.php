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
                                <form name = "form1" method = "post" action = "addMedia_typeAction.php">
                                    <table width = "780" border = "0" cellspacing = "1" cellpadding = "4" align = "center" bgcolor = e3e3e3>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("ชื่อแท็ก::l::Tag name"); ?><br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = text name = "fid"> </font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("Indicator มาตรฐาน #1::l::Default Indicator #1"); ?><br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = text name = "defindi1"> </font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("Indicator มาตรฐาน #2::l::Default Indicator #2"); ?><br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = text name = "defindi2"> </font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("ข้อความที่จะแสดง::l::Displaying text"); ?><br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = text name = "name"> </font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("ตัวอย่าง::l::Example"); ?><br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = text name = "example"> </font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("คำอธิบาย::l::Description"); ?><br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = text name = "descr"> </font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"> <?php echo getlang("เรียงเป็นลำดับที่ (น้อยไปมาก)::l::Ordering (ASC)"); ?> <br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = text name = "ordr"> </font></td>
                                        </tr>

                                        <tr bgcolor = "#e3e3e3">
                                            <td width = "27%" valign = "top">
                                                &nbsp;</td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = "submit" name = "Submit2" value = "<?php echo getlang("เพิ่มข้อมูล::l::Submit"); ?>">
												<input type = "reset" name = "Reset" value = "<?php echo getlang("ลบข้อมูล::l::Reset"); ?>"><input type = "hidden" name = "sid" value = "<?php echo $sid;?>"><input type = "hidden" name = "LibID" value = "<?php echo $LibID;?>"> <A HREF="media_type.php"><?php echo getlang("กลับ::l::Back"); ?></A> </font></td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table>
					<?php  
					foot();
					?>