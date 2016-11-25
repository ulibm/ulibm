<?php 
    ;
            include("../inc/config.inc.php");
           head();
		   mn_web("webpage");

			//include("menuadmin.php");
			$sql="select * from member where UserAdminID ='$_memid'";
            //echo "$sql";
            $result=tmq( $sql);
            $Num=tmq_num_rows($result);
            if ($Num == 0)
                {
                echo "<font s><br>No Member ID $_memid</font>";
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
                    <form method = "post" action = "chpwdaction.php" name = "webForm" onsubmit = "return chk(this)">
                        <font face = "MS Sans Serif, Microsoft Sans Serif"><b>
                        <center><BR>
                            <font color = "#FF0000"><b><font face = "MS Sans Serif, Microsoft Sans Serif">*</font></b></font><font size = "2"> <?php  echo getlang("กรุณาใส่รหัสผ่านใหม่ให้เหมือนกันทั้ง 2 ช่อง::l::Please enter your desired password"); ?></font>
                        </center> </b></font>
                        <table width = "750" class=table_border border = "0" cellpadding = "1" cellspacing = "0" bgcolor = "f2f2f2" align = "center">
                            <tr>
                                <td  class=table_head width = "50%">
                                    <b><font color = "#FF0000" face = "MS Sans Serif">* </font><font size = "2" face = "MS Sans Serif"><?php  echo getlang("รหัสผ่าน::l::Password"); ?> </font><font face = "MS Sans Serif">: </font></b></td>
                                <td width = "50%" class=table_td>
                                    <input type = "password" name = "pwd" size = "20" value = "<?php  echo "$pwd"; ?>" class = "unnamed1" autocomplete=off>
                                </td>
                            </tr>
                            <tr>
                                <td  class=table_head>
                                    <font face = "MS Sans Serif"><b><font color = "#FF0000">*</font></b><b><font size = "2"><?php  echo getlang("ทวนรหัสผ่านอีกครั้ง::l::Confirm your password"); ?> </font>: </b> </font></td>
                                <td width = "50%" class=table_td>
                                    <input type = "password" name = "pwd2" size = "20" value = "<?php  echo "$pwd"; ?>" class = "unnamed1" autocomplete=off>
                                </td>
                            </tr>
                            <tr>
                                <td class=table_head>
                                    <font face = "MS Sans Serif"><b><font color = "#FF0000">*</font></b><font size = "2"><b><?php  echo getlang("เบอร์โทรศัพท์::l::Tel."); ?></b></font><b>: </b></font></td>
                                <td width = "50%" class=table_td>
                                    <input type = "text" name = "tel" size = "20" value = "<?php  echo "$tel"; ?>" class = "unnamed1" >
                                </td>
                            </tr>
                            <tr>
                                <td  class=table_head>
                                    <b><font color = "#FF0000" face = "MS Sans Serif">*</font><font size = "2" face = "MS Sans Serif"><?php  echo getlang("อีเมล์::l::E-mail"); ?> </font><font face = "MS Sans Serif">: </font></b></td>
                                <td width = "50%" class=table_td>
                                    <input type = "text" name = "eml" size = "20" value = "<?php  echo "$eml"; ?>" class = "unnamed1">
                                </td>
                            </tr>
																		<?php 
$cust=tmq("select * from member_customfield where isshow='yes' and usercanedit='yes' order by fid");
while ($custr=tmq_fetch_array($cust)) {
	if (strtolower($custr[usercanedit])!="yes") {
		?><input type = hidden name = "<?php  echo $custr[fid];?>" size = 57 value="<?php  echo addslashes($row[$custr[fid]])?>"><?php 
	} else {
	?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang($custr[name]);?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>>
		<?php form_quickedit($custr[fid],$row[$custr[fid]],$custr[ftype]);	?>
		<!-- <input type = text name = "<?php  echo $custr[fid];?>" size = 57 value="<?php  echo $row[$custr[fid]]?>"> --></TD>
	</TR>
	<?php 
	}
}?>
<TR>
	<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("แสดงหนังสือโปรดและการคอมเมนท์::l::Show Fav. book and comments");?></TD>
	<TD class=table_td <?php  echo $addhtmlsize;?>>
<INPUT TYPE="checkbox" NAME="publishbookinfo" value="yes" style="border: 0"
<?php  if ($row[publishbookinfo]=='yes') {
	echo " checked ";
}
	?>
></TD>
</TR>

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