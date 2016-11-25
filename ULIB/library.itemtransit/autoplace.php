<?php 
;
     include("../inc/config.inc.php");
	head();
$_REQPERM="itemtransit-placemap";
$tmp=mn_lib();
pagesection($tmp);
	
	if ($setdest=="yes") {
		//printr($_POST);
		tmq("delete from itemtransit_map");
		@reset($placedata);
		while (list($k,$v)=each($placedata)) {
			while (list($k2,$v2)=each($v)) {
				$s="insert into itemtransit_map set fromplace='$k',tocampus='$k2',setto='$v2'   ";
				tmq($s,false);
				//echo $s."<br>";;
			}
		}
	}	
?>
        <form name="form1" action="<?php  echo $PHP_SELF?>" method="post" >
		<input type="hidden" name="setdest" value='yes'>
  <table width="<?php  echo $_TBWIDTH?>" class=table_border align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td bgcolor=white>
<?php 
  	if (empty($page)){ 
		$page=1;
	}
	// หาจำนวนหน้าทั้งหมด
$stop=tmq("select * from library_site");
while ($stopr=tfa($stop)) {
	pagesection(getlang("นำส่งจาก::l::Transit From").": ".getlang($stopr[name])) ;
 $sql1 ="SELECT * FROM library_site  where code<>'$stopr[code]' "; 
//echo $sql1;
//$sql1 = "$sql1 ORDER BY 'yea','mon','dat' DESC";
//echo $sql1;
	$sql2 = "$sql1 order by name ";
//echo $sql2;
	$result = tmqp($sql2,"media_type.php?");
	$NRow = tmq_num_rows($result);
						
?> 

                <table width="<?php  echo $_TBWIDTH?>" border="0" cellspacing="1" cellpadding="3">
                  <tr bgcolor="#006699" class=table_head> 
                    <td width="8%">&nbsp;<?php  //echo getlang("ลำดับที่::l::No."); ?></td>
                    <td><?php  echo getlang("สาขาห้องสมุดปลายทาง::l::Destination Campus"); ?></td>
                    <td width="13%"><?php  echo getlang("เปลี่ยนสถานที่เป็น::l::Destination Place"); ?></td>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[code];
               $name=getlang($row[name]);
$ittt = (($page*20)-20)+$i;
          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";
 
            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td  ><b>".getlang($row[name])." </b></td>";
            $i2 = $i2 +1;  
 echo"<td>";
echo " &nbsp;</td>";
           echo"</tr>";
$r=tmq("select * from media_place where main='$stopr[code]'  order by code");
while ($r2=tmq_fetch_array($r)) { //printr($r2);
  echo "<tr bgcolor=f7f7f7><td></td><td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	if ($r2[collcode]!="") {
		echo "<b>[$r2[collcode]]</b> ";
	}
  echo getlang($r2[name])." (" . $r2[code] .")";
  echo "</td>
	<TD>";
	$oldval=tmq("select * from itemtransit_map where fromplace='$r2[code]' and tocampus='$row[code]'  ",false);
	$oldval=tfa($oldval);
	$tspkey="placedata[$r2[code]][$row[code]]";
	//echo $tspkey;
	frm_itemplace("$tspkey",$oldval[setto],"","",""," and code = '$row[code]' ");
	echo "</TD>
</tr>";
}
    $i++;
		$s = $i-1;	
       } 
 ?>
              </td>
            </tr>
          </table>
<?php 
} //stop
	
?> 
<center><input type="submit" value=" Save "></center>
      </td>
    </tr>
  </table>
        </form>  <?php 
		foot();   
	   ?>