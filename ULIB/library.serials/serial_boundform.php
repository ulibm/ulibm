<?php 
;
     include("../inc/config.inc.php"); 
	head();
	include("_REQPERM.php");
	mn_lib();
	 ?><BR>
	 <CENTER>
<B><?php  pagesection( getlang("กรุณาเลือกรายการวารสารที่จะเย็บเล่มรวมกัน::l::Please choose items you need to bound")); ?></B></CENTER><?php  

	// หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT *  FROM media_mid where pid='$MID'  and jpublicnote<>'Bound' and RESOURCE_TYPE<>'boundedserial' and RESOURCE_TYPE<>'b-serial'order by 
  length(trim(jenum_1)),jenum_1,
  length(trim(jenum_2)),jenum_2,
  length(trim(jenum_3)),jenum_3,
  length(trim(jenum_4)),jenum_4,
  length(trim(jenum_5)),jenum_5,
  length(trim(jenum_6)),jenum_6,
  length(trim(jchrono_1)),jchrono_1,
  length(trim(jchrono_2)),jchrono_2,
  length(trim(jchrono_3)),jchrono_3,
  length(trim(inumber)),inumber,
  id" ; 

	$result = tmq($sql1);
	$NRow = tmq_num_rows($result);
 							
?> 
<BR>                <table width="780" align=center border="0" cellspacing="1" cellpadding="3">
<FORM METHOD=POST ACTION="addMedia_type.php">
<INPUT TYPE="hidden" name=mode value="bounditem">
<INPUT TYPE="hidden" name=USESMOD value="<?php  echo $USESMOD?>">

                  <tr bgcolor="#006699"> 
                    <td width="2%"><font color="#FFFFFF"><b>
<font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>

                    <td width="5%"><nobr>
<font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("เลขเรียก::l::CallNumber"); ?></font></b></font></td>
 <td width=20% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
 size="2"><?php  echo getlang("บาร์โค้ด::l::Barcode"); ?></td> 
 <td width=20% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
 size="2"><?php  echo getlang("เลขทะเบียน::l::Code"); ?></td>
 <td width=30% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
 size="2"><?php  echo getlang("ข้อมูล::l::Information"); ?></td> 

                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];
               $name=$row[name];
$ittt = ($startrow)+$i;
      if ($i % 2 ==0) {
          echo"<tr valign=top bgcolor=#ffffff height=2>";
      } else {
          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";
      }             
            echo"<td><font face='MS Sans Serif' size=2><nobr><INPUT TYPE=checkbox NAME='slist[]' value='$ID' style='border: 0'> $ittt </font></td>";
            $i2 = $i2 +1;  
//การดูสื่อประกอล

$t01=tmq("select * from media where id='$MID'");
$t01=tmq_fetch_array($t01);
$dsp=marc_getcalln($MID);

echo "<td width=1% width=2 > <font size=1> $dsp
$row[inumber]</td>";

echo "<td width=1% width=2 > <font size=1> <A HREF=# 
onclick=\"javascript:window.open('getbc.php?bc=$row[bcode]','bc','width=500,height=50')\">$row[bcode]</A>";
if ($row[status]!="") {
 echo " *(สถานะ=$row[status])";
}
echo "</td>";

echo "<td width=1% width=2 > <font size=1> $row[tabean] </td>";
echo "<td width=1% width=2 > <font size=1> ";
echo serial_get_volstr($row[id]);
echo "</td>";

           echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
 ?>
                </table>
<?php  
    
// table แสดงเลขหน้า
?>
              </td>
            </tr>
          </table><BR>
 <CENTER>
 <INPUT TYPE="hidden" name=MID value="<?php  echo $MID?>">
<INPUT TYPE="hidden" name=MIDpage value="<?php  echo $MIDpage?>">

<INPUT TYPE="submit" value=" <?php  echo getlang("ขึ้นตอนต่อไป ::l::Next step"); ?>">
<A HREF="<?php  echo "serial-items.php?USESMOD=$USESMOD&MID=$MID&MIDpage=$MIDpage"; ?>"><B><?php  echo getlang("กลับ::l::Back"); ?></B></A>
</CENTER>        </form>
      </td>
    </tr>
  </table>
 <BR>
 <?php 
foot();
//  include("serial_form.php");
  ?>