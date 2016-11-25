<?php 
;
     include("../inc/config.inc.php");
	head();
$_REQPERM="itemplace";
$tmp=mn_lib();
pagesection($tmp);
	if ($setdef!="") {
		tmq("update media_place set isdef='' where main='$main' ");
		tmq("update media_place set isdef='YES' where main='$main' and code='$setdef' ");
	}
	
	if ($setdefserial!="") {
		tmq("update media_place set isdefserial='' where main='$main' ");
		tmq("update media_place set isdefserial='YES' where main='$main' and code='$setdefserial' ");
	}	
?>
  <table width="780" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td>
        <form name="form1" action="media_type.php" method="post" >
          <table width="780" align=center border="0" cellspacing="1" cellpadding="3">
    <tr align="center">
              <td colspan="3"> 
                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 
Serif">
<?php 
  	if (empty($page)){ 
		$page=1;
	}
	// หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT * FROM library_site  "; 
//echo $sql1;
//$sql1 = "$sql1 ORDER BY 'yea','mon','dat' DESC";
//echo $sql1;
	$sql2 = "$sql1 order by name ";
//echo $sql2;
	$result = tmqp($sql2,"media_type.php?");
	$NRow = tmq_num_rows($result);
						
?> </div>
<BR>
                <table width="770" border="0" cellspacing="1" cellpadding="3">
                  <tr bgcolor="#006699"> 
                    <td width="2%"><font color="#FFFFFF"><b>
<font face="MS Sans Serif" 
size="2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
                    <td><font color="#FFFFFF"><b><font face="MS Sans Serif" 
size="2"><?php  echo getlang("สาขาห้องสมุด::l::Campus"); ?></font></b></font></td>
                    <td width="13%">
<font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("แก้ไข::l::Edit"); ?></font></b></font></td>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[code];
               $name=$row[name];
$ittt = (($page*20)-20)+$i;
          echo"<tr bgcolor=#e7e7e7 height=2 valign=top>";
 
            echo"<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
            echo"<td  ><font face='MS Sans Serif' size=2 color=#003366>$row[name]  </font></a></td>";
            $i2 = $i2 +1;  
 echo"<td>";
echo " <A HREF=\"addMedia_type.php?libsite=$row[code]\">".getlang("เพิ่ม::l::Add")."</A></td>";
           echo"</tr>";
$r=tmq("select * from media_place where main='$row[code]'  order by code");
while ($r2=tmq_fetch_array($r)) { //printr($r2);
  echo "<tr bgcolor=f7f7f7><td></td><td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	if ($r2[collcode]!="") {
		echo "<b>[$r2[collcode]]</b> ";
	}
  echo "$r2[name] (" . $r2[code] .")";
  echo " <br><a href='defformattype.php?main=$r2[code]' class=smaller2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".getlang("จัดการสถานที่เริ่มต้น::l::Manage default place")."</a>";
  echo "<font class=smaller2><br>&nbsp;&nbsp;";
  $deffor=tmq("select * from media_place_defformattype where placecode='$r2[code]' ");
  if (tnr($deffor)!=0) {
	  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".getlang("สถานที่เริ่มต้นสำหรับ::l::Default for").": ";
	  while ($defforr=tfa($deffor)) {
		echo get_media_type($defforr[mediatypecode])."(".get_libsite_name($defforr[libsite]).") ";
	  }
  }
  echo "</font></td>
	
  
  <TD><a href='editMedia_type.php?ID=$r2[code]&TYPE=$mType'>".getlang("แก้::l::Edit")."</a>";
  		if ($r2[delable]=='YES') {
 echo "<font face='MS Sans Serif' 
size=2> /<a href='delMedia_type.php?ID=$r2[code]' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</a></font>";
		}
echo "  </td></tr>";
}
    $i++;
		$s = $i-1;	
       } 
 ?>
                </table>
<?php  
    
echo $_pagesplit_btn_var;
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