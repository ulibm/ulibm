<?php 
;
	include("inc/config.inc.php");
	head();
		mn_web("resource_type");
?><BR><?php 
if ($managing=="") {
	$managing="main";
}

	pagesection(getlang("ประเภทวัสดุสารสนเทศที่ให้บริการ::l::Material type"));
	$str=getlang("กำลังดูกฏการยืมคืนของสาขา <b>".get_libsite_name($managing)."</b>::l::Viewing checkrule for campus <b>".get_libsite_name($managing)."</b>");
	html_dialog("Info","$str");

  ?>
<div align="center"> 
<form method="get" action="<?php  echo $PHP_SELF?>">
	<?php  echo getlang("หรือเลือกสาขาห้องสมุดอื่นเพื่อดู::l::or choose another campus to view");?> : 
	<?php  frm_libsite("managing",$managing);?> <input type="submit" value="<?php  echo getlang("เลือก::l::View"); ?>">
</form>
<CENTER><A HREF="<?php  echo $dcrURL;?>"><?php  echo getlang("กลับ::l::Back"); ?></A>
</CENTER>
        <table width="<?php  echo $_TBWIDTH?>" border="0" cellspacing="1" cellpadding="10">
          <tr align="center"> 
            <td colspan="3"> 
              <div align="left"> 
               <?php 
  	if (empty($page)){ 
		$page=1;
	}
	// หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT *  FROM media_type"; 

	$sql2 = "$sql1 order by code DESC";
	$result = tmq($sql2);
	$NRow = tmq_num_rows($result);
	if($NRow >0) { 
		
?>
              </div>
              <table width="<?php  echo $_TBWIDTH?>" border="0" cellspacing="1" cellpadding="3">
                <tr bgcolor="#006699"> 
                  <td width="2%"><font color="#FFFFFF"><b> <font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                  <td width=20%><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("สัญลักษณ์::l::Code"); ?> </font></b></font></td>
                  <td width=60% ><font color="#FFFFFF"><b><font face="MS Sans Serif"
width=20% size="2"><?php  echo getlang("ชื่อเต็ม::l::Name"); ?></td>
                </tr>
                <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $DatabaseID = $row[DatabaseID];
               $yea =$row[yea];
            	$mon = $row[mon];
                $dat = $row[dat];
    $mID = $row[id];                     
$mDescr = $row[descr];
if ($mDescr=="") {
$mDescr ="";
}
$ittt = (($page*20)-20)+$i;
          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";
         
            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td align=center><font face='MS Sans Serif' size=2 color=#003366><img border=0 width=48 height=48 src='";
	if (file_exists("$dcrs/_tmp/mediatype/$row[code].png")==true) {
		echo "$dcrURL/_tmp/mediatype/$row[code].png";
	} else {
		echo "$dcrURL/_tmp/mediatype.png";
	}
	echo "' > ";
   echo "</td>";
//echo "<td>&nbsp;$mDescr</td>";
echo "<td> <B style='color:003366'>$row[code]</B><BR><B>&nbsp;".getlang($row[name])."</B>";
//การดูสื่อประกอลecho "</td>";
/* echo"<td><font face='MS Sans Serif' size=2><a 
href='delclose.php?ID=$mID'>ลบ</a>";
*/
           echo"</tr>";
		   echo " <TR>
		   	<TD colspan=4><TABLE>";
			$s2=tmq("select * from member_type order by type");
			$arr=Array();
			while ($r=tmq_fetch_array($s2)) {
				$arr[]=getlang($r[type]);
				echo "<TR><td width=100></td><TD style=\"font-size: 14px;\" width=200>".html_membertype_icon($r[type],12)."<U>".getlang($r[descr])."</U>&nbsp;&nbsp;&nbsp;</TD><TD style=\"font-size: 14px;\">";
				$s3=tmq("select * from checkout_rule where member_type='$r[type]' and media_type='$row[code]' and libsite='$managing' ");
				$s3=tmq_fetch_array($s3);
				if ($s3[cancheckout]=='yes') {
					echo getlang("ยืมออกได้ ".($s3[day]-1)." วัน ค่าปรับ $s3[fine] บาท::l::allow checkout $s3[day] day, fine $s3[fine] bath/day");
					if ($s3[fee]!=0) {
						echo getlang(" ค่าธรรมเนียมการยืม $s3[fee] บาท/รายการ::l::, checkout fee $s3[fee] bath/item");
					}
					if (floor($s3[renew])!='0') {
						echo " ".getlang("ยืมต่อได้ $s3[renew] ครั้ง::l::allow checkout $s3[renew] renew");
					} else {
						echo " ".getlang("ยืมต่อไม่ได้::l::cannot renew");
					}
				} else {
					echo getlang("ยืมออกไม่ได้::l::cannot checkout");
				}
				echo "</TD></TR>";
			}
		   echo "</TABLE></TD>
		   </TR>";
    $i++;
		$s = $i-1;	
       } 
 ?>
              </table>
              <?php  
    
	}
  
  
else {
       echo "<center><br><br><hr width='100%' size='1' color=red><font size=+2 face='MS Sans Serif'>Sorry, no results were found</font><br><br></center>\n";
 }
?>
            </td>
          </tr>
        </table>
 <CENTER><A HREF="index.php"><?php  echo getlang("กลับ::l::Back"); ?></A>
</CENTER>
        </td>
    </tr>
  </table>
  
</div><?php  foot();?>