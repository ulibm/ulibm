<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	$tmp=mn_lib();
	
?><BR>
                                <?php 
                                pagesection("$tmp");
                                    $sql1="SELECT distinct type  FROM member";
                                    $sql2="$sql1";
                                    //echo $sql2;
																		$libsitedb=tmq_dump("member_type","type","descr");
                                    $result=tmqp( $sql2,"media_type.php?");

                                ?>
                                                <table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "1" cellpadding = "3"  class=table_border>
                                                    <tr bgcolor = "#006699">
                                                        <td width = "2%">
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                                                        <td align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ประเภทสมาชิก::l::Member Type");; ?></font></b></font></td>
                                                        <td width = "100"  align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("จำนวนสมาชิก::l::Member count"); ?></font></b></font></td>
                                         <td width = "100" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("วันหมดอายุสมาชิก::l::Expire date"); ?></font></b></font></td>
                                                        <td width = "100" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("รวมประเภท::l::Merge Campus"); ?></font></b></font></td>
                                                        <td width = "100" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ลบ::l::Delete"); ?></font></b></font></td>
                                                        <td width = "200" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ส่งออก::l::Export"); ?></font></b></font></td>
                                                    </tr>
                                <?php 
                                    $i=1;
                                    while ($row=tmq_fetch_array($result))
                                        {
                                        $ID = $row[type];
                                        $name=getlang($libsitedb[$row[type]]);
																				if ($name=="") {
																					 $name="[EMPTY]";
																				}
                                        $ittt=($startrow) + $i;

                                            echo "<tr bgcolor=#ffffff class=table_dr height=2 valign=top>";
                                            
                                        echo "<td class=table_td><font face='MS Sans Serif' size=2>$ittt</font></td>";
                                        echo "<td class=table_td><font face='MS Sans Serif' size=2 color=#003366>
<B>$name</B>  ";
echo "</font></a></td>";
echo "<td align=center class=table_td>";
$memnum= number_format(tmq_num_rows(tmq("select * from member where type='$row[type]' ")));
echo $memnum;
echo "</td>";

                                        $i2=$i2 + 1;
                                        //การดูสื่อประกอล
                                        //echo "</td>";
                                        //echo "<td width=1% width=2 > <nobr><font size=1>$issn</nobr></td>";
echo "<td align=center class=table_td>";
										if ($memnum!=0) {
											echo "<A HREF=\"man_expire.php?ID=$ID\"><B>".getlang("จัดการ::l::Manage")."</B></A>";
										} else {
											echo "-";
										}
										echo "</td>";
                                        echo "<td align=center class=table_td>";
										if ($memnum!=0) {
											echo "<A HREF=\"man_merge.php?ID=$ID\"><B>".getlang("รวม::l::Merge")."</B></A>";
										} else {
											echo "-";
										}
										echo "</td>";
                                        echo "<td align=center class=table_td>";
										if ($memnum!=0) {
                                            echo "<font face='MS Sans Serif' size=2>
<a href='man_del.php?ID=$ID&issave=yes' onclick='return confirm(\" $cfrm\") && confirm(\"".getlang("กรุณายืนยันอีกครั้ง หากต้องการลบสมาชิกทั้งหมด $memnum คน ในประเภทสมาชิกห้องสมุดนี้::l::Please confirm to delete $memnum member in this type")."\")'><B>".getlang("ลบ::l::Delete")."</B></a>";
										} else {
											echo "-";
										}
                                        echo "</td>";

                                        echo "<td align=center class=table_td>";
										if ($memnum!=0) {
											$rand1=randid();
											$rand2=randid();
                                            echo "<A HREF='../library.mmanbyroom/export.php?typid=$row[type]&mode=all&$rand1' class='a_btn smaller2' target=_blank>ทั้งหมด</A> 
											<A HREF='../library.mmanbyroom/export.php?typid=$row[type]&mode=report&$rand2' class='a_btn smaller2' target=_blank>สมาชิกที่มีปัญหา</A>";
										} else {
											echo "-";
										}
                                        echo "</td>";                                        echo "</tr>";
                                        $i++;
                                        $s=$i - 1;
                                        }

//echo $_pagesplit_btn_var;

                                ?>
                                                </table>
                                                
					<?php 
               ?><CENTER><?php 
   $s=tmq("select * from member_type ");
   while ($r=tfa($s)) {
      $chk=tmq("select distinct concat(dat,'-',mon,'-',yea) as edata, count(UserAdminID) as cc from member where type='$r[type]' group by concat(dat,'-',mon,'-',yea)");
      $chkcc=tmq_num_rows($chk);
      $chkr=tfa($chk);
      if ($chkcc==1 && $chkr[cc]>0) {
         $dat=explode("-",$chkr[edata]);
         //printr($chkr);
         $r[descr]=getlang($r[descr]);
         if ($chkr[edata]=="0-0-0") continue;
         if (trim($chkr[edata])=="") continue;
         $dat2=ymd_mkdt($dat[0],$dat[1],$dat[2]-543); 


         if ($dat2<time()) {
            echo "<font color=darkred>".getlang("สมาชิกทุกคนใน $r[descr] ($chkr[cc] คน) หมดอายุสมาชิกแล้ว::l::All member in $r[descr] ($chkr[cc]) expired") . " ".ymd_datestr($dat2,'shortd');
                  echo "</font><BR>";
         } elseif ($dat2<(time()+(60*60*24*30))) {
            echo getlang("สมาชิกทุกคนใน $r[descr] ($chkr[cc] คน) จะหมดอายุสมาชิกใน 1 เดือน::l::All member in $r[descr] ($chkr[cc]) will expired in 1 month"). " ".ymd_datestr($dat2,'shortd');
              echo "<BR>";
         }
      }

   }
?></CENTER><?php 
					foot();
					?>