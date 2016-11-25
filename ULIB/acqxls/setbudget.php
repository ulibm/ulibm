<?php 
include("./cfg.inc.php");
include("./head.php");

if ($MergeXTodefroom=="yes") {
	$roomlist=tmq_dump2("room","id","id");
	//printr($roomlist);
	$slimit=" (1 ";
	while (list($k,$v)=each($roomlist)) {
		$slimit.=" and room<>'$v' ";
	}
	$slimit.= " ) or isnull(room) ";

	$defroom=tmq("select * from room where editable='NO'; ");
	$defroom=tmq_fetch_array($defroom);
	$sexec="update member set room='$defroom[id]' where $slimit ";
	tmq( $sexec );
} 

?><BR>
                                <?php 
                                    $sql1="SELECT *  FROM acqn";
                                    $sql2="$sql1 order by name ";
                                    //echo $sql2;
                                    $result=tmqp( $sql2,"media_type.php?");

                                ?>

<table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "1" cellpadding = "3" class=table_border>
	<tr bgcolor = "#006699">
		<td width = "2%">
			<font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
		<td align=center>
			<font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2">ชื่อชุดการสั่งซื้อ</font></b></font></td>
		<td width = "100" align=center>
			<font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("จำนวนรายการ::l::record count"); ?></font></b></font></td>
		<td width = "100" align=center>
			<font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("กำหนดงบประมาณ::l::Set budget"); ?></font></b></font></td>
	</tr>
<?php 
                                    $i=1;
                                    while ($row=tmq_fetch_array($result))
                                        {
                                        $ID = $row[id];
                                        $name=$row[name];
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
$memnum= number_format(tmq_num_rows(tmq("select * from acqn_sub where pid='$row[id]' ")));
echo $memnum;
echo "</td>";

                                        $i2=$i2 + 1;
                                        //การดูสื่อประกอล
                                        //echo "</td>";
                                        //echo "<td width=1% width=2 > <nobr><font size=1>$issn</nobr></td>";

                                        echo "<td align=center>";
										if ($memnum!=0) {
											echo "<A HREF=\"setbudget_action.php?ID=$ID\"><B>".getlang("กำหนดงบประมาณ::l::Set budget")."</B></A>";
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


					foot();
					?>