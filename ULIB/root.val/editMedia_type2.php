<?php 

    ;

        include ("../inc/config.inc.php");
		head();
	mn_root("val");

            $sql="select * from val where id='$ID'";

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

                $name=$row["val"];

                $id=$row["id"];

        ?>
<CENTER>
                    <form method = "post" action = "editMedia_typeAction.php" name = "webForm">

                        <font color = "#FF0000"><b><font face = "MS Sans Serif, Microsoft Sans Serif">*</font></b></font><font face = "MS Sans Serif, Microsoft Sans Serif"><b><?php  echo getlang("กรุณากรอกค่าตัวแปร สำหรับ::l::Please enter value for variable"); ?> ["<?php  echo $row['main'] ?>" -> "<?php  echo $row[sub] ?>"]</b></font>

                        <table width = "780" align=center border = "0" bgcolor = e3e3e3>

                            <tr>

                                <td align = "right" width = "50%">

                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("ค่าตัวแปร::l::Value"); ?>  :

                                </td>

                                <td width = "50%">

                               <TEXTAREA NAME="name" ROWS="3" COLS="40"><?php  echo "$name"; 

?></TEXTAREA>
                                </td>

                            </tr>

							<tr>
                                <td align = "right" width = "50%">
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ความต้องการ::l::Expected"); ?> :
                                </td>
                                <td width = "50%"><?php  echo getlang("ต้องการค่าตัวแปรประเภท::l::Value type"); ?> : <B><?php  echo "$row[valtype]"; ?></B>
                                </td>
                            </tr>
							<tr>
                                <td align = "right" width = "50%">
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ข้อความแนะนำ::l::Description"); ?> :
                                </td>
                                <td width = "50%"> <B><?php  echo getlang("$row[descr]"); ?><BR><INPUT TYPE="text" name='descr' value="<?php  echo $row[descr]?>" size=56></B>
                                </td>
                            </tr>

                        </table>

                        <input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit"); ?>">
						<input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Reset"); ?>">
						<input type = "hidden" name = "mid" value = "<?php  echo "$ID"; ?>">

						<A HREF="media_type.php"><?php  echo getlang("กลับ::l::Back"); ?></A> 
                    </form>
</CENTER>
                    <br>

   
        <?php 


        }


		foot();
?>