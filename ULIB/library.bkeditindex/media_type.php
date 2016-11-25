<?php 
    ;
	include ("../inc/config.inc.php");
	$_REQPERM="bkeditindex";
	head();
	$tmp=mn_lib();
	pagesection($tmp);
	if ($item!="") {
		include("chstat.php");
	}
?>
  <table width="780" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td>
        <form name="form1" action="media_type.php" method="post" >
          <table width="780" border="0" cellspacing="1" cellpadding="3">
        <tr align="center">
              <td colspan="3"> 
                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 
Serif">
<a href="../library.index_ctrl/"><?php  echo getlang("จัดการชุดข้อมูลการสืบค้น::l::Manage Indexing control"); ?></a>
<?php 

  $sql1 ="SELECT *  FROM bkedit"; 
	$sql2 = "$sql1 order by ordr";
//echo $sql2;
	$result = tmqp($sql2,"media_type.php?");
?> </div>
                <table width="780" border="0" cellspacing="1" cellpadding="3">
                  <tr bgcolor="#006699"> 
                    <td width="2%"><font color="#FFFFFF"><b>
<font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                    <td width=150><nobr><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("ชื่อแท็ก [ชื่อแท็ก] ::l::Tag name [tag name]"); ?></font></b></font></td>
 <td width=30% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
width=20% size="2"><?php  echo getlang("ตัวอย่าง/อธิบาย::l::Example/Description"); ?> </td> 
                    

<?php 
					
					$indexcontrols=tmq("select * from index_ctrl order by id");
					$indexmapping=Array();
					while ($indexcontrolsi=tmq_fetch_array($indexcontrols)) {
						$indexmapping[$indexcontrolsi[fid]]=$indexcontrolsi[name];
					}
//					print_r($marctemplate);
					foreach ($indexmapping as $indexcontrolsi => $indexcontrolsvalue) {
						?><td width="5%" style="border-top-style: solid; border-top-width: 6px; border-top-color: #009900"><nobr><font color="#FFFFFF"><b><font face="MS Sans Serif" size="2" style="font-family: 'MS Sans Serif'; " >Idx:<?php  echo getlang($indexcontrolsvalue);?>? &nbsp;</font></b></font></td><?php 
					}

?>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];
               $name=$row[name];
$ittt = ($startrow)+$i;
      if ($i % 2 ==0) {
          echo"<tr valign=top bgcolor=#ffffff height=2>";
      } else {
          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";
      }             
            echo"<td><font face='MS Sans Serif' size=2><nobr>$ittt [ $row[ordr] ]</font></td>";
     //       echo"<td><font face='MS Sans Serif' size=2 color=#003366>$ID </font></a></td>";
            echo"<td><font face='MS Sans Serif' size=2 color=#003366>
$name [<B>$row[fid]</B>]   </font></a></td>";
            $i2 = $i2 +1;  
//การดูสื่อประกอล
//echo "</td>";
echo "<td width=1% width=2 > <font size=1> $row[example]/$row[descr] </td>";

foreach ($indexmapping as $indexmappingkey => $indexmappingvalue) {
echo "<td width=1% width=2 style=\"border-bottom-style: solid; border-bottom-width: 2px; border-bottom-color: black; background-color: #EFEFEF\"> <font size=1>";
            if ("$row[$indexmappingkey]" == "on") {
                echo "<B><A HREF='media_type.php?page=$page&mid=$ID&item=$indexmappingkey&val=off&startrow=$startrow'><FONT SIZE=2 COLOR=DARKgreen>On</FONT></A></B>";
            }  else  {
                echo "<B><A HREF='media_type.php?page=$page&mid=$ID&item=$indexmappingkey&val=on&startrow=$startrow'><FONT SIZE=2 COLOR=#CC4200>Off</FONT></A></B>";
            }
echo "</td>";
}


           echo"</tr>";
    $i++;
		$s = $i-1;	
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