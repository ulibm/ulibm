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
	<TD><?php  echo getlang("ค้นหาตามเลขอ้างอิง::l::Search by ref.code"); ?> 
	<INPUT TYPE="text" NAME="code"> <INPUT TYPE="submit" value=" <?php  echo getlang("ค้นหา::l::Search"); ?> ">
	<?php 
	if ($code!="" || $setbudget!="") {
		echo "<A HREF=media_type.php class=a_btn>".getlang("แสดงทั้งหมด::l::Show all")."</A>";
	}
	?>
</TD>

</TR>
          </FORM>    </TABLE>
      <table width="100%" border="0" cellspacing="1" cellpadding="3">

       <tr align="center">

              <td colspan="3"> 

                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 

Serif">
<BR>
<a href="../library.acq/main.php" class=a_btn><B><?php  echo getlang("เมนูระบบจัดหา::l::Acquisition module"); ?></B></a>
<?php 


	// หาจำนวนหน้าทั้งหมด

  $sql1 ="SELECT *  FROM acq_tocatalog where 1 "; 

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


                    <td width="5%"><nobr>

<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("ลบ/ป้อนข้อมูล::l::Edit/Key record"); ?></font></b></font></td>

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

echo"<td><font face='MS Sans Serif' size=2 color=#003366>$row[refcode]</font></a></td>";

echo"<td><font face='MS Sans Serif' size=2 color=#003366>$row[d_titl]/$row[d_isbn] </font></a></td>";



            $i2 = $i2 +1;  

//การดูสื่อประกอล

//echo "</td>";



 echo"<td>";

 echo"<font face='MS Sans Serif' size=2>

<a href='delMedia_type.php?ID=$ID' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</a>/<a href='../library.book/addDBbook.php?acqid=$ID' target=_blank>".getlang("ป้อนข้อมูล::l::Key record")."</a>
	
</td>";

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
