<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	$_REQPERM="ignorewordimportid";
	$tmp=mn_lib();
	pagesection($tmp);
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

  $sql1 ="SELECT distinct importdt, count(id) as cc FROM ignoreword  group by importdt"; 


	$sql2 = "$sql1 order by id desc ";

//echo $sql2;

	$result = tmqp($sql2,"media_type.php?");

	$NRow = tmq_num_rows($result);

     							

?> </div>
<BR>
                <table width="780" align=center border="0" cellspacing="1" cellpadding="3">

                  <tr bgcolor="#006699"> 

                    <td width="2%"><font color="#FFFFFF"><b>

<font face="MS Sans Serif" 

size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>

                    <td><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"><?php  echo getlang("วันเวลาที่นำเข้า::l::Import Date"); ?></font></b></font></td>

 <td width=30% ><font color="#FFFFFF"><b><font face="MS Sans Serif"

width=20% size="2"><?php  echo getlang("จำนวนข้อมูล::l::Record count"); ?></td> 

                    <td width="13%">

<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("ลบ::l::Delete"); ?></font></b></font></td>

                  </tr>

                  <?php 

         $i=1; 

         while($row = tmq_fetch_array($result)){

	  $ID = $row[id];


               $name=$row[name];

$ittt = (($startrow))+$i;

          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";

 
	 $importdt=$row[importdt];
if ($importdt==0) {
	$importdt="none";
} else {
	$importdt=thaidatestr($importdt);
}
            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";

            echo"<td><font face='MS Sans Serif' size=2 color=#003366>$importdt  </font></a></td>";

            $i2 = $i2 +1;  

echo"<td>$row[cc]</td><td align=center>";

if ($row[importdt]!='0') {
	echo " <nobr>&nbsp;<A HREF='delMedia_type.php?ID=$row[importdt]' onclick='return confirm(\" $cfrm\")'>".getlang("ลบข้อมูลชุดนี้::l::Delete this import set")."</A>";
}
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

<CENTER>** 
 none <?php  echo getlang("หมายถึง ชุดข้อมูลที่ได้จากการคีย์ด้วยมือ::l::is data you key-in mannually.");?></CENTER>
        </form>

      </td>

    </tr>

  </table>
  <?php 
		foot();   
	   ?>