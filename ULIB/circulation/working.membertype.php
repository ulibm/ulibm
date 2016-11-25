<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

  $sql1 ="SELECT *  FROM media_type"; 

	$sql2 = "$sql1 order by code DESC";
	$result = tmq($sql2);
	$NRow = tmq_num_rows($result);
if ($managing=="") {
	$managing="$LIBSITE";
}
		$str=getlang("สิทธิ์การยืมที่ <b>".get_libsite_name($managing)."</b>::l::checkout permission at <b>".get_libsite_name($managing)."</b>");
html_dialog("Info","$str");

?><CENTER>
<form method="get" action="<?php  echo $PHP_SELF?>">
<input type="hidden" name="membertype" value="<?php  echo $membertype?>">
	<?php  echo getlang("หรือเลือกสาขาห้องสมุดอื่นเพื่อดูสิทธิ์::l::or choose another campus to view");?> : 
	<?php  frm_libsite("managing",$managing);?> <input type="submit" value="<?php  echo getlang("เลือก::l::view"); ?>">
</form>

              <table width="600" align=center border="0" cellspacing="1" cellpadding="3"  class=table_border>
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

          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";
echo "<td class=table_td><img border=0 width=16 height=16 src='";

   $usecode=$row[code];
	//echo "$dcrs/_tmp/mediatype/$usecode.png";
	if (file_exists($dcrs."/_tmp/mediatype/$usecode.png")==true) {
		echo "$dcrURL/_tmp/mediatype/$usecode.png";
	} else {
		echo "$dcrURL/_tmp/mediatype.png";
	}
	echo "' alt='".getlang($row[name])."'> <font > <B>$row[code] - ".getlang($row[name])."</B>";
           echo"</tr>";
		   echo " <TR>
		   	<TD colspan=4>";
			$s2=tmq("select * from member_type where type='$membertype'");
			$arr=Array();
			while ($r=tmq_fetch_array($s2)) {
				$arr[]=getlang($r[type]);
				echo "&nbsp;&nbsp;&nbsp;";
				$s3=tmq("select * from checkout_rule where member_type='$r[type]' and media_type='$row[code]'  and libsite='$managing' ");
				$s3=tmq_fetch_array($s3);
				if ($s3[cancheckout]=='yes') {
					echo getlang("ยืมออกได้ $s3[day] วัน ค่าปรับ $s3[fine] บาท::l::allow checkout $s3[day] day, fine $s3[fine] bath/day");
					if ($s3[fee]!=0) {
						echo getlang(" ค่าธรรมเนียมการยืม $s3[fee] บาท/เล่ม::l::, checkout fee $s3[fee] bath/item");
					}
					if (floor($s3[renew])!='0') {
						echo " ".getlang("ยืมต่อได้ $s3[renew] ครั้ง::l::allow checkout $s3[renew] renew");
					} else {
						echo " ".getlang("ยืมต่อไม่ได้::l::cannot renew");
					}
				} else {
					echo getlang("ยืมออกไม่ได้::l::cannot checkout");
				}
			}
		   echo "</TD>
		   </TR>";
    $i++;
		$s = $i-1;	
       } 
 ?>
              </table>
              <?php  
    

  
?>