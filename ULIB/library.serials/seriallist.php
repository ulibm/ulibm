<?php 
;
     include("../inc/config.inc.php");
	 head();
	 $_REQPERM="serialsmodule-manageserial";
	 mn_lib();
?>
	  
			  <form name="form1" action="seriallist.php" method="post" >  <TR>
			  <TABLE cellspacing=0 cellpadding=2 align=center class=table_border>
			  	<TD colspan=9 bgcolor=e9e9e9  class=table_head><img 
src="../image/search.gif" width="18" height="15" hspace="4"><?php  echo getlang("ค้นหา::l::Search"); ?></TD>
</TR>
			  <TR>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>

			  	<TD><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?><BR><small>ISSN</small></TD>
				<TD>
				<input type="text" name="keyword" value="<?php  echo $keyword;?>"><BR>
 <input type="text" name="isbn" value="<?php  echo $isbn;?>">
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
				<TD><?php  echo getlang("หรือกรอกบาร์โค้ด::l::or item's barcode"); ?> <BR>
<input type=text name=sbc value="<?php  echo $sbc; ?>" size=15>
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
<TD><input type="submit" name="Submit" value="<?php  echo getlang("ตกลง::l::Submit"); ?>">
</TD>
</TR>
			  </TABLE>
</form>
<table align=center width=<?php  echo $_TBWIDTH;?>>
<tr>
	<td><a href="../library.book/addDBbook.php?forcebringmeto=serial&USINGTEMPLATE=<?php 
	$s=tmq("select * from marc_template where autoset='s'");
	$s=tfa($s);
	echo $s[id];
	?>"><b><?php  echo getlang("เพิ่มรายการใหม่::l::New Record");?></b></a></td>
</tr>
</table>
<?php 
      if (empty($page)){
        $page=1;
    }
    // หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT SQL_BIG_RESULT ID  FROM media where leader  like '_______s%' ";
if ($sbc!="") {

$s=tmq("select * from media_mid where bcode='$sbc' ");
if (tmq_num_rows($s)!=0) {
$s=tmq_fetch_array($s);
  $sql1="$sql1  and id=$s[pid]";
}
}
  if ($search=='wrongdc') {
	  /* UNDER CONSTRUCTION HERE*/
	$sql1="$sql1 and " . getval("stat","dc_tagname") . " not like '%^a%' ";
	$sql1="$sql1 or " . getval("stat","dc_tagname") . " not like '%^a___.%' ";
	$sql1="$sql1 or " . getval("stat","dc_tagname") . " not like '%^a% ___.%' ";
  }
  if ($keyword <> "") {
    $sql1= "$sql1  ".ssql_for_raw($keyword,"titl");
  }
  if ($isbn <> "") {
    $sql1= "$sql1  ".ssql_for_raw($isbn,"isbn");
  }
  $sql1="$sql1 order by id desc";
//echo $sql1;


    $result = tmqp($sql1,"seriallist.php?keyword=$keyword&isbn=$isbn&sbc=$sbc");
         
?>
<table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3" class=table_border> 
<tr > 
<td width="9%" class=table_head><?php  echo getlang("ลำดับที่::l::No."); ?></td> 
<td class=table_head><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?></td>
<td width="26%" class=table_head><?php  echo getlang("ดูรายละเอียด/ไอเทม::l::View/Items"); ?></td> 
</tr> 
                  <?php  
       	/* */
		$i=1;  

         while($row = tmq_fetch_array($result)){ 
      $DatabaseID = $row[DatabaseID]; 
                $mID = $row[ID]; 
                                     $mCall = $row[RESOURCE_IDENTIFIER]; 
                        $mName = $row[tag245]; 
                        $mType =$row[FORMAT]; 
                         $mLang =$row[LANGUAGE]; 
                       $mFORMAT =$row[FORMAT]; 
         $mRTYPE =$row[RESOURCE_TYPE]; 
		          $mcalln =$row[RELATION]; 
                    $ittt = ($startrow)+$i; 
	if ($linkfrom==$mID)  {
			  echo "<tr bgcolor=#BFFFE6> "; 
	} else {
		if ($i%2==0) {
			  echo "<tr bgcolor=#FFF1BB> "; 
		} else {
			  echo " <tr bgcolor=#FFFFFF> "; 
		}	
	}
          $strtype= $row3[show];  
          echo "<td class=table_td>$ittt</td>"; 
          echo "<td class=table_td>".marc_gettitle($mID);
		  $det=marc_getyea($mID);
		  if (trim($det)!="") {
			 echo "/".$det;
		  }
   echo "</td>"; 
 echo"<td class=table_td>";



echo "<a 
href='../dublin.php?ID=$mID&RESOURCE_TYPE=$mRTYPE&adm=on' target=_blank 
>".getlang("ดูรายละเอียด::l::View")."</a>";
echo " <IMG SRC='../neoimg/Book.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><a href='./serial-items.php?MID=$row[ID]&MIDpage=$page'>Items</a> ";
$r=tmq("select * from media_mid where pid='$row[ID]' ");
$n=tmq_num_rows($r);
echo "(" . number_format($n) . ")";
 ?></td> <?php 
           echo "</tr>"; 
		$i++; 
        $s = $i-1; 
}
	
echo $_pagesplit_btn_var;
 ?> 
</table> 

<?php if (floor($startrow)==0) {?>
  <TABLE width=<?php  echo $_TBWIDTH?> align=center>
  <TR>
	<TD><B><?php  echo getlang("5 รายการล่าสุด::l::5 latest bib.");?></B><BR>
	<?php 
		$s=tmq("select distinct pid from media_mid where RESOURCE_TYPE='serial' or RESOURCE_TYPE='b-serial'  order by ID desc limit 5");
		while ($r=tmq_fetch_array($s)) {
			echo "<A HREF='$dcrURL/dublin.php?ID=$r[pid]' target=_blank class=smaller>".marc_gettitle($r[pid])."</A> ";
			echo " <A HREF='../library.book/addDBbook.php?IDEDIT=$r[pid]' class=smaller2 target=_blank>".getlang("แก้ไข::l::Edit")." Bib.</A>";
			echo " <IMG SRC='../neoimg/Book.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><a href='./serial-items.php?MID=$r[pid]&MIDpage=$page' class=smaller2>Items";
			$r2=tmq("select * from media_mid where pid='$r[pid]' ");
			$n=tmq_num_rows($r2);
			echo "(" . number_format($n) . ")</a> ";

			echo "<BR>";
		}
	?></TD>
  </TR>
  </TABLE>
  <?php 
  }
  foot();
  ?>