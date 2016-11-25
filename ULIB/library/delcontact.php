<?php 
    ;
     include("../inc/config.inc.php");
                 loginchk_lib();
?>
                <div align = "center">
                    <table width = "100%" border = "0" cellspacing = "0" cellpadding = "0">
                        <tr valign = "top">
                            <td>
                                <font face = "MS Sans Serif, Microsoft Sans Serif" size = "2">

        <?php 
            echo $Sstr;
            if (!empty($ID))
                {
                $sql="delete from contact where ID=$ID";
                if (tmq($sql))
                    {
                    echo "<font face ='ms sans serif'  size ='3'>";
                    echo "<div align=center><br><b>ทำการลบข้อมูลเรียบร้อยแล้ว</b><br></div>";
                    echo "<meta http-equiv='refresh' content='0;URL=contact.php?sid=$sid'>";
                    echo "</font>";
                    }
                else
                    {
                    echo "<font face ='ms sans serif'  size ='3'>";
                    echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";
                    echo "</font>";
                    }
                }
            else
                {
                echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล กรุณาใส่ข้อมูลให้เรียบร้อย ตรวจสอบอีกครั้ง";
                }
            echo $Estr;
        ?>
                            </td>
                        </tr>
                    </table>
                </div>