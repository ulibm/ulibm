<?php  
pagesection(getlang("วารสาร::l::Serial"));

?> <BR>
<a class=a_btn href="addMedia_type.php?USESMOD=<?php echo $USESMOD;?>&MID=<?php 
echo $MID;?>&MIDpage=<?php 
echo $MIDpage;?>"><IMG SRC="../neoimg/plus.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle><?php  echo getlang(" เพิ่ม Item::l::Add Items"); ?> </a> 
<a class=a_btn href="serial_boundform.php?USESMOD=<?php echo $USESMOD;?>&MID=<?php 
echo $MID;?>&MIDpage=<?php 
echo $MIDpage;?>"><IMG SRC="../neoimg/annoicon.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php  echo getlang("ทำการเย็บเล่ม::l::Bound"); ?></a> 
<a class=a_btn href="serial-items.php?USESMOD=list&MID=<?php 
echo $MID;?>&MIDpage=<?php 
echo $MIDpage;?>"><IMG SRC="../neoimg/annoicon.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php  echo getlang("แสดงแบบรายการ::l::List View"); ?></a>

                
<div style="clear: both">
                  <?php 
$boxrow=6;


	$sb1="SELECT *  FROM media_mid where pid='$MID' ";	
			$sb1="$sb1 group by jenum_1,jenum_2,jenum_3,jenum_4,jenum_5,jenum_6,calln";
	$tdwidth=floor($_TBWIDTH/$boxrow)-10;
	if ($tdwidth<100) {
		 $tdwidth=100;
	}
	$sb1.=" order by jchrono_1 , jchrono_2 , jchrono_3 ,jenum_1 ,jenum_2 ,jenum_3,jenum_4,jenum_5,jenum_6 ";
  $sql1 ="$sb1" ; 

	$result = tmq($sql1,false);
	
									


while($row = tmq_fetch_array($result)) {
   //printr($row);
	$skiplastlink=false;
	$sets=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and calln='$row[calln]' ");
	$thisnum=tmq_num_rows($sets);
	$setstp=tmq_fetch_array($sets);
	$thiscalln=trim(serial_get_volstr($setstp[id]));
	if ($thiscalln=="") {
		$thiscalln="<I>no call number</I>";
	}
   //printr($setstp);
   if ($setstp[jchrono_1]!=0||$setstp[jchrono_2]!=0||$setstp[jchrono_3]!=0) {
      $thiscalln.=" ($setstp[jchrono_1]-$setstp[jchrono_2]-$setstp[jchrono_3])";
   }
	?><div style="display: block; border: 1px solid #633F3D; width: <?php  echo $tdwidth;?>; height:100; margin: 2 2 2 2; float: left; padding: 2 2 2 2;">
	<?php 
	$stat=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and calln='$row[calln]' and bcode<>'' and jpublicnote not like '%bound%' ");
	if (tmq_num_rows($stat)!=0) {
		echo "<div style=\"display: block: height:20; width: 100%; background-color:#CFECCE;text-align: center;\">ARRIVED</div>";
		$numitems=tmq_num_rows($stat);
		echo "<A HREF='itemlist.php?MID=$MID&jenum_1=$row[jenum_1]&jenum_2=$row[jenum_2]&jenum_3=$row[jenum_3]&jenum_4=$row[jenum_4]&jenum_5=$row[jenum_5]&jenum_6=$row[jenum_6]&calln=".urlencode($row[calln])."' class=smaller2 rel='gb_page_fs[]' >items = ".number_format($numitems)."</A>";

	} else {
		$stat=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and bcode='' and calln='$row[calln]' and jnonpublicnote like '%expected%' ");
		if (tmq_num_rows($stat)!=0) {
			$dsped=true;
			echo "<div style=\"display: block: height:20; width: 100%; background-color:#EECCCC;text-align: center;\">EXPECTED</div>";
		}
		$stat=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and bcode='' and calln='$row[calln]' and (jnonpublicnote like '%late%' or jnonpublicnote like '%wait%'  or jnonpublicnote like '%pend%' )");
		if (tmq_num_rows($stat)!=0) {
			$dsped=true;
			echo "<div style=\"display: block: height:20; width: 100%; background-color:#E6CDED;text-align: center;\">LATE</div>";
		}
		$stat=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and bcode<>'' and calln='$row[calln]' and (jpublicnote like '%bound%')");
		if (tmq_num_rows($stat)!=0) {
			$dsped=true;
			$skiplastlink=true;
			echo "<div style=\"display: block: height:20; width: 100%; background-color:#FFBBBB;text-align: center;\">BOUND</div>";
			$numitems=tmq_num_rows($stat);
			echo "<A HREF='itemlist.php?MID=$MID&jenum_1=$row[jenum_1]&jenum_2=$row[jenum_2]&jenum_3=$row[jenum_3]&jenum_4=$row[jenum_4]&jenum_5=$row[jenum_5]&jenum_6=$row[jenum_6]&calln=".urlencode($row[calln])."' class=smaller2 rel='gb_page_fs[]' >items = ".number_format($numitems)."</A>";
		}
		
		if ($dsped!=true) {
			echo "<div style=\"display: block: height:20; width: 100%; background-color:#DCDEDC;text-align: center;\">-</div>";
		}
		if ($skiplastlink!=true) {
			echo "<A HREF='editMedia_type.php?IDEDIT=$row[id]&MID=$MID&jenum_1=$row[jenum_1]&jenum_2=$row[jenum_2]&jenum_3=$row[jenum_3]&jenum_4=$row[jenum_4]&jenum_5=$row[jenum_5]&jenum_6=$row[jenum_6]&editboxinfo=yes&calln=".urlencode($row[calln])."' class='smaller2 a_btn' rel='gb_page_fs[]' >Edit/Arrived</A>";
			echo "<A HREF='serial-items.php?MID=$MID&MIDpage=$MIDpage&deleteitem=$row[id]' class='smaller2 a_btn' onclick=\"return confirm('Please confirm');\">".getlang("ลบ::l::Delete")."</A>";
		}
	}
	//chk attatch
	$keyid="SERIAL-$MID-attatch-$row[jenum_1]-$row[jenum_2]-$row[jenum_3]-$row[jenum_4]-$row[jenum_5]-$row[jenum_6]-$row[calln]";
	$chka=tmq("select * from globalupload where keyid='$keyid' ",false);
	if (tnr($chka)>0) {
		echo "<font class=smaller2 style='color:darkblue'><br>".number_format(tnr($chka))." ".getlang("ไฟล์แนบ::l::Attatched files")."</font>";
	}
	?><BR><FONT class=smaller2><?php  echo $thiscalln; ?></FONT></div><?php 
} // each row
 ?>
</div><?php  
    
// table แสดงเลขหน้า

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