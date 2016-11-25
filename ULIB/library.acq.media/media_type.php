<?php 
    ;
	include ("../inc/config.inc.php");
	head();
include("_REQPERM.php");
mn_lib();
?>

  <table width="780" align=center border="0" cellspacing="0" cellpadding="0">

    <tr valign="top"> 

      <td>

<TABLE>
<FORM METHOD=POST ACTION="media_type.php">
<TR>
	<TD><?php  echo getlang("ค้นหาตามเลขอ้างอิง::l::Search by ref.code"); ?>          <INPUT TYPE="text" NAME="code"> <INPUT TYPE="submit" value=" <?php  echo getlang("ค้นหา::l::Search"); ?> ">
	<?php 
	if ($code!="" || $setbudget!="") {
		echo "<A HREF=media_type.php>แสดงทั้งหมด</A>";
	}
	?>
</TD>

<tr >
	<td >
<?php  echo getlang("เลือกดูจากงบประมาณ::l::Search by budget"); ?>
<select name = setbudget>
<?php 
$s=tmq("select * from acq_setbudget order by  yea,major ");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[id]' $sl>$r[yea]-$r[major]";
}
?></select> <INPUT TYPE="submit" value=" <?php  echo getlang("ค้นหา::l::Search"); ?> ">
</font></td>
</tr>


</TR>
          </FORM>    </TABLE>
      <table width="100%" border="0" cellspacing="1" cellpadding="3">

       <tr align="center">

              <td colspan="3"> 

                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 

Serif">
<BR>
<a href="addMedia_type.php" class=a_btn><?php  echo getlang("เพิ่มวัสดุสารสนเทศที่จะสั่งซื้อ::l::Add Material "); ?></a>
<?php 


	// หาจำนวนหน้าทั้งหมด

  $sql1 ="SELECT *  FROM acq_media where 1 "; 

if ($code!="") {
	$sql1="$sql1 and id='$code' ";
}
if ($setbudget!="") {
	$sql1="$sql1 and setbudget='$setbudget' ";
}
	$sql2 = "$sql1 order by d_titl,d_isbn ";

	$result = tmqp($sql2,"media_type.php?");

?> </div>

                <table width="780" border="0" cellspacing="1" cellpadding="3">

                  <tr bgcolor="#006699"> 

                    <td width="2%"><font color="#FFFFFF"><b>

<font face="MS Sans Serif" 

size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>

                    <td width="2%"><font color="#FFFFFF"><b>

<font face="MS Sans Serif" 

size="2"><nobr><?php  echo getlang("เลขอ้างอิง::l::ref.code"); ?></nobr></font></b></font></td>

                    <td width=30%><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?>/ISBN</font></b></font></td>

                    <td width=30%><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"><?php  echo getlang("ใช้งบประมาณ::l::Budget"); ?></font></b></font></td>

                    <td width="5%"><nobr>

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

echo"<td><font face='MS Sans Serif' size=2 color=#003366>$row[id]</font></a></td>";

echo"<td><font face='MS Sans Serif' size=2 color=#003366>$row[d_titl]/$row[d_isbn] </font></a></td>";

echo"<td><font face='MS Sans Serif' size=2 color=#003366>";
$tmp=tmq("select * from acq_setbudget where id='$row[setbudget]' ");
$tmp=tmq_fetch_array($tmp);

echo " $tmp[yea]-$tmp[major]</font></td>";


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