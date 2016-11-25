<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);

            $sql="select * from bkedit where id='$ID'";
            $result=tmq( $sql);
            $Num=tmq_num_rows($result);
            if ($Num == 0)
                {
                echo "<font s><br>No Media_Type ID $ID</font>";
                exit;
                }

                $row=tmq_fetch_array($result);
                $name=$row["name"];
                $id=$row["id"];
        ?>
<CENTER>
                    <form method = "post" action = "editMedia_typeAction.php" name = "webForm">
                        <table width = "780" align=center border = "0" bgcolor = e3e3e3>
                            <tr>
                                <td align = "right" width = "30%">
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ชื่อแท็ก::l::Tag name"); ?> :
                                </td>
                                <td >
                                    <input type = "text" name = "fid" size = "50" value = "<?php  echo "$row[fid]"; ?>"> <a href='http://www.loc.gov/marc/bibliographic/concise/bd<?php echo trim($row[fid],'tag');?>.html' target=_blank class='smaller2'>view</a>
                                </td>
                            </tr><!--
                            <tr>
                                <td align = "right" >
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang(" Indicator มาตรฐาน #1 ::l:: Default Indicator #1 "); ?>:
                                </td>
                                <td >
                                    <input type = "text" name = "defindi1" size = "50" value = "<?php  echo "$row[defindi1]"; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td align = "right" >
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang(" Indicator มาตรฐาน #2::l:: Default Indicator  #2"); ?> :
                                </td>
                                <td >
                                    <input type = "text" name = "defindi2" size = "50" value = "<?php  echo "$row[defindi2]"; ?>">
                                </td>
                            </tr>-->
                            <tr>
                                <td align = "right" >
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ข้อความที่จะแสดง::l::Displaying text"); ?> :
                                </td>
                                <td >
                                    <input type = "text" name = "name" size = "50" value = "<?php  echo "$row[name]"; 
?>">
                                </td>
                            </tr>
                            <tr>
                                <td align = "right" >
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ตัวอย่าง::l::Example"); ?> :
                                </td>
                                <td >

								<TEXTAREA NAME="example" ROWS="4" COLS="70"><?php  echo $row[example]; ?></TEXTAREA>
                                </td>
                            </tr>
                            <tr>
                                <td align = "right" >
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("คำอธิบาย::l::Description"); ?> :
                                </td>
                                <td >
								<TEXTAREA NAME="descr" ROWS="4" COLS="70"><?php  echo $row[descr]; ?></TEXTAREA>
                                </td>
                           </tr>
                           <tr>
                               <td align = "right" >
                                   <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ข้อความด่วน::l::Quick text"); ?><br> <?php  echo getlang("1 บรรทัดต่อ 1 รายการ::l::1 per line"); ?>
                               </td>
                               <td >

							<TEXTAREA NAME="quicktext" ROWS="4" COLS="70"><?php  echo $row[quicktext]; ?></TEXTAREA>
                               </td>
                           </tr>
                           <tr>
                               <td align = "right" >
                                   <b><font color = "#FF0000">*</font></b> <?php  echo getlang("Subfield info"); ?>
                               </td>
                               <td >

							<TEXTAREA NAME="subfieldinfo" ROWS="14" COLS="70"><?php  echo $row[subfieldinfo]; ?></TEXTAREA>
                               </td>
                           </tr>
                           <tr>
                                <td align = "right" >
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("เรียงเป็นลำดับที่ (น้อยไปมาก)::l::Ordering (ASC)"); ?> :
                                </td>
                                <td >
                                    <input type = "text" name = "ordr" size = "50" value = "<?php  echo "$row[ordr]"; 
?>">
                                </td>
                            </tr>

                        </table>
                        <input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit"); ?>">
						<input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Reset"); ?>"><input type = "hidden" name = "mid" value = "<?php  echo "$ID"; ?>"> <A HREF = "media_type.php"><B>Back</B></A>
                    </form></CENTER>
                    <br>
					<?php 
foot();?>