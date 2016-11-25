<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	mn_root("subjextract");

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
<BR>
                <table width="780" align=center border="0" cellspacing="1" cellpadding="3">
                  <tr bgcolor="#006699" align=center> 
                    <td width="2%"><font color="#FFFFFF"><b>
<font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                    <td><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("หมายเลขการนำเข้า::l::Import id"); ?></font></b></font></td>
 <td width=30% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
width=20% size="2"><?php  echo getlang("จำนวนข้อมูล::l::Record count"); ?></td> 
                    <td width="13%">
<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2">Extract</font></b></font></td>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];

               $name=$row[name];
$ittt = (($startrow))+$i;
          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";
 
	 $importid=$row[importid];
if ($importid=="") {
	$importid="[EMPTY]";
}
            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td><font face='MS Sans Serif' size=2 color=#003366>$importid  </font></a></td>";
            $i2 = $i2 +1;  
 echo"<td align=center>".number_format($row[cc])."</td>";

echo " <td><nobr>&nbsp;<A HREF='extract.php?ID=".urlencode($importid)."' >Extract</A>";
		echo "</td>";
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
 
<CENTER>**  none <?php  echo getlang("หมายถึง ชุดข้อมูลที่ได้จากการคีย์ด้วยมือ::l::means records you entered mannually."); ?><BR><BR>
</CENTER>
        </form>
      </td>
    </tr>
  </table>
  <?php 
		foot();   
	   ?>