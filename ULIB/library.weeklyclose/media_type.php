<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
?><BR>
  <table width="780" align=center border="0" cellspacing="0" cellpadding="0" >
    <tr valign="top"> 
      <td><A HREF="addMedia_type.php" class=a_btn><?php  echo getlang("เพิ่มวันหยุด::l::Add weekly close"); ?></A>

<?php 
  $sql1 ="SELECT * FROM weeklyclose  order by dat"; 

	$sql2 = "$sql1 ";
	$result = tmq($sql2);
	if (tmq_num_rows($result)!=0) {
?> 
                <table width="780" border="0" cellspacing="1" cellpadding="3"   class=table_border>
                  <tr bgcolor="#006699"> 
                    <td width="2%" class=table_head><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></td>
                    <td  class=table_head><?php  echo getlang("วัน::l::Day"); ?></td>
                    <td width="13%"  class=table_head><?php  echo getlang("ลบ::l::Delete"); ?></td>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];
               $name=$row[name];
$ittt = (($startrow0))+$i;
          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";
 
            echo"<td  class=table_td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td  class=table_td><font face='MS Sans Serif' size=2 color=#003366> " .$thaidaystr["$row[dat]"] ." </font></a></td>";
            $i2 = $i2 +1;  
	echo " <TD align=center  class=table_td><A HREF='delMedia_type.php?ID=$row[id]' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</A>";
	echo " </td>";
           echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
 ?>
                </table>
<?php  
	}
else {
       echo "<center><br><br><hr width='100%' size='1' color=red><font size=+2 face='MS Sans Serif'>Sorry, no results were found</font><br><br></center>\n";
 }
?>
      </td>
    </tr>
  </table>
  <?php foot();?>