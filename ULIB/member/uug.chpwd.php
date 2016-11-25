<?php 
include("../inc/config.inc.php");

		if ($_ISULIBMASTER!="yes") {
		gen404();
		die;
	}head();
		   mn_web("webpage");

			//include("menuadmin.php");
		$sql="Select * From ulib_clientlogins Where loginid='".substr($_memid,4)."'  AND isallowed ='yes' ";
            //echo "$sql";
            $result=tmq( $sql);
            $Num=tmq_num_rows($result);
            if ($Num == 0)
                {
                echo "<font s><br>No UUG ID $_memid</font>";
                exit;
                }
            else
                {
                $row=tmq_fetch_array($result);
                $pwd=$row["Password"];
                $eml=$row["email"];
                $tel=$row["tel"];
        ?>
                    </b></font>
                    <form method = "post" action = "uug.chpwdaction.php" name = "webForm" onsubmit = "return chk(this)">
                        <font face = "MS Sans Serif, Microsoft Sans Serif"><b>
                        <center><BR>
                            <font color = "#FF0000"><b><font face = "MS Sans Serif, Microsoft Sans Serif">*</font></b></font><font size = "2"> <?php  echo getlang("กรุณาใส่รหัสผ่านใหม่ให้เหมือนกันทั้ง 2 ช่อง::l::Please enter your desired password"); ?></font>
                        </center> </b></font>
                        <table width = "<?php  echo $_TBWIDTH?>" class=table_border border = "0" cellpadding = "1" cellspacing = "0" bgcolor = "f2f2f2" align = "center">

                            <tr>
                                <td  class=table_head>
                                    <font face = "MS Sans Serif"><b><font color = "#FF0000">*</font></b><b><font size = "2"><?php  echo getlang("ชื่อหน่วยงาน::l::Organization name"); ?> </font>: </b> </font></td>
                                <td width = "50%" class=table_td>
                                    <input type = "text" name = "name" size = "40" value = "<?php  echo "$row[name]"; ?>" class = "unnamed1" autocomplete=off>
                                </td>
                            </tr>

<tr>
                                <td  class=table_head width = "50%">
                                    <b><font color = "#FF0000" face = "MS Sans Serif">* </font><font size = "2" face = "MS Sans Serif"><?php  echo getlang("รหัสผ่าน::l::Password"); ?> </font><font face = "MS Sans Serif">: </font></b></td>
                                <td width = "50%" class=table_td>
                                    <input type = "password" name = "pwd" size = "20" value = "<?php  echo "$row[passwd]"; ?>" class = "unnamed1" autocomplete=off>
                                </td>
                            </tr>
                            <tr>
                                <td  class=table_head>
                                    <font face = "MS Sans Serif"><b><font color = "#FF0000">*</font></b><b><font size = "2"><?php  echo getlang("ทวนรหัสผ่านอีกครั้ง::l::Confirm your password"); ?> </font>: </b> </font></td>
                                <td width = "50%" class=table_td>
                                    <input type = "password" name = "pwd2" size = "20" value = "<?php  echo "$row[passwd]"; ?>" class = "unnamed1" autocomplete=off>
                                </td>
                            </tr>
                            <tr>
                                <td class=table_head>
                                    <font face = "MS Sans Serif"><b><font color = "#FF0000">*</font></b><font size = "2"><b><?php  echo getlang("เบอร์โทรศัพท์::l::Tel."); ?></b></font><b>: </b></font></td>
                                <td width = "50%" class=table_td>
                                    <input type = "text" name = "tel" size = "20" value = "<?php  echo "$row[tel]"; ?>" class = "unnamed1" >
                                </td>
                            </tr>
                            <tr>
                                <td  class=table_head>
                                    <b><font color = "#FF0000" face = "MS Sans Serif">*</font><font size = "2" face = "MS Sans Serif"><?php  echo getlang("อีเมล์::l::E-mail"); ?> </font><font face = "MS Sans Serif">: </font></b></td>
                                <td width = "50%" class=table_td>
                                    <input type = "text" name = "eml" size = "20" value = "<?php  echo "$row[email]"; ?>" class = "unnamed1">
                                </td>
                            </tr>                            <tr>
                                <td  class=table_head>
                                    <b><font color = "#FF0000" face = "MS Sans Serif">*</font><font size = "2" face = "MS Sans Serif"><?php  echo getlang("ที่อยู่::l::Address"); ?> </font><font face = "MS Sans Serif">: </font></b></td>
                                <td width = "50%" class=table_td><textarea name="address" rows="4" cols="80"><?php  echo $row[address]?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td align = "right" width = "50%">
                                    <input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit"); ?>">
                                </td>
                                <td width = "50%">
                                    <input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Reset"); ?>">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <br>
                    <font face = "MS Sans Serif, Microsoft Sans Serif"><b>
        <?php 
                }
        ?>
        <script language = "JavaScript">
            function chk(wh)
                {
                if (wh.pwd.value == "")
                    {
                    alert("กรุณากรอกรหัสผ่าน");
                    return false;
                    }
                if (wh.pwd.value != wh.pwd2.value)
                    {
                    alert("รหัสผ่านทั้ง 2 ช่องต้องเหมือนกัน");
                    return false;
                    }
                }
        </script> </b></font>
                </div>
                </td></tr></table>
<?php 
foot();
?>