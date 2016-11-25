<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	$tmp=mn_lib();

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

?><BR><?php 
pagesection("$tmp");

?>
    <CENTER><?php  echo getlang("ส่วนนี้จัดการเฉพาะค่าค่าง ๆ ของสมาชิก หากต้องการเพิ่ม/ลบ หรือแก้ไขรายชื่อ$_ROOMWORD กรุณาไปจัดการที่ <B>รายชื่อ$_ROOMWORD</B> ที่เมนูหลัก::l::This module use to change information about member , if need to edit/delete $_ROOMWORD<BR>  Please go to  <B>$_ROOMWORD List</B> at mainmenu"); ?>
	 <BR><BR><?php  echo getlang("<B>*สำหรับการเลื่อนชั้น</B> แนะนำให้ใช้วิธีแก้ไขชื่อห้องเอา::l::For change grade or expiration of member in $_ROOMWORD please rename $_ROOMWORD instead of change one-by-one."); ?>
</CENTER>



                                                <table width = "<?php  echo $_TBWIDTH?>" align=center border = "0" cellspacing = "1" cellpadding = "3" class=table_border>
                                                    <tr bgcolor = "#006699">
                                                        <td width = "2%">
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                                                        <td align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo $_ROOMWORD; ?></font></b></font></td>
                                                        <td width = "100" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("จำนวนสมาชิก::l::Member count"); ?></font></b></font></td>
                                                        <td width = "100" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("วันหมดอายุสมาชิก::l::Expire date"); ?></font></b></font></td>
                                                        <td width = "100" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("รวมห้อง::l::Merge $_ROOMWORD"); ?></font></b></font></td>
                                                        <td width = "100" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ลบ::l::Delete"); ?></font></b></font></td>
                                                        <td width = "200" align=center>
                                                            <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ส่งออก::l::Export"); ?></font></b></font></td>
                                                    </tr>
               
                                   <?php 
                                    $sql1="SELECT *  FROM room";
                                    $sql2="$sql1 order by pid,name ";
                                    //echo $sql2;
                                    $result=tmqp( $sql2,"media_type.php?");

                                ?>
                                
                                                             <?php 
                                    $i=1;
                                    while ($row=tmq_fetch_array($result))
                                        {
                                        $ID = $row[id];
                                        $name=$row[name];
                                        $ittt=($startrow) + $i;

                                            echo "<tr valign=top bgcolor=#ffffff height=2  class=table_dr>";
                                            
                                        echo "<td class=table_td><font face='MS Sans Serif' size=2>$ittt</font></td>";
                                        echo "<td class=table_td><font face='MS Sans Serif' size=2 color=#003366>
  ";
echo get_room_name($row[id]);
echo "</font></a></td>";
echo "<td align=center class=table_td>";
$memnum= number_format(tmq_num_rows(tmq("select * from member where room='$row[id]' ")));
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
<a href='man_del.php?ID=$ID&issave=yes' onclick='return confirm(\" $cfrm\") && confirm(\"".getlang("กรุณายืนยันอีกครั้ง หากต้องการลบสมาชิกทั้งหมด $memnum คน ใน$_ROOMWORD"."นี้::l::Please confirm to delete $memnum member in this $_ROOMWORD")."\")'><B>".getlang("ลบ::l::Delete")."</B></a>";
										} else {
											echo "-";
										}
                                        echo "</td>";
                                        echo "<td align=center class=table_td>";
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
$s.= " ) or isnull(room) or room not in (select id from room)";
	$s2=tmq($s,false);
	?><CENTER><?php 
	if (tmq_num_rows($s2)!=0) {
		$s2=number_format(tmq_num_rows($s2));
		echo getlang("มีสมาชิกที่ไม่มีห้องจำนวน: $s2::l::Member with no room:$s2");
		echo " &nbsp; <A HREF='media_type.php?MergeXTodefroom=yes'>".getlang("จัดไว้ห้อง Default::l::Set to Default room")."</A>";
	}
?></CENTER><BR><?php 
	?><CENTER><?php 
   $s=tmq("select * from room ");
   while ($r=tfa($s)) {
      $chk=tmq("select distinct concat(dat,'-',mon,'-',yea) as edata, count(UserAdminID) as cc from member where room='$r[id]' group by concat(dat,'-',mon,'-',yea)");
      $chkcc=tmq_num_rows($chk);
      $chkr=tfa($chk);
      if ($chkcc==1 && $chkr[cc]>0) {
               $r[name]=getlang($r[name]);
         $dat=explode("-",$chkr[edata]);
         //printr($chkr);
         if ($chkr[edata]=="0-0-0") continue;
         if (trim($chkr[edata])=="") continue;
         $dat2=ymd_mkdt($dat[0],$dat[1],$dat[2]-543); 


         if ($dat2<time()) {
            echo "<font color=darkred>".getlang("สมาชิกทุกคนในห้อง $r[name] ($chkr[cc] คน) หมดอายุสมาชิกแล้ว::l::All member in $r[name] ($chkr[cc]) expired") . " ".ymd_datestr($dat2,'shortd');
                  echo "</font><BR>";
         } elseif ($dat2<(time()+(60*60*24*30))) {
            echo getlang("สมาชิกทุกคนในห้อง $r[name] ($chkr[cc] คน) จะหมดอายุสมาชิกใน 1 เดือน::l::All member in $r[name] ($chkr[cc]) will expired in 1 month"). " ".ymd_datestr($dat2,'shortd');
              echo "<BR>";
         }
      }

   }
?></CENTER><?php 


					foot();
					?>