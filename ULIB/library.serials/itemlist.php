<?php 
include("../inc/config.inc.php");
html_start();
include("_REQPERM.php");
loginchk_lib("check");

$result="select * from media_mid where pid='$MID' and jenum_1='$jenum_1' and jenum_2='$jenum_2' and jenum_3='$jenum_3' and jenum_4='$jenum_4' and jenum_5='$jenum_5' and jenum_6='$jenum_6' and bcode<>'' and calln='$calln' ";
$result=tmq($result,false);
?>
                <table width="<?php  echo $_TBWIDTH;?>" align=center border="0" cellspacing="1" cellpadding="3" class=table_border>
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
echo "</I>";
if ($row[RESOURCE_TYPE]==getval("MARC","serial-bound-mdtype")) {
   ?>
   <A target=_blank HREF='_boundslip.php?bcode=<?php echo $row[bcode];?>' class='a_btn smaller2'><?php echo getlang("พิมพ์ใบส่งเย็บเล่ม::l::Print bound slip");?></A>
   <?php
}
echo "</td>";
 echo"<td class=table_td align=center>";
 echo"<font face='MS Sans Serif' size=2>
<a href='serial-items.php?MID=$MID&MIDpage=$MIDpage&deleteitem=$row[id]' onclick='return confirm(\" $cfrm\")' target=_top>".getlang("ลบ::l::Delete")."</a>/<font face='MS Sans Serif' 
size=2>";
echo "<a 
href='editMedia_type.php?USESMOD=$USESMOD&IDEDIT=$ID&TYPE=$mType&MID=$MID&MIDpage=$MIDpage&framemode=yes&jenum_1=$jenum_1&jenum_2=$jenum_2&jenum_3=$jenum_3&jenum_4=$jenum_4&jenum_5=$jenum_5&jenum_6=$jenum_6&calln=".urlencode($calln)."'
>".getlang("แก้::l::Edit")."</a></font></td>";
           echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
echo $_pagesplit_btn_var;
 ?>
                </table>
<?php 
pagesection("ไฟล์แนบ::l::Attatch Files");
?>
<center><iframe width="<?php  echo $_TBWIDTH;?>" src="<?php echo $dcrURL?>globalupload.php?key=<?php  echo "SERIAL-$MID-attatch-$jenum_1-$jenum_2-$jenum_3-$jenum_4-$jenum_5-$jenum_6-$calln";?>"></iframe></center>