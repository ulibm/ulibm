<?php 
function member_showrequest($useradminid2) {
   global $member_showrequest_isreadypickup;
	global $thaimonstr;
	global $isatcirculation;
	global $_TBWIDTH;
                                ///////////////////////////////////////////รายการจอง
                                //echo "รายการจอง";
                                $sql="select * from checkout where request='$useradminid2'";
                                $result=tmq($sql);
                                $Num=tmq_num_rows($result);
?><BR><?php 
								pagesection("รายการจอง::l::Request item.","narrow");

                                $count=1; 
                                echo "<table cellpadding=1 cellspacing=0 width='$_TBWIDTH' align=center border=1 class=table_border><tr bgcolor=f2f2f2>
<td align=center class=table_head>".getlang("ลำดับที่::l::No.")."</td>
<td align=center class=table_head>".getlang("Barcode")."</td>
<td align=center class=table_head>".getlang("ชื่อเรื่อง::l::Title")."</td>
<td align=center class=table_head>".getlang("วันเดือนปีส่ง::l::Return date")."</td>
<td align=center class=table_head>".getlang("สถานะการจอง::l::Status")."</td>
<td align=center class=table_head>".getlang("ยกเลิก::l::Cancel")."</td></tr>";
                                while ($row2=tmq_fetch_array($result))
                                    {
                                    $media_id = $row2[mediaId];
                                    $Sdat=$row2[edat];
                                    $Smon=$row2[emon];
                                    $Syea=$row2[eyea];
                                    $Sid=$row2[id];
                                    $statint=$row2[returned];
                                    $itemName=dspmarc($row2[mediaName]);
                                    echo "<tr>";
                                    echo "<td class=table_td>$count</td>";
                                    $rowID=$statint;
                                    echo "<td class=table_td> $media_id ";
                                    if ($isatcirculation=="yes") {
                                    	echo "<BR><A class='smaller a_btn' HREF='main.checkout.php?memberbarcode=$useradminid2&mediabarcode=$media_id' target=main>".getlang("คลิกเพื่อยืม::l::Click to use")."</A>";

                                       echo "";
                                    }
                                    echo "</td>";
									$parentid=tmq("select * from media_mid where bcode='$media_id' ");
									$parentid=tmq_fetch_array($parentid);
                                    echo "<td class=table_td> <A HREF='../dublin.php?ID=$parentid[pid]&item=$media_id' target=_blank>$itemName...</A> </td>";

                                    echo "<td class=table_td align=center>$Sdat " . $thaimonstr[$Smon] . " $Syea</td>";
                                    if ($statint == "no")
                                        {
                                        $statint=getlang("ยังไม่พร้อมรับ::l::Not Ready");
                                        }
                                    else
                                        {
                                        $statint=getlang("พร้อมรับแล้ว::l::Ready to pickup");
                                        $member_showrequest_isreadypickup="yes";
                                        }
                                    echo "<td class=table_td  align=center>$statint</td>";
                                    echo "<td class=table_td  align=center>";
                                    if ($rowID == 'no')
                                        {
                                        echo "<a href='removeRequestItem.php?ID=$Sid'>".getlang("ยกเลิกการจอง::l::Cancel")."</a>";
                                        }
                                    else
                                        {
                                        echo "-";
                                        }
                                    echo "</td>";
                                    echo "</tr>";
                                    $count++;
                                    }
                                if ($count == 1)
                                    {
                                    echo "<tr><td align=center colspan=6  class=table_td>".getlang("ไม่มีรายการจอง::l::No request item.")."</td></tr>";
                                    }
                                echo "</table>";
}
?>