<?php 
;
      include("../../inc/config.inc.php");
	   include("./index.inc.php");
	  head();
		mn_web('stopword');
 ?>


        <table width="780" align=center border="0" cellspacing="0" cellpadding="6">
          <tr> 
            <td align="center" bgcolor="#666666" ><font size="6" color="#FFFFFF"><b><font face="AngsanaUPC, CordiaUPC">Stop Words</font></b></font></td>
          </tr>
        </table>
				<CENTER><BR><BR><B>Stop words </B><?php  echo getlang("คือ คำที่ &quot;เป็นคำขยายให้แก่คำอื่น ๆ แต่ไม่มีความหมายในตัวเอง&quot; <BR>ซึ่งจะไม่นำไปรวมกับการสืบค้น  ซึ่งมีดังรายการต่อไปนี้::l::Stop words are those words which are so common <BR>that they are useless to index and has no meaning to itself "); ?>
				<BR><BR><A HREF="index.php"><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER>
        <div align="center"> 
          <?php 
   // ติดต่อฐานข้อมูล
?>
        </div>
        <form name="form1" action="media_type.php" method="post" >
          <table width="780" align=center border="0" cellspacing="1" cellpadding="3">
      <tr align="center">
              <td colspan="3"> 
                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 
Serif">
<?php 

  $sql1 ="SELECT *  FROM ignoreword"; 
  if ($keyword <> "") { 
   $sql1= "$sql1 WHERE 1 and ((descr like '%$keyword%') or (UserAdminName 
like '%$keyword%'))"; 
  } 
	$sql2 = "$sql1 order by word";

	$result = tmq($sql2);
	$NRow = tmq_num_rows($result);
	if($NRow >0) { 
		
?> </div>
                <table width="770" align=center border="0" cellspacing="1" cellpadding="3">

                  <tr bgcolor="#006699"> 

                    <td colspan=50><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("รายการคำ::l::Word list"); ?></font></b></font></td>

                  </tr>
                  <?php 
         $i=1; 
          echo"<tr valign=top bgcolor=#ffffff height=2>";
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];
               $name=$row[word];
$ittt = (($page*20)-20)+$i;
            echo"<td><font face='MS Sans Serif' size=2>";
if ($i!=1) {
 //echo ",";
}
echo " $name ";
echo "</td>";
if ($i % 8 ==0) {
  echo "</tr><tr>";
}
            $i2 = $i2 +1;  
//การดูสื่อประกอล
    $i++;
		$s = $i-1;	
       } 
echo"</tr>";
 ?>
                </table><BR><BR>
				<CENTER><A HREF="<?php  echo $dcrURL;?>"><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER>
<?php  
    }
  
  
else {
       echo "<center><br><br><hr width='100%' size='1' color=red><font size=+2 face='MS Sans Serif'>Sorry, no results were found</font><br><br></center>\n";
 }
?>
              </td>
            </tr>
          </table>
<?php 
foot();
?>