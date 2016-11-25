<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);?>
  <table width="780" align=center border="0" cellspacing="0" cellpadding="0">

    <tr valign="top"> 

      <td>
        <form name="form1" action="media_type.php" method="post" >

          <table width="100%" border="0" cellspacing="1" cellpadding="3">

<tr align="center">

              <td colspan="3"> 

                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 

Serif">

<a href="addMedia_type.php?sid=<?php 

echo $sid;?>"><?php  echo getlang("เพิ่มแบบฟอร์มแสดงรายละเอียด::l::Add display"); ?> </a>

<?php 


	// หาจำนวนหน้าทั้งหมด

  $sql1 ="SELECT *  FROM bkdsp"; 

	$sql2 = "$sql1 order by ordr ";

	$result = tmqp($sql2,"media_type.php?");

?> </div>

                <table width="780" border="0" cellspacing="1" cellpadding="3">

                  <tr bgcolor="#006699"> 

                    <td width="2%"><font color="#FFFFFF"><b>

<font face="MS Sans Serif" 

size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>

                    <td width=30%><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"> <?php  echo getlang("ชื่อ::l::Name"); ?></font></b></font></td>

                    <td width=30%><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"><?php  echo getlang("ข้อมูล::l::Text to display"); ?> </font></b></font></td>

                     <td width=12%><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"><?php  echo getlang("เรียงเป็นลำดับที่::l::Ordering"); ?> </font></b></font></td>                   <td width="5%"><nobr>

<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("ลบ/แก้ไข::l::Delete/Edit"); ?></font></b></font></td>

                  </tr>

                  <?php 

         $i=1; 

         while($row = tmq_fetch_array($result)){

	  $ID = $row[id];

               $name=$row[name];

$ittt = (($startrow))+$i;

      if ($i % 2 ==0) {

          echo"<tr valign=top bgcolor=#ffffff height=2>";

      } else {

          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";

      }             

            echo"<td><font face='MS Sans Serif' size=2><nobr>$ittt </font></td>";

            echo"<td><font face='MS Sans Serif' size=2 color=#003366><B>$row[name]</B> </font></a></td>";

            echo"<td><font face='MS Sans Serif' size=2 color=#003366><B>".htmlspecialchars($row[val])."</B> </font></a></td>";

            echo"<td><font face='MS Sans Serif' size=2 color=#003366><B>$row[ordr]</B> </font></a></td>";

            $i2 = $i2 +1;  

//การดูสื่อประกอล

//echo "</td>";



 echo"<td>";

 echo"<font face='MS Sans Serif' size=2>

<a href='delMedia_type.php?ID=$ID' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</a>/<font face='MS Sans Serif' 

size=2>";

echo "<a href='editMedia_type.php?ID=$ID&TYPE=$mType'>".getlang("แก้::l::Edit")."</a></font></td>";

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