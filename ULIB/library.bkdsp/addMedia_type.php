<?php  
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);?><BR>

                    <table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">
                        <tr valign = "top">
                            <td>
                                <form name = "form1" method = "post" action = "addMedia_typeAction.php">
                                    <table width = "780" border = "0" cellspacing = "1" cellpadding = "4" align = "center" bgcolor = e3e3e3>

                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("ชื่อ::l::Name"); ?><br> </font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = text name = "name"> </font></td>
                                        </tr>

                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("การเรียงลำดับ::l::Ordering"); ?><br> </font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><input type = text name = "ordr" value=10> </font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "top">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("ค่าที่จะแสดง<br> หากต้องการแสดงเฉพาะ Subfields ให้ใส่ _subfield ต่อท้ายชื่อแท็กในวงเล็บ <BR>เช่น \$r[tag856_u]::l::Text to display<BR>If need to show only subfield, use _subfield follow tag name in '[]' <BR>Ex.\$r[tag856_u]"); ?></font></td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><TEXTAREA NAME="val" ROWS="5" COLS="50" id=targets maxlength=255></TEXTAREA>
												<SELECT NAME="valk" size=5 onclick="fill(this.form)" style="height: 106px;"><?php  
										$s = "select * from bkedit order by ordr";
										$r=tmq($s);
										while ($r2=tmq_fetch_array($r)) {
										    echo "<option value='$r2[fid]'> $r2[name]</option>\n";
										}
										?>
										</SELECT>
										<SCRIPT LANGUAGE="JavaScript">
										<!--
										 function fill(wh)  {
											x= wh.val.value 
										   wh.val.value = x + " $r[" + wh.valk.value + "]"
										}
										//-->
										</SCRIPT>
												</font></td>
                                        </tr>


                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle"> 
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("แทนที่สัญลักษณ์ 
Subfield ด้วย::l::Replace subfield sign with"); ?> :</font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><input type = text name = "replacewith" value=' '> 
</font></td>            
                                        </tr>

                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php echo getlang("ซ่อน
Subfield ต่อไปนี้ (คั่นด้วย ,)::l::Hide following subfield (seperates with ,)"); ?>:</font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><input type = text name = "hidefid" value=''>
</font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = 
"2"><?php echo getlang("ซ่อนข้อความต่อไปนี้ แบบ find=replacewith=limit (คั้นด้วย ,)::l::Hide following string find=replacewith=limit (seperates with ,)"); ?> :</font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><input type = text name = "hidestr" value=''>
</font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = 
"2"><?php echo getlang("Trim ข้อความต่อไปนี้ (คั้นด้วย ,)::l::Trim following string (seperates with ,)"); ?>:</font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><input type = text name = "trimthis" value=''>
</font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = 
"2"><?php echo getlang("ลิงค์ Subfield ไปที่::l::Link subfield to"); ?>:</font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><input type = text name = "linksubf" value=''>
</font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = 
"2"><?php echo getlang("ลิงค์ข้อมูลรายการนี้ ไปที่::l::Link this row to"); ?>:</font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><input type = text name = "linkrow" value=''>
</font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = 
"2"><?php echo getlang("เชื่อมโยงกับฟิลด์ใด::l::Link to field"); ?>:</font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><input type = text name = "boundwith" value=''>
</font></td>
                                        </tr>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "27%" valign = "middle">
                                                <font face = "MS Sans Serif" size = 
"2"><?php echo getlang("จัดรูปแบบ ISN::l::Format as ISN"); ?>:</font></td>
                                            <td width = "73%">
                 <font face = "MS Sans Serif" size = "2"><?php  
				 form_quickedit("formatisn","no","list:yes,no");
				 ?>
</font></td>
                                        </tr>
                                                                          <tr bgcolor = "#e3e3e3">
                                            <td width = "27%" valign = "top">
                                                &nbsp;</td>
                                            <td width = "73%">
                                                <font face = "MS Sans Serif" size = "2"><input type = "submit" name = "Submit2" value = "<?php echo getlang("เพิ่มข้อมูล::l::Submit"); ?>">
												<input type = "reset" name = "Reset" value = "<?php echo getlang("ลบข้อมูล::l::Reset"); ?>"><input type = "hidden" name = "sid" value = "<?php echo $sid;?>"><input type = "hidden" name = "LibID" value = "<?php echo $LibID;?>">
												<A HREF="media_type.php"><?php echo getlang("กลับ::l::Back"); ?></A> 
												</font></td>
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