<?php  
pagesection(getlang("วารสาร::l::Serial"));
?><BR><?php 
	if (empty($page)){ 
		$page=1;
	}
	// หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT *  FROM media_mid where pid='$MID' order by inumber desc,jenum_1 desc,jenum_2 desc,jenum_3 desc,jenum_4 desc,jenum_5 desc,jenum_6 desc,jchrono_1 desc,jchrono_2  desc,jchrono_3 desc,id desc " ; 

	$result = tmqp($sql1,"serial-items.php?USESMOD=$USESMOD&MID=$MID&MIDpage=$MIDpage");
	$NRow = tmq_num_rows($result);
 							
?>
<a class=a_btn href="addMedia_type.php?USESMOD=<?php echo $USESMOD;?>&MID=<?php 
echo $MID;?>&MIDpage=<?php 
echo $MIDpage;?>"><IMG SRC="../neoimg/plus.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle><?php  echo getlang(" เพิ่ม Item::l::Add Items"); ?></a>   
<a class=a_btn href="serial_boundform.php?USESMOD=<?php echo $USESMOD;?>&MID=<?php 
echo $MID;?>&MIDpage=<?php 
echo $MIDpage;?>"><IMG SRC="../neoimg/annoicon.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php  echo getlang("ทำการเย็บเล่ม::l::Bound"); ?></a>
 
<a class=a_btn href="serial-items.php?USESMOD=&MID=<?php 
echo $MID;?>&MIDpage=<?php 
echo $MIDpage;?>"><IMG SRC="../neoimg/annoicon.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php  echo getlang("แสดงแบบ Box::l::Box View"); ?></a><BR>


                <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3" class=table_border>
                  <tr bgcolor="#006699"> 
<td width="2%" class=table_head><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></td>
<td width="15%" class=table_head><nobr><?php  echo getlang("เลขเรียก::l::CallNumber"); ?></nobr></td>
 <td width=15%  class=table_head><?php  echo getlang("บาร์โค้ด::l::Barcode"); ?></td> 
 <td width=15%  class=table_head><?php  echo getlang("เลขทะเบียน::l::Code"); ?></td>
 <td width=30%  class=table_head><?php  echo getlang("ข้อมูล/ประเภท::l::Information"); ?></td> 
 <td width="10%" class=table_head><nobr><?php  echo getlang("ลบ/แก้ไข::l::Delete/Edit"); ?></nobr></td>
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
            echo"<td class=table_td><font face='MS Sans Serif' size=2><nobr>$ittt </font></td>";
            $i2 = $i2 +1;  
//การดูสื่อประกอล

$t01=tmq("select * from media where id='$MID' ");
$t01=tmq_fetch_array($t01);
$dsp=marc_getserialcalln($row[id],"no","no");

echo "<td width=1% width=2  class=table_td> <font size=1> $dsp
</td>";

echo "<td width=1% width=2 class=table_td> <font size=1>$row[bcode]";
if ($row[status]!="") {
 echo " *(".getlang("สถานะ::l::Status")."=".get_mid_status($row[status]).")";
}
if ($row[jnonpublicnote]!="") {
 echo " *(".getlang("Note")."=".($row[jnonpublicnote]).")";
}
echo "</td>";

echo "<td width=1% width=2 class=table_td> <font size=1> $row[tabean] </td>";
echo "<td width=1% width=2 class=table_td> <font size=1> ";
echo serial_get_volstr($row[id]);
echo "<BR><I>";
echo get_media_type($row[RESOURCE_TYPE]);
			//chk attatch
			$keyid="SERIAL-$MID-attatch-$row[jenum_1]-$row[jenum_2]-$row[jenum_3]-$row[jenum_4]-$row[jenum_5]-$row[jenum_6]-$row[RESOURCE_TYPE]";
			$chka=tmq("select * from globalupload where keyid='$keyid' ",false);
			if (tnr($chka)>0) {
				echo "<font class=smaller2 style='color:darkblue'><br>".number_format(tnr($chka))." ".getlang("ไฟล์แนบ::l::Attatched files")."</font>";
			}

echo "</I></td>";
echo"<td class=table_td>";
echo"<font face='MS Sans Serif' size=2>
<a href='del-serial.php?USESMOD=$USESMOD&ID=$row[id]&MID=$MID&MIDpage=$MIDpage&barcodeforlog=$row[bcode]' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</a>/<font face='MS Sans Serif' 
size=2>";
echo "<a 
href='editMedia_type.php?USESMOD=$USESMOD&IDEDIT=$ID&TYPE=$mType&MID=$MID&MIDpage=$MIDpage'
unhref='serial_form.php?USESMOD=$USESMOD&IDEDIT=$ID&TYPE=$mType&MID=$MID&MIDpage=$MIDpage'>".getlang("แก้::l::Edit")."</a></font></td>";
           echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
echo $_pagesplit_btn_var;
 ?>
                </table>
              </td>
            </tr>
          </table>
 
        </form>
      </td>
    </tr>
  </table>
  <?php 
  serial_rebuild_serialstr($MID);
//  include("serial_form.php");
  ?>