<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
?><BR><BR>
                    <table width = "780"  align=center border = "0" cellspacing = "0" cellpadding = "0" class=table_border>

                        <tr valign = "top">
                            <td>
                               

                                <form name = "form1" action = "media_type.php" method = "post">
                                    <table width = "780" border = "0" cellspacing = "1" cellpadding = "3">

                                        <tr align = "center">
                                            <td colspan = "3">
                                                <div align = "left">
                                                    <font size = "2" face = "MS Sans Serif, Microsoft Sans Serif">
                                <?php 
                                    $sql1="SELECT distinct LIBSITE  FROM media";
                                    $sql2="$sql1";
                                    //echo $sql2;
																		$libsitedb=tmq_dump("library_site","code","name");
                                    $result=tmqp( $sql2,"media_type.php?");

                                ?>
                                                </div>
                                                <table width = "770" align=center border = "0" cellspacing = "1" cellpadding = "3">
                                                    <tr bgcolor = "#006699">
                                                        <td width = "2%">
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                                                        <td align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo $_ROOMWORD; ?></font></b></font></td>
                                                        <td width = "100"  align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("จำนวน Bib::l::Bib count"); ?></font></b></font></td>
                                                        <td width = "100" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("รวมสาขา::l::Merge Campus"); ?></font></b></font></td>

                                                    </tr>
                                <?php 
                                    $i=1;
                                    while ($row=tmq_fetch_array($result))
                                        {
                                        $ID = $row[LIBSITE];
                                        $name=getlang($libsitedb[$row[LIBSITE]]);
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
$memnum= number_format(tmq_num_rows(tmq("select * from media where LIBSITE='$row[LIBSITE]' ")));
echo $memnum;
echo "</td>";

                                        $i2=$i2 + 1;
                                        //การดูสื่อประกอล
                                        //echo "</td>";
                                        //echo "<td width=1% width=2 > <nobr><font size=1>$issn</nobr></td>";

                                        echo "<td align=center>";
										if ($memnum!=0) {
											echo "<A HREF=\"man_merge.php?ID=$ID\"><B>".getlang("รวม::l::Merge")."</B></A>";
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
                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table>
					<?php 
					foot();
					?>