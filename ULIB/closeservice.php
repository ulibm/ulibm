<?php 
;
	include("inc/config.inc.php");
	 include("./index.inc.php");
	head();
	mn_web("closeservice");
  ?>
<div align="center"> 
<?php 
pagesection("วันปิดทำการของห้องสมุด::l::Library close on following day");
?>
  <table width="450" border="0" cellspacing="0" cellpadding="0" align=center>
    <tr valign="top"> 
      <td> 


        <table width="100%" border="0" cellspacing="1" cellpadding="10" align=center>
          <tr align="center"> 
            <td colspan="3"> 
              <div align="left"> 
                <?php 
  	if (empty($page)){ 
		$page=1;
	}
	// หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT *  FROM closeservice"; 
	$sql2 = "$sql1 order by yea DESC, mon DESC, dat DESC";
	$result = tmq($sql2);
	$NRow = tmq_num_rows($result);
	if($NRow >0) { 
		
?>
              </div>
              <table width="780" border="0" cellspacing="1" cellpadding="3">
                <tr bgcolor="#006699"> 
                  <td width="2%"><font color="#FFFFFF"><b> <font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                  <td><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("รายการวันปิดทำการ::l::Date"); ?> </font></b></font></td>
                  <td width=60% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
width=20% size="2"><?php  echo getlang("คำอธิบาย::l::Description"); ?></td>
                </tr>
                <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $DatabaseID = $row[DatabaseID];
               $yea =$row[yea];
            	$mon = $row[mon];
                $dat = $row[dat];
    $mID = $row[id];                     
$mDescr = $row[descr];
if ($mDescr=="") {
$mDescr ="";
}
$ittt = (($page*20)-20)+$i;
      if ($i % 2 ==0) {
          echo"<tr valign=top bgcolor=#ffffff height=2>";
      } else {
          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";
      }             
            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td><font face='MS Sans Serif' size=2 color=#003366>
 $dat " . $thaimonstr[$mon] ." ";
 if ($yea==-1) {
	echo getlang("ของทุกปี::l::of every year");
 } else {
	echo  $yea;
 }
 " </font></a>";
   echo "</td>";
//echo "<td>&nbsp;$mDescr</td>";
echo "<td> <font size=2 face='MS Sans Serif'> &nbsp;$mDescr";
//การดูสื่อประกอล
echo "</td>";
/* echo"<td><font face='MS Sans Serif' size=2><a 
href='delclose.php?ID=$mID'>ลบ</a>";
*/
           echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
 ?>
              </table>
              <?php  
    
	}
  
  
else {
       echo "<center><br><br><hr width='100%' size='1' color=red><font size=+2 face='MS Sans Serif'>ไม่มีการกำหนดวันหยุด</font><br><br></center>\n";
 }
?>
            </td>
          </tr>
        </table>
 <CENTER><A HREF="index.php"><?php  echo getlang("กลับ::l::Back"); ?></A>
</CENTER>
        </td>
    </tr>
  </table><?php 
  foot();
  ?>