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
	<TD><?php  echo getlang("ค้นหาตามเลขอ้างอิง::l::Search by ref.code");?>          <INPUT TYPE="text" NAME="code"> <INPUT TYPE="submit" value=" <?php  echo getlang("ค้นหา::l::Search");?> ">
	<?php 
	if ($code!="") {
		echo "<A HREF=media_type.php>".getlang("แสดงทั้งหมด::l::Show all")."</A>";
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
<a href="addMedia_type.php" class=a_btn><?php  echo getlang("เพิ่มการสั่งซื้อ::l::Add ordering");?></a>
<?php 


	// หาจำนวนหน้าทั้งหมด

  $sql1 ="SELECT *  FROM acq_acq where 1 "; 

if ($code!="") {
	$sql1="$sql1 and id='$code' ";
}
	$sql2 = "$sql1 order by ymd ";

	$result = tmqp($sql2,"media_type.php?");

?> </div>

                <table width="780" border="0" cellspacing="1" cellpadding="3">

                  <tr bgcolor="#006699"> 

                    <td width="2%"><font color="#FFFFFF"><b>

<font face="MS Sans Serif" 

size="2"><nobr><?php  echo getlang("ลำดับที่::l::No.");?></nobr></font></b></font></td>

                    <td width="2%"><font color="#FFFFFF"><b>

<font face="MS Sans Serif" 

size="2"><nobr><?php  echo getlang("เลขอ้างอิง::l::ref.code");?></nobr></font></b></font></td>

                    <td width=30%><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"><?php  echo getlang("บริษัท (จำนวนที่สั่งซื้อ/สถานะ)::l::Company (Item/Status)");?></font></b></font></td>

                    <td width=30%><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"><?php  echo getlang("วันที่สร้างใบสั่งซื้อ::l::Date created");?></font></b></font></td>

                    <td width="5%"><nobr>

<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("ลบ/แก้ไข/วัสดุที่สั่งซื้อ/พิมพ์::l::Delete/Edit/Items/Print");?></font></b></font></td>

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

echo"<td><font face='MS Sans Serif' size=2 color=#003366>";
$tmp=tmq("select * from acq_company where id='$row[company]' ");
$tmp=tmq_fetch_array($tmp);
echo $tmp[name];
$tmp=tmq("select * from acq_mediasent where acq='$row[id]' ");
echo " (". tmq_num_rows($tmp)."/$row[status])";
echo "</font></a></td>";

echo"<td><font face='MS Sans Serif' size=2 color=#003366>";
echo date("j",$row[ymd]);
echo " ";
echo $thaimonstr[date("n",$row[ymd])];
echo " ";
echo (date("Y",$row[ymd])+543);
echo "</font></td>";


            $i2 = $i2 +1;  

//การดูสื่อประกอล

//echo "</td>";



 echo"<td align=center>";

 echo"<font face='MS Sans Serif' size=2>

<a href='delMedia_type.php?ID=$ID' onclick='return confirm(\" $cfrm\")' >".getlang("ลบ::l::Delete")."</a> / <font face='MS Sans Serif' 

size=2>";

echo "
<a href='editMedia_type.php?ID=$ID&TYPE=$mType'>".getlang("แก้::l::Edit")."</a> / <a class=a_btn href='addmedia.php?ID=$ID&TYPE=$mType'>".getlang("วัสดุที่สั่งซื้อ::l::Items")."</a>

</font></td>";

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