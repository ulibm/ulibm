<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
            $sql="select * from room where id='$ID'";
            $result=tmq( $sql);
            $Num=tmq_num_rows($result);
            if ($Num == 0)
                {
                echo "<font s><br>No Media_Type ID $ID</font>";
                exit;
                }
            else
                {
                $row=tmq_fetch_array($result);
                $name=$row["name"];
                $id=$row["id"];
        ?>
                    </b></font><CENTER>
                    <form method = "post" action = "editMedia_typeAction.php" name = "webForm">
                        <font color = "#FF0000"><b><font face = "MS Sans Serif, Microsoft Sans Serif">*</font></b></font><font face = "MS Sans Serif, Microsoft Sans Serif"><b>กรุณากรอกให้ครบทุกช่อง </b></font>
                        <table width = "780" border = "0" bgcolor = e3e3e3 align=center>
                            <tr>
                                <td align = "right" width = "50%">
                                    <b><font color = "#FF0000"></font></b> หมายเลข :
                                </td>
                                <td width = "50%"><?php 
                echo "$ID";
            ?>
                                </td>
                            </tr>

                            <tr>
                                <td align = "right" width = "50%">
                                    <b><font color = "#FF0000">*</font></b> ชื่อห้อง :
                                </td>
                                <td width = "50%">
                                    <input type = "text" name = "name" size = "50" value = "<?php  echo "$name"; 
?>">
                                </td>
                            </tr>
                        </table>
                        <input type = "submit" name = "Submit" value = "ตกลง"><input type = "reset" name = "Submit2" value = "ยกเลิก"><input type = "hidden" name = "mid" value = "<?php  echo "$ID"; ?>">
                    </form>
                    <br>
					<?php 
				}
					foot();
					?>