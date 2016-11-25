<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
	if ($DELID!="") {
		tmq("delete from yaz_saved where id='$DELID'");
	}
	if ($DELTETALL=="YES") {
		tmq("delete from yaz_saved ");
	}
?><CENTER><BR><?php  echo getlang("หากต้องการลบทิ้งทุกรายการ::l::If need to clear all records "); ?> <A HREF="yazlist.php?DELTETALL=YES" onclick="return confirm('<?php  echo getlang("กรุณายืนยันการลบ::l::Confirm deletion"); ?>');"><?php  echo getlang("คลิกที่นี่::l::Click here"); ?></A><BR><A HREF="index.php"><?php  echo getlang("คลิกที่นี่::l::Click here"); ?></A> <?php  echo getlang("เพื่อไปหน้าสืบค้นข้อมูลจากห้องสมุดอื่น ๆ::l:: to try a new search."); ?> <BR><BR></CENTER>
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

  $sql1 ="SELECT *  FROM yaz_saved"; 

	$sql2 = "$sql1 order by id";

//echo $sql2;

	$result = tmqp($sql2,"yazlist.php?");

?> </div>

                <table width="770" align=center border="0" cellspacing="1" cellpadding="3">

				<FORM METHOD=POST ACTION="">
                  <tr bgcolor="#006699"> 

                    <td width="2%"><font color="#FFFFFF"><b>

<font face="MS Sans Serif" 

size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>

                    <td><font color="#FFFFFF"><b><font face="MS Sans Serif" 

size="2"><?php  echo getlang("รายละเอียด::l::Detail"); ?></font></b></font></td>

                    <td width="18%" align=center>
<nobr>
<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("ลบ/คีย์รายการ::l::Delete/Key this records"); ?></font></b></font></td>

                  </tr>

                  <?php 

         $i=1; 

         while($row = tmq_fetch_array($result)){


			$ID = $row[id];

			$urid="ID_$ID";
			$name=marc_getinfofrom_uglymarc($row[marcinfo]);
			$ittt = ($startrow)+$i;

      if ($i % 2 ==0) {

          echo"<tr valign=top bgcolor=#ffffff height=2>";

      } else {

          echo"<tr bgcolor=#f7f7f7 height=2 valign=top>";

      }             

            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";

     //       echo"<td><font face='MS Sans Serif' size=2 color=#003366>$ID </font></a></td>";

            echo"<td><font face='MS Sans Serif' size=2 color=#003366>

$name ";
?><IMG SRC="../neoimg/View.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle style="border: 0px; width: 16; height: 16;" onclick="alert(getobj('<?php  echo $urid;?>').value);"><?php 
if (trim($row[fromsv])!="") {
	echo "<BR><B><small>From <I>$row[fromsv]</I></small></B>";
}
echo "</font></a></td>";

            $i2 = $i2 +1;  

//การดูสื่อประกอล

//echo "</td>";

//echo "<td width=1% width=2 > <nobr><font size=1>$issn</nobr></td>";

 echo"<td align=center>";

 echo"<font face='MS Sans Serif' size=2>

<a href='yazlist.php?DELID=$ID&startrow=$startrow' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</a>/";

?><A HREF="../library.book/addDBbook.php?yazid=<?php echo $row[id];?>" target=_top><?php  echo getlang("คีย์รายการ::l::Key this record"); ?></A><?php 
echo "</font></td>";

	?>		<INPUT TYPE="hidden" name="marcinfo" value="<?php  echo ($row[marcinfo]);?>" ID='<?php  echo $urid;?>'>
<?php 
           echo"</tr>";

    $i++;

		$s = $i-1;	

       } 

		    echo $_pagesplit_btn_var;

 ?>
</FORM>
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