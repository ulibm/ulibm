<?php 
;
     include("../inc/config.inc.php");
	head();
	mn_root("val");
	tmq("delete from valmem");
	tmq("delete from barcode_valmem");
?>
  <table width="780" align=center border="0" cellspacing="0" cellpadding="0">


    <tr valign="top"> 

      <td>
        <form name="form1" action="media_type.php" method="post" >

          <table width="780" align=center border="0" cellspacing="1" cellpadding="3">

    <tr align="center">

              <td colspan="3"> 

                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 

Serif">

<?php 

  	if (empty($page)){ 

		$page=1;

	}

	// หาจำนวนหน้าทั้งหมด

  $sql1 ="SELECT distinct main FROM val where isshow='yes' "; 

//echo $sql1;

//$sql1 = "$sql1 ORDER BY 'yea','mon','dat' DESC";

//echo $sql1;

	$sql2 = "$sql1 order by main,sub ";

//echo $sql2;

	$result = tmqp($sql2,"media_type.php?");

	$NRow = tmq_num_rows($result);

						

?> </div>

                <table width="770" align=center border="0" cellspacing="1" cellpadding="3">

                  <tr bgcolor="#006699"> 

                    <td width="2%"><font color="#FFFFFF"><b>

<font face="MS Sans Serif" 

size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>

                    <td width=70%><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"><?php  echo getlang("ชื่อตัวแปร::l::Variable name");?></font></b></font></td>

 <td width=30% ><font color="#FFFFFF"><b><font face="MS Sans Serif"

width=20% size="2"><?php  echo getlang("ค่า::l::Value"); ?></td> 

                    <td width="13%">

<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("แก้ไข::l::Edit"); ?></font></b></font></td>

                  </tr>

                  <?php 

         $i=1; 

         while($row = tmq_fetch_array($result)){

	  $ID = $row[id];

               $name=getlang($row[name]);

$ittt = (($page*20)-20)+$i;

          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";

 

            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";

            echo"<td><font face='MS Sans Serif' size=2 color=#003366><B>$row[main] </B> </font></a></td>";

            $i2 = $i2 +1;  

 echo"<td></td><td>";

echo " &nbsp;</td>";

           echo"</tr>";

$r=tmq("select * from val where main='$row[main]'  and isshow='yes' order by sub");

while ($r2=tmq_fetch_array($r)) {

  echo "<tr bgcolor=f7f7f7><td></td><td>".getlang($r2[descr])."<BR><small style='color: aaaaaa;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$r2[sub]</small></td><td> " . htmlentities(substr($r2[val],0,50)) ."...</td><TD><a href='editMedia_type.php?ID=$r2[id]&TYPE=$mType'>".getlang("แก้::l::Edit")."</a></td></tr>";

}

    $i++;

		$s = $i-1;	

       } 

 ?>

                </table>

<?php  

    
echo $_pagesplit_btn_var;

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