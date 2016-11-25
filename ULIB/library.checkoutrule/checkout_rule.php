<?php 
;
include("../inc/config.inc.php");
head();
$_REQPERM="checkoutrule";
$tmp=mn_lib();
					echo "<form method=post action='checkout_ruleAction.php'>";

?>
<script>
function localstatchk(wh) {
   tmp=getobj("iseok"+wh);
   if (tmp.checked==true) {
      tmpstyle="1";
   } else {
      tmpstyle="0.2";
   }
   tmp=getobj("trrow"+wh+"_1");
   tmp.style.opacity=tmpstyle;
   tmp=getobj("trrow"+wh+"_2");
   tmp.style.opacity=tmpstyle;
   tmp=getobj("trrow"+wh+"_3");
   tmp.style.opacity=tmpstyle;
   tmp=getobj("trrow"+wh+"_4");
   tmp.style.opacity=tmpstyle;
   console.log(wh+tmpstyle+" "+"trrow"+wh+"_1");
}
</script>
<table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">
 <tr valign = "top">
     <td>
         <table width = "100%" border = "0" cellspacing = "1" cellpadding = "3">

             <tr align = "center">
                 <td colspan = "3">
                     <div align = "left">
                         <font size = "2" face = "MS Sans Serif, MS Sans Serif">
                         <?php 
	$sql1="SELECT *  FROM media_type where code='$choosedmat' ";
	$sql2="$sql1 order by name";
	//echo $sql2;
	echo "<br>";
	$result=tmqp( $sql2,"checkout_rule.php?keyword=$keyword");

									$i=1;
                                    while ($row=tmq_fetch_array($result))
                                        {
                                        $ID=$row[code];
                                        $name=$row[name];
                                        $ittt=(($startrow) ) + $i;
                                                ?>
                                            </div>
                                            <table width = "440" align=center border = "0" cellspacing = "1" cellpadding = "3">
                                                <tr bgcolor = "#006699">
                                                    <td>
                                                        <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("รหัส::l::Code"); ?></font></b></font></td>
                                                    <td bgcolor=white>
                                                     <b><?php  echo getlang($ID); ?></font></b></font></td>
                                                </tr>
                                                <tr bgcolor = "#006699">
                                                    <td width = 30%>
                                                        <font color = "#FFFFFF"><b><font face = "MS Sans Serif" width = 20% size = "2"><?php  echo getlang("ชื่อ::l::Name"); ?></td>
                                                    <td bgcolor=white>
                                                     <b><?php  echo getlang($name); ?></font></b></font></td>
                                                </tr>
                                                <tr bgcolor = "#006699">
                                                    <td width = "13%" colspan = 10>
                                                        <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ตั้งค่า::l::Setting"); ?></font></b></font></td>
                                                </tr>
                                <?php 
                                        if ($i % 2 == 0) { echo "<tr valign=top bgcolor=#e3e3e3 height=2>"; }
                                        else { echo "<tr bgcolor=#F2F2F2 height=2 valign=top>"; }
                                        echo "<input size=10 type=hidden name='MDTYPE' value='$ID'>";

                                        echo "<td colspan=2><table border=1 width=450>";
                                        $i2=$i2 + 1;
                                        //การดูสื่อประกอล
                                        $sql56="select * from member_type";
                                        $result56=tmq( $sql56);
                                        $Num56=tmq_num_rows($result56);
                                        while ($row56=tmq_fetch_array($result56))
                                            {
                                            $hdescr=$row56[descr];
                                            $hid=$row56[type];
                                            $sql69="select * from checkout_rule where member_type='$hid' and media_type='$ID'  and libsite='$managing'";
                                            //echo $sql69;  
                                            $result69=tmq( $sql69);
                                            $row69=tmq_fetch_array($result69);
                                            $cday=$row69[day];
                                            $ccancheckout=$row69[cancheckout];
                                            $cfine=$row69[fine];
                                            $cfee=$row69[fee];
                                            $crenew=$row69[renew];
echo "<tr><td colspan=2 bgcolor=ffffff> ".html_membertype_icon($hid,18)." <B>";
											echo getlang($hdescr);
											echo "</B></td></tr>";
											echo "<tr><td class=table_td>";
											echo "<nobr>".getlang("ยืมออก::l::Checkout")." </td><td class=table_td>";
if ($ccancheckout=="yes") {
	echo "	<label><INPUT TYPE=radio NAME='CHECKOUT_$hid' value='yes' checked style='border:0' ID='iseok$row56[id]' onclick='localstatchk($row56[id]);'>".getlang("ได้::l::Yes")."</label>
	<label><INPUT TYPE=radio NAME='CHECKOUT_$hid' value='no' style='border:0' ID='isenok$row56[id]' onclick='localstatchk($row56[id]);'>".getlang("ไม่ได้::l::No")."</label> ";
} else {
	echo "	<label><INPUT TYPE=radio NAME='CHECKOUT_$hid' value='yes' style='border:0' ID='iseok$row56[id]' onclick='localstatchk($row56[id]);'>".getlang("ได้::l::Yes")."</label>
	<label><INPUT TYPE=radio NAME='CHECKOUT_$hid' value='no' checked style='border:0'  ID='isenok$row56[id]' onclick='localstatchk($row56[id]);'>".getlang("ไม่ได้::l::No")."</label> ";
}
echo "</nobr></td></tr>";
											echo "<tr  ID='trrow$row56[id]_1'><td class=table_td>";
											echo getlang("ค่าปรับ::l::Fine");
                      echo "</td><td class=table_td> <input type=text name='FINE_$hid' 
											value='$cfine' size=10>";
											echo "</td></tr>";
											echo "<tr ID='trrow$row56[id]_2'><td class=table_td>";
											echo getlang("วันยืมออกได้::l::Day")." </td><td class=table_td><input type=text name='DAY_$hid' value='$cday' size=10>";
											echo " *</td></tr>";
											echo "<tr ID='trrow$row56[id]_3'><td class=table_td>";
											echo getlang("ค่าบริการ::l::Fee");
                                            echo "</td><td class=table_td> <input type=text name='FEE_$hid' 
											value='$cfee' size=10>";
											echo "</td></tr>";
											echo "<tr  ID='trrow$row56[id]_4'><td class=table_td>";
											echo getlang("จำนวนครั้งที่ยืมต่อได้::l::Renewable count");
                                            echo "</td><td class=table_td> <input type=text name='RENEW_$hid' 
											value='$crenew' size=10>";
											echo "</td></tr>";
?><script>localstatchk(<?php echo $row56[id]; ?>); //xxx
</script><?php
                                            }
                                        echo "</table><td>";
                                        echo "</td>";
                                        echo "</tr>";
						echo "<tr><td colspan=3 align=center>";
						echo "<input type=submit value='".getlang("ตกลง::l::Submit")."'>
						<input type=hidden name=managing value='$managing'>
						";
							?><a href="media_type.php"><?php  echo getlang("กลับ::l::Back"); ?></a><?php 
						echo "</td></tr>";
                                        $i++;
                                        $s=$i - 1;

                                        }
//	echo $_pagesplit_btn_var;	
                                ?>
                                            </table>

                                            <?php 
                                                ?>
												<center><label style="color:darkred"> <input type="checkbox" name="setforallresource" value="yes"><?php  echo getlang("ตั้งให้กับทุกประเภททรัพยากรเหมือนกันหมด (สำหรับสาขา ::l::Set this rule for all resource type (for campus ");
												echo get_libsite_name($managing).")";
												?></label></center><br><br>
                                        </td>
                                    </tr>
                                </table>* <?php  echo getlang("จำนวนวันที่ยืม รวมวันที่ทำการยืม ดังนั้นต้องระบุมากกว่า 2 ::l:: Checkout date include checkout day, please enter 2+");?>
																<br /><?php  echo getlang("ตัวอย่าง หากต้องการให้ยืมได้ 3 วัน ต้องกรอก 4::l::Example, allow checkout 3 day , should enter 4 ");?>
                                </form>
                            </td>
                        </tr>
                    </table>
					<?php 
                                        echo "</form>";
														foot();
													?>