<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);

			$sql="select * from bkdsp where id='$ID'";
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
                                <td align = "right" width = "20%">
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("ชื่อ::l::Name"); ?> :
                                </td>
                                <td >
                                    <input type = "text" name = "name" size = "50" value = "<?php  echo "$row[name]"; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td align = "right" width = "20%">
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("การเรียงลำดับ::l::Ordering"); ?> :
                                </td>
                                <td>
                                    <input type = "text" name = "ordr" size = "50" value = "<?php  echo "$row[ordr]"; ?>">
                                </td>
                            </tr>
                                        <tr >
                                            <td align = "right" width = "20%" valign=top>
                                           <B><font color = "#FF0000">*</font></B>     <font face = "MS Sans Serif" size = "2"><?php  echo getlang("ค่าที่จะแสดง<br> หากต้องการแสดงเฉพาะ Subfields ให้ใส่ _subfield ต่อท้ายชื่อแท็กในวงเล็บ <BR>เช่น \$r[tag856_u]::l::Text to display<BR>If need to show only subfield, use _subfield follow tag name in '[]' <BR>Ex.\$r[tag856_u]"); ?></font></td>
                                            <td width = "83%">
                                                <font face = "MS Sans Serif" size = "2"><TEXTAREA NAME="val" ROWS="5" COLS="50" id=targets maxlength=255><?php  echo $row[val];?></TEXTAREA>
												<SELECT NAME="valk" size=5 style="height: 106px;" onclick="fill(this.form)"><?php 
										$s = "select * from bkedit order by ordr";
										$r=tmq($s);
										while ($r2=tmq_fetch_array($r)) {
										    echo "<option value='$r2[fid]'>$r2[fid] - $r2[name]";
										}
										?></SELECT><SCRIPT LANGUAGE="JavaScript">
										<!--
										 function fill(wh)  {
											x= wh.val.value 
										   wh.val.value = x + " $r[" + wh.valk.value + "]"
										}
										//-->
										</SCRIPT>
												</font></td>
                                        </tr>


                            <tr>
                                <td align = "right" width = "20%">
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("แทนที่สัญลักษณ์ 
Subfield ด้วย::l::Replace subfield sign with"); ?> :
                                </td>
                                <td>
                                    <input type = "text" name = "replacewith" size = "30" value = "<?php  echo 
"$row[replacewith]"; ?>">
                                </td>
                            </tr>

                            <tr>
                                <td align = "right" width = "20%">
                                    <b><font color = "#FF0000">*</font></b> <?php  echo getlang("ซ่อน
Subfield ต่อไปนี้ (คั่นด้วย ,)::l::Hide following subfield (seperates with ,)"); ?> :
                                </td>
                                <td>
                                    <input type = "text" name = "hidefid" size = "30" value = "<?php  echo
"$row[hidefid]"; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td align = "right" width = "20%">
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("ซ่อนข้อความต่อไปนี้ แบบ find=replacewith=limit (คั้นด้วย ,)::l::Hide following string find=replacewith=limit (seperates with ,)"); ?> :
                                </td>
                                <td>
                                    <input type = "text" name = "hidestr" size = "30" value = "<?php  echo
"$row[hidestr]"; ?>">
                                </td>
                            </tr>

                            <tr>
                                <td align = "right" width = "20%">
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("Trim ข้อความต่อไปนี้ (คั้นด้วย ,)::l::Trim following string (seperates with ,)"); ?> :
                                </td>
                                <td>
                                    <input type = "text" name = "trimthis" size = "30" value = "<?php  echo
"$row[trimthis]"; ?>">
                                </td>
                            </tr>
                             <tr>
                                <td align = "right" width = "20%">
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("ลิงค์ Subfield ไปที่::l::Link subfield to"); ?>:
                                </td>
                                <td>
                                    <input type = "text" name = "linksubf" size = "30" value = "<?php  echo
"$row[linksubf]"; ?>">
                                </td>
                            </tr>
                             <tr>
                                <td align = "right" width = "20%">
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("ลิงค์ข้อมูลรายการนี้ ไปที่::l::Link this row to"); ?>:
                                </td>
                                <td>
                                    <input type = "text" name = "linkrow" size = "30" value = "<?php  echo
"$row[linkrow]"; ?>">
                                </td>
                            </tr>							
							
                             <tr>
                                <td align = "right" width = "20%">
                                    <b><font color = "#FF0000">*</font></b><?php  echo getlang("เชื่อมโยงกับฟิลด์ใด::l::Link to field"); ?>:
                                </td>
                                <td>
                                    <input type = "text" name = "boundwith" size = "30" value = "<?php  echo
"$row[boundwith]"; ?>">
                                </td>
                            </tr>							
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = 
"2"><?php  echo getlang("จัดรูปแบบ ISN::l::Format as ISN"); ?>:</font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><?php 
				 form_quickedit("formatisn",$row[formatisn],"list:yes,no");
				 ?>
</font></td>
                                        </tr>							</table>
                        <input type = "submit" name = "Submit" value = "<?php  echo getlang("ตกลง::l::Submit"); ?>">
						<input type = "reset" name = "Submit2" value = "<?php  echo getlang("ยกเลิก::l::Reset"); ?>"><input type = "hidden" name = "mid" value = "<?php  echo "$ID"; ?>">
<A HREF="media_type.php"><?php  echo getlang("กลับ::l::Back"); ?></A> 
                    </form></CENTER>
<?php 
							foot();?>