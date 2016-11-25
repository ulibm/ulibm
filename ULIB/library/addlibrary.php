<?php  
    if ($loginadmin != true)
        {
        include("formlogin.php");
        echo "<center><font face ='ms sans serif' size =2 color = red>";
        echo "Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง";
        echo "</font></center>";
        }
    else
        {
?>
        <html>
            <head>
                <title> Directory of Database in Academic Libraries </title>
                <meta http-equiv = "Content-Type" content = "text/html; charset=windows-874">
                <style type = "text/css">
                <!--
                
                
                
                body {  margin: 0px  0px; padding: 0px  0px}
                
                
                
                a:link { color: #005CA2; text-decoration: none}
                
                
                
                a:visited { color: #005CA2; text-decoration: none}
                
                
                
                a:active { color: #0099FF; text-decoration: underline}
                
                
                
                a:hover { color: #0099FF; text-decoration: underline}
                
                
                
                -->
                </style>
            </head>
            <body bgcolor = "#FFFFFF">
                <div align = "center">
                    <table width = "100%" border = "0" cellspacing = "0" cellpadding = "0">
                        <tr>
                            <td><?php  
                include ("../toppage.php");
            ?></td>
                        </tr>
                        <tr valign = "top">
                            <td><?php  
                                    include ("menuadmin.php");
                                ?>
                                <div align = "center">
                                    <font face = "MS Sans Serif" size = "3">เพิ่มข้อมูลสถาบันที่มีฐานข้อมูล </font>
                                </div>
                                <?php  
                                    //ตรวจสอบสิทธิ์ถถ้าไม่ใช่ Root Admin
                                    IF ($Level == "Admin")
                                        {
                                ?>
                                        <form name = "form1" method = "post" action = "addnewlibrary.php">
                                            <table width = "90%" border = "0" cellspacing = "1" cellpadding = "4" align = "center">
                                                <tr bgcolor = "#e3e3e3">
                                                    <td width = "27%" valign = "top" bgcolor = "#e3e3e3">
                                                        <font face = "MS Sans Serif" size = "2">เลขหมู่</font></td>
                                                    <td width = "73%">
                                                        <font face = "MS Sans Serif" size = "2"><input type = "text" name = "FNameShort" size = "20" maxlength = "30" value = "<?php echo $FNameShort;?>"> </font></td>
                                                </tr>
                                                <tr bgcolor = "#f3f3f3">
                                                    <td width = "27%" valign = "top">
                                                        <font face = "MS Sans Serif" size = "2">ชื่อวัสดุ</font></td>
                                                    <td width = "73%">
                                                        <font face = "MS Sans Serif" size = "2"><input type = "text" name = "FLibName" size = "50" value = "<?php echo  $FLibName;?>"> </font></td>
                                                </tr>
                                                <tr bgcolor = "#e3e3e3">
                                                    <td width = "27%" valign = "top">
                                                        <font face = "MS Sans Serif" size = "2">ที่อยู่เว็บไซต์
                                                        <br> (คัดลอกมาจาก WEBOPAC)</font></td>
                                                    <td width = "73%">
                                                        <font face = "MS Sans Serif" size = "2"><input type = "text" name = "FLibURL" size = "50" value = "<?php echo  $FLibURL;?>"> </font></td>
                                                </tr>
                                                <!--
                                                            <tr bgcolor="#f3f3f3"> 
                                                
                                                              <td width="27%" valign="top"><font face="MS Sans Serif" size="2">ที่อยู่</font></td>
                                                
                                                              <td width="73%"><font face="MS Sans Serif" size="2"> 
                                                
                                                                <input type=hidden name="FLibAddress" cols="60" rows="4" value="<?php echo $FLibAddress;?>">
                                                
                                                                </font></td>
                                                
                                                            </tr>
                                                
                                                            <tr bgcolor="#e3e3e3"> 
                                                
                                                              <td width="27%" valign="top" bgcolor="#e3e3e3"><font face="MS Sans Serif" size="2">หมายเลขโทรศัพท์</font></td>
                                                
                                                              <td width="73%"> <font face="MS Sans Serif" size="2"> 
                                                
                                                                <input type="text" name="FLibTel" size="40" maxlength="100" value="<?php echo  $FLibTel;?>">
                                                
                                                                </font></td>
                                                
                                                            </tr>
                                                
                                                            <tr bgcolor="#f3f3f3"> 
                                                
                                                              <td width="27%" valign="top"><font face="MS Sans Serif" size="2">หมายเลขโทรสาร</font></td>
                                                
                                                              <td width="73%"> <font face="MS Sans Serif" size="2"> 
                                                
                                                                <input type="text" name="FLibFax" size="40" maxlength="100" value="<?php echo  $FLibFax;?>">
                                                
                                                                </font></td>
                                                
                                                            </tr>
                                                -->
                                                <tr bgcolor = "#e3e3e3">
                                                    <td width = "27%" valign = "top">
                                                        <font face = "MS Sans Serif" size = "2"></font></td>
                                                    <td width = "73%">
                                                        <font face = "MS Sans Serif" size = "2"><input type = "submit" name = "Submit2" value = "Add New Library"><input type = "reset" name = "Reset" value = "Clear"><input type = "hidden" name = "sid" value = "<?php echo $sid;?>"> </font></td>
                                                </tr>
                                            </table>
                                        </form>
                                        <?php  
                                        //ปิดตรวจสอบ Root Admin
                                        }
                                    Else
                                        {
                                        echo "<center><font face ='ms sans serif' size =3 color=red>";
                                        echo "<p>ท่านไม่มีสิทธิ์ที่จะทำรายการนี้ได้</p></font></center>";
                                        }
                                    // จบการตวจสอบ Root Admin
                                        ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php  
                                    include ("../foot.php");
                                ?></td>
                        </tr>
                    </table>
                </div>
            </body>
        </html>
<?php  
        }
?>
