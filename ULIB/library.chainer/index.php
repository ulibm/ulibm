<?php 
;
     include("../inc/config.inc.php");
	 head();
	 $_REQPERM="chainer-$chainid";
	 mn_lib();
?>
	  
			  <TABLE cellspacing=0 cellpadding=2 align=center class=table_border width=600>
			  <form name="form1" action="index.php" method="post" > 
			  <TR>
			  	<TD colspan=9 class=table_head2 style="font-size: 20;"><?php 
	$chn=tmq("select * from chainer where code='$chainid' ");
	$chn=tmq_fetch_array($chn);
	$chn[name]=getlang($chn[name]);
	$chn[word]=getlang($chn[word]);
	echo getlang($chn[name]);
				?></TD>
			  </TR>
			  <TR>
			  	<TD colspan=9 bgcolor=e9e9e9  class=table_head><img 
src="../image/search.gif" width="18" height="15" hspace="4"><?php  echo getlang("ค้นหา::l::Search"); ?></TD>
</TR>
			  <TR>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>

			  	<TD><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?><BR><small>ISN</small></TD>
				<TD>
				<input type="text" name="keyword" value="<?php  echo $keyword;?>"><BR>
 <input type="text" name="isbn" value="<?php  echo $isbn;?>">
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
				<TD><?php  echo getlang("หรือกรอกบาร์โค้ด::l::or item's barcode"); ?> <BR>
<input type=text name=sbc value="<?php  echo $sbc; ?>" size=15>
<input type=hidden name=chainid value="<?php  echo $chainid; ?>" size=15>
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
<TD><input type="submit" name="Submit" value="<?php  echo getlang("ตกลง::l::Submit"); ?>">
</TD>
</TR>
			  </TABLE>

<?php 
      if (empty($page)){
        $page=1;
    }
    // หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT SQL_BIG_RESULT ID  FROM media where 1 $chn[mainlimit] ";
if ($sbc!="") {

$s=tmq("select * from media_mid where bcode='$sbc' ");
if (tmq_num_rows($s)!=0) {
$s=tmq_fetch_array($s);
  $sql1="$sql1  and id=$s[pid]";
}
}
  if ($keyword <> "") {
    $sql1= "$sql1  ".ssql_for_raw($keyword,"titl");
  }
  if ($isbn <> "") {
    $sql1= "$sql1  ".ssql_for_raw($isbn,"isbn");
  }
  $sql1="$sql1 order by id desc";
//echo $sql1;


    $result = tmqp($sql1,"index.php?chainid=$chainid&keyword=$keyword&isbn=$isbn&sbc=$sbc");
         
?>
<table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3" class=table_border> 
<tr > 
<td width="9%" class=table_head><?php  echo getlang("ลำดับที่::l::No."); ?></td> 
<td class=table_head><?php  echo getlang("ชื่อเรื่อง::l::Title"); ?></td>
<td width="26%" class=table_head><?php  echo getlang("ดูรายละเอียด/$chn[word]::l::View/$chn[word]"); ?></td> 
</tr> 
                  <?php  
       	/* */
		$i=1;  

         while($row = tmq_fetch_array($result)){ 
                $mID = $row[ID]; 
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
href='../dublin.php?ID=$mID' target=_blank 
>".getlang("ดูรายละเอียด::l::View")."</a>";
echo " <IMG SRC='../neoimg/Book.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><a href='./items.php?chainmaster=$row[ID]&MIDpage=$page&chainid=$chainid'>$chn[word]</a> ";
$r=tmq("select * from chainerlink where fromid='$row[ID]' and chain='$chainid' ");
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

  <?php 
  foot();
  ?>