<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
?><BR>
                                <?php 
                                
   html_dialog("",getlang("รายการสมาชิกที่ถูกลบออกจากระบบแล้ว เก็บไว้เพื่อดูรายละเอียดเก่าในกรณีที่ต้องการดูข้อมูลย้อนหลัง แยกตามสาขาห้องสมุด::l::Deleted member data, for later referrence , group by campus"));
                                    $sql1="SELECT distinct libsite  FROM member_bin";
                                    $sql2="$sql1";
                                    //echo $sql2;
																		$libsitedb=tmq_dump("library_site","code","name");
                                    $result=tmqp( $sql2,"media_type.php?");

                                ?>
         <table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "1" cellpadding = "3">
             <tr bgcolor = "#006699">
                 <td width = "2%">
                     <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                 <td align=center>
                     <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("สาขาห้องสมุด::l::Library Site");; ?></font></b></font></td>
                 <td width = "100"  align=center>
                     <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("จำนวนสมาชิก::l::Member count"); ?></font></b></font></td>
                 <td width = "100" align=center>
                     <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ลบ::l::Delete"); ?></font></b></font></td>
             </tr>
                                <?php 
                                    $i=1;
                                    while ($row=tmq_fetch_array($result))
                                        {
                                        $ID = $row[libsite];
                                        $name=getlang($libsitedb[$row[libsite]]);
																				if ($name=="") {
																					 $name="[EMPTY]";
																				}
                                        $ittt=($startrow) + $i;
                                        if ($i % 2 == 0)
                                            {
                                            echo "<tr valign=top bgcolor=#ffffff height=2>";
                                            }
                                        else
                                            {
                                            echo "<tr bgcolor=#F2F2F2 height=2 valign=top>";
                                            }
                                        echo "<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
                                        echo "<td><font face='MS Sans Serif' size=2 color=#003366>
<B>$name</B>  ";
echo "</font></a></td>";
echo "<td align=center>";
$memnum= number_format(tmq_num_rows(tmq("select * from member_bin where libsite='$row[libsite]' ")));
echo $memnum;
echo "</td>";

                                        $i2=$i2 + 1;
                                        //การดูสื่อประกอล
                                        //echo "</td>";
                                        //echo "<td width=1% width=2 > <nobr><font size=1>$issn</nobr></td>";

                                        echo "<td align=center>";
										if ($memnum!=0) {
                                            echo "<font face='MS Sans Serif' size=2>
<a href='man_del.php?ID=$ID&issave=yes' onclick='return confirm(\" $cfrm\") && confirm(\"".getlang("กรุณายืนยันอีกครั้ง หากต้องการลบอดีตสมาชิกทั้งหมด $memnum คน ในสาขาห้องสมุดนี้::l::Please confirm to delete deleted $memnum member in this library campus")."\")'><B>".getlang("ลบ::l::Delete")."</B></a>";
										} else {
											echo "-";
										}
                                        echo "</td>";

                                     echo "</tr>";
                                        $i++;
                                        $s=$i - 1;
                                        }

//echo $_pagesplit_btn_var;

                                ?>
                                                </table>
                                                
					<?php 
					foot();
					?>