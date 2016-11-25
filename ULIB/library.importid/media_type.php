<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();

	 $itemlocatetag=getval("MARC","itemlocatetag");

	if ($clearitem!="") {
		tmq("update media set $itemlocatetag='' where importid='$clearitem' ");
	}
	if ($setpublish!="") {
		tmq("update media set ispublish='yes' where importid='$setpublish' ");
		tmq("update index_db set ispublish='yes' where importid='$setpublish' ");
	}
	if ($setunpublish!="") {
		tmq("update media set ispublish='no' where importid='$setunpublish' ");
		tmq("update index_db set ispublish='no' where importid='$setunpublish' ");
	}
?>
  <table width="780" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td>
        <form name="form1" action="media_type.php" method="post" >
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr align="center">
              <td colspan="3"> 
                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 
Serif">
<?php 
	// หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT distinct importid, count(id) as cc FROM media  group by importid"; 
	$sql2 = "$sql1 order by id desc ";
//echo $sql2;
	$result = tmqp($sql2,"media_type.php?");
	$NRow = tmq_num_rows($result);
							
?> </div>
<BR><TABLE width=770 align=center>
                <TR>
                	<TD><A HREF="merge.php" class=a_btn><?php  echo getlang("รวมรายการย่อย ๆ เข้าด้วยกัน::l::Merge Small Import ID"); ?></A></TD>
                </TR>
                </TABLE>
                <table width="780" align=center border="0" cellspacing="1" cellpadding="3" class=table_border>
                  <tr bgcolor="#006699"> 
                    <td width="2%" class=table_head><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></td>
                    <td class=table_head><?php  echo getlang("หมายเลขการนำเข้า::l::Import ID"); ?></td>
 <td width=20%  class=table_head><?php  echo getlang("จำนวนรายการ::l::Count records"); ?></td> 
                    <td width="13%" class=table_head><?php  echo getlang("ลบ::l::Delete"); ?></td>
                    <td width="13%" class=table_head><?php  echo getlang("นำเข้า Item::l::Import Items"); ?></td>
                  </tr>
                  <?php 
         $i=1; 
				 $count=0;
         while($row = tmq_fetch_array($result)){
			$ID = $row[id];
			$name=$row[name];
			$ittt = (($startrow))+$i;
			echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";

			$importid=$row[importid];
			if ($importid=="") {
				$importid="[EMPTY]";
			}
            echo"<td  class=table_td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td  class=table_td><font face='MS Sans Serif' size=2 color=#003366>$importid  </font></a></td>";
            $i2 = $i2 +1;  
$count+=$row[cc];
 echo"<td  class=table_td  align=center>".number_format($row[cc])."</td><td  class=table_td align=center>";
		//if ($row[importid]!='none') {
			echo " <nobr><A HREF='delMedia_type.php?ID=$importid' onclick='return confirm(\" $cfrm\") && confirm(\" $cfrm\")' style='color:red'>".getlang("ลบข้อมูลชุดนี้::l::Delete this ImportID")."</A>";
		//} else {
		//	echo "&nbsp;";
		//}
		echo "</td><td  class=table_td align=center>";
		  $chk945 =tmq("SELECT ID FROM media where importid='$importid' and length($itemlocatetag)>5  ",false); 
		if ($row[importid]!='none' && tmq_num_rows($chk945)!=0) {
			echo "[".tmq_num_rows($chk945)."]<BR>";
			echo " <nobr><A HREF='extractitem_pre.php?ID=$importid' style='color:darkgreen' class=smaller>".getlang("นำเข้า Item::l::Import Items")."</A></nobr>";
			echo " <nobr><A HREF='media_type.php?clearitem=$importid' style='color:darkred' class=smaller>".getlang("ลบข้อมูล Item::l::Delete Items info")."</A></nobr>";
		} else {
			echo "&nbsp;";
		}
		echo " <nobr><A HREF='media_type.php?setpublish=$importid' style='color:darkgreen' class=smaller>".getlang("เผยแพร่::l::Publish")."</A></nobr>";
		echo " <nobr><A HREF='media_type.php?setunpublish=$importid' style='color:darkred' class=smaller>".getlang("ไม่เผยแพร่::l::Not Publish")."</A></nobr>";
		echo " <nobr><A HREF='setcollection.php?importid=$importid' style='color:darkblue' class=smaller>".getlang("Collection")."</A></nobr>";
		echo "</td>";
		echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
			echo $_pagesplit_btn_var;
 ?>
</table><BR><BR>
              </td>
            </tr>
          </table>
<CENTER>**  <?php  echo getlang("none หรือ [EMPTY] หมายถึง ชุดข้อมูลที่ได้จากการคีย์ด้วยมือ::l::none or [EMPTY] is records you key mannually"); ?><br />
<?php  echo getlang("จำนวน Bib. ในฐานข้อมูลคือ ::l::Number of Bib. in database is ");
echo number_format($count);
echo getlang(" รายการ::l:: records");
echo "<br />";
echo getlang("* การลบข้อมูลจำนวนมากอาจต้องใช้เวลาประมวลผลนาน::l:: * deleting huge number of records might take long time.");
?>
</CENTER>
        </form>
      </td>
    </tr>
  </table>
  <?php 
		foot();   
	   ?>