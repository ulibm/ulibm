<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);
$kw=trim($kw);
?>
<center><form method="post" action="<?php  echo $PHP_SELF?>">
	<?php  echo getlang("ค้นหา ด้วยบาร์โค้ดหรือชื่อสมาชิก::l::Search by barcode or name"); ?> <input type="text" name="kw" value="<?php  echo $kw; ?>"> <input type="submit" value="<?php  echo getlang("ค้นหา::l::Search");?>">
</form>
<?php 
if ($kw!="") {
	$kw=addslashes($kw);
	$s=tmq("select * from member where UserAdminID='$kw' or UserAdminName like '$kw' ");
	if (tnr($s)==0) {
		html_dialog(getlang("ไม่พบ::l::Not found"),"member not found ($kw)");
	}
	while ($r=tfa($s)) {
		$copy=tmq("SELECT *  FROM checkout where hold ='$r[UserAdminID]' and allow='yes' and returned='no' ");
		$copy=tmq_num_rows($copy);
		$copy2=tmq("SELECT *  FROM useinsidelib where memid ='$r[UserAdminID]'  ");
		$copy2=tmq_num_rows($copy2);
		$copycount=floor($copy+$copy2);

		$fines=tmq("SELECT * FROM fine where memberId='$r[UserAdminID]' and isdone='no' ");
		//$fines=tmq_num_rows(($fines));
			$finecount=0;
			while ($rqcountr=tmq_fetch_array($fines)) {
				$finecount=$finecount+floor($rqcountr[fine]);
			}

		if ($copycount==0&&$finecount==0) {
			echo "<center><b><h1 style='color: darkgreen;'>".get_member_name($r[UserAdminID])." ไม่มีทรัพยากรค้างส่งหรือค่าปรับ</h1></b></center>";
		} else {
			echo "<center><b><h1 style='color: red;'>".get_member_name($r[UserAdminID])." ไม่ผ่านการตรวจสอบจบ<br>มีค่าปรับ $finecount บาท , ค้างทรัพยากร $copycount เล่ม</h1></b></center>";
			//echo ",";
		}

		member_showlonginfo($r[UserAdminID]);
		member_showhold($r[UserAdminID]);
		member_showfine($r[UserAdminID]);
		?><?php 
	}
}
?></center>
                                <?php 
                                    $sql1="SELECT *  FROM room";
                                    $sql2="$sql1 order by pid,name ";
                                    //echo $sql2;
                                    $result=tmqp( $sql2,"media_type.php?");

                                ?>

                                                <table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "1" cellpadding = "3">
                                                    <tr bgcolor = "#006699">
                                                        <td width = "2%">
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                                                        <td align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo $_ROOMWORD; ?></font></b></font></td>
                                                        <td width = "100" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("จำนวนสมาชิก::l::Member count"); ?></font></b></font></td>
                                                            <td width = "200" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ส่งออก::l::Export"); ?></font></b></font></td>
                                                    </tr>
                                <?php 
                                    $i=1;
                                    while ($row=tmq_fetch_array($result))
                                        {
                                        $ID = $row[id];
                                        $name=get_room_name($row[id]);//$row[name];
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
                                        //       echo"<td><font face='MS Sans Serif' size=2 color=#003366>$ID </font></a></td>";
                                        echo "<td><font face='MS Sans Serif' size=2 color=#003366>
<B>$name</B>  ";
echo "</font></a></td>";
echo "<td align=center>";
$memnum= number_format(tmq_num_rows(tmq("select * from member where room='$row[id]' ")));
echo $memnum;
echo "</td>";

                                        $i2=$i2 + 1;
                                        //การดูสื่อประกอล
                                        //echo "</td>";
                                        //echo "<td width=1% width=2 > <nobr><font size=1>$issn</nobr></td>";
                                      
                                        echo "<td align=center>";
										if ($memnum!=0) {
											$rand1=randid();
											$rand2=randid();
                                            echo "<A HREF='export.php?roomid=$row[id]&mode=all&$rand1' class='a_btn smaller2' target=_blank>ทั้งหมด</A> <A HREF='export.php?roomid=$row[id]&mode=report&$rand2' class='a_btn smaller2' target=_blank>สมาชิกที่มีปัญหา</A>";
										} else {
											echo "-";
										}
                                        echo "</td>";
                                        echo "</tr>";
                                        $i++;
                                        $s=$i - 1;
                                        }

echo $_pagesplit_btn_var;

                                ?>
                                                </table>
					<?php 

$roomlist=tmq_dump2("room","id","id");
//printr($roomlist);
@reset($roomlist);
$s="select * from member where ( 1 ";
while (list($k,$v)=each($roomlist)) {
	$s.=" and room<>'$v' ";
}
$s.= " ) or isnull(room) ";
	$s2=tmq($s,false);
	?><CENTER><?php 
	if (tmq_num_rows($s2)!=0) {
		$s2=number_format(tmq_num_rows($s2));
		echo getlang("มีสมาชิกที่ไม่มีห้องจำนวน: $s2::l::Member with no room:$s2");
		echo " &nbsp; <A HREF='media_type.php?MergeXTodefroom=yes'>".getlang("จัดไว้ห้อง Default::l::Set to Default room")."</A>";
	}
?></CENTER><?php 

					foot();
					?>