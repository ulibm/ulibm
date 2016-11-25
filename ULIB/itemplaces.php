<?php 
	include("./inc/config.inc.php");
	head();
	mn_web("itemplace");

	$sql1 ="SELECT * FROM library_site order by name ";
	$result = tmq($sql1);
	$focuscalln=trim($focuscalln);
	
?> <center>
<?php
quickeditwebtext("itemplacepage-head",$_TBWIDTH);
?>
                <table width="<?php  echo $_TBWIDTH?>" border="0" cellspacing="1" cellpadding="3" align=center>
                  <tr bgcolor="#006699"> 
                    <td width="2%" class=table_head><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></td>
                    <td  class=table_head colspan=2><?php  echo getlang("สาขาห้องสมุด::l::Campus"); ?>/<?php  echo getlang("สถานที่จัดเก็บ::l::Shelves"); ?></td>
									</tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[code];
               $name=$row[name];
$ittt = $i;
          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";
 
            echo"<td>$ittt</td>";
            echo"<td colspan=2><font face='MS Sans Serif' size=2 color=#003366>".getlang($row[name])."  </font></a></td>";
            $i2 = $i2 +1;  
           echo"</tr>";
$r=tmq("select * from media_place where main='$row[code]'  order by code");
while ($r2=tmq_fetch_array($r)) {
  echo "<tr bgcolor=f7f7f7><td></td>
	<td width=200>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo " " . $r2[code] ."</td>";
  echo " <td> ".getlang($r2[name]);
  echo " ";
  if ($r2[isrq]=="yes") {
	echo " <I>(".getlang("ขอยืมได้::l::Allow request").")</I>";
  }
  echo "</td></tr>";
}
    $i++;
		$s = $i-1;	
       } 
 ?>
                </table><?php 

?><center> 
<a href="index.php"><?php  echo getlang("กลับ::l::Back");?></a><BR>
<TABLE width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
<?php 
$s=tmq("select * from library_site where 1 order by name");
while ($r=tmq_fetch_array($s)) {
$localcode=$r[code];
   //printr($r);
	if (file_exists("$dcrs/_tmp/_floorplan_".$r[code].".jpg")) {
		$getimagesize=getimagesize("$dcrs/_tmp/_floorplan_$r[code].jpg");
		//printr($getimagesize);
		$image_width = $currentimagesize[0];
   	$image_height= $currentimagesize[1];
		echo "<TR>
			<TD class=table_head> " .getlang("แผนที่::l::Map for")." ".get_libsite_name($r[code])."</TD>
		</TR>";
		echo "<tr bgcolor=white><td><div style='position:absolute; width: $image_width;'>";
		$s2=tmq(" select * from media_place where main='$r[code]' ");
		while ($r2=tmq_fetch_array($s2)) {
			
$sp=tmq("select * from media_place_shelf where pid ='$r2[code]'  ",false);
$rida=Array();
while ($rp=tfa($sp)) {
	$pos=explode(";",$rp[mappos2]);
	//printr($pos);
   //printr($r2);
	$rid="div".randid();
	$jsid="js".randid();
	$rida[]=$rid;
				$focusthis=false;
				if ($r2[code]==$focusshf && $rp[startc]<=$focuscalln && $rp[endc]>=$focuscalln) {
					$focusthis=true;
					//echo "yeah";
				} else {
				  //echo "nope";
				}
	?><a href="javascript:void(null);" ID="<?php  echo $rid?>" 
	onmouseover="tmp=getobj('<?php echo $jsid?>');tmp.style.display='block';"
					onmouseout="tmp=getobj('<?php echo $jsid?>');tmp.style.display='none';"
					
<?php if ($view=="yes") {?>

<?php }?>
style="position:absolute; <?php 
	

		echo " background-color: #eeeeee; ";
			echo "border: 1px dotted black; ";
if ($focusthis==true) {
   echo "background-image: url($dcrURL"."neoimg/rainbowanimated.gif);";
}

	if ($view!="yes") {
		//echo " pointer-events:none;";
	}
	?> display: block; top: <?php  echo $pos[1]?>px; left: <?php  echo $pos[0]?>px; width: <?php  echo $pos[2]?>px; height: <?php  echo $pos[3]?>px; ;  overflow: hidden;
	opacity:0.8; filter:alpha(opacity=80);
"
TITLE="<?php 
//echo stripslashes($rp[name]);
	?>"
><?php 
//echo stripslashes($rp[name]);
	?></a>
	<div ID="<?php  echo $jsid;?>"
				style="position:absolute; display:none; width: 200; noheight: 38;background-color: white; padding: 3 3 3 3; top: <?php echo floor($pos[1]+$pos[3])?>px; left:<?php echo floor($pos[0]+$pos[2])?>px;">
				<?php echo getlang($rp[name]);?><BR>
				<B class=smaller >&nbsp;<?php  echo getlang($rp[name]);?></B><BR>
				<FONT class=smaller2><?php  echo $rp[startc];
				if ($rp[endc]!="") {
					echo "- $rp[endc]";
				}
				?></FONT></div>
				
<?php 
}

		}
		echo "</DIV><img src='$dcrURL/_tmp/_floorplan_$localcode.jpg'  border=0 ".$getimagesize[3].">";

		echo "</td></tr>";
	}
}
?>
</TABLE>
<?php
quickeditwebtext("itemplacepage-foot",$_TBWIDTH);
?>
<?php 
foot();   
?>