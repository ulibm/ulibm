<?php 
function member_showrequestlist($useradminid2,$atcirculation="no") {
	global $dcrURL;
	global $_TBWIDTH;
	global $thaimonstr;
                                ///////////////////////////////////////////รายการจอง
                                //echo "รายการจอง";
                                $sql="select * from request_list where memberid='$useradminid2'";
                                $result=tmq($sql);
                                $Num=tmq_num_rows($result);
?><BR><?php 
								pagesection("รายการขอยืม::l::Request item.","narrow");

                                $count=1; 
                                echo "<table cellpadding=1 cellspacing=0 width='$_TBWIDTH' align=center border=1 class=table_border><tr bgcolor=f2f2f2>
<td align=center class=table_head>".getlang("ลำดับที่::l::No.")."</td>
<td align=center class=table_head>".getlang("ชื่อเรื่อง::l::Title")."</td>
<td align=center class=table_head>".getlang("วันเดือนปีที่จอง::l::Request date")."</td>
<td align=center class=table_head>".getlang("สถานะการจอง::l::Status")."</td>
<td align=center class=table_head>".getlang("ยกเลิก::l::Cancel")."</td></tr>";
                                while ($row2=tmq_fetch_array($result))
                                    {

	$parentid=tmq("select * from media_mid where bcode='$row2[itemid]' ");
	$parentid=tmq_fetch_array($parentid);
                                    $itemName=marc_gettitle($parentid[pid]);
                                    echo "<tr>";
                                    echo "<td class=table_td>$count</td>";;
                                    echo "<td class=table_td><a href='$dcrURL"."dublin.php?ID=$parentid[pid]&item=$row2[itemid]' target=_blank>".substr($itemName,0,40)."...  ($row2[itemid])</td>";

                                    echo "<td class=table_td>" . ymd_datestr($row2[dt],'date') . " </td>";
                                    echo "<td class=table_td align=center>".ucwords($row2[status])."</td>";
                                    echo "<td class=table_td align=center>";
                                    if (loginchk_lib("check")!=true) {
                                        echo "<a href='removeRequestItemlist.php?ID=$row2[itemid]'>".getlang("ยกเลิกการจอง::l::Cancel")."</a>";
                                     }else {
										 if ($atcirculation=="no") {
	                                        echo "-";
										 } else {
											echo "<a href='working.viewmember.php?memberbarcode=$useradminid2&tabmode=requestlist&cancelrequestlist_id=$row2[id]'>".getlang("ยกเลิก::l::Cancel")."</a>";
										 }
                                     }
                                    echo "</td>";
                                    echo "</tr>";
                                    $count++;
                                    }
                                if ($count == 1)
                                    {
                                    echo "<tr><td align=center colspan=6  class=table_td>".getlang("ไม่มีรายการขอยืม::l::No request item.")."</td></tr>";
                                    }
                                echo "</table>";
}
?>