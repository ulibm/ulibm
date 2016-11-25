<?php 
;
     include("../inc/config.inc.php");
	 head();
	 $_REQPERM="chainer-$chainid";
	 mn_lib();
?>
	
	<TABLE cellspacing=0 cellpadding=2 align=center class=table_border width=600>
	<TR>
	<TD colspan=9 class=table_head2 style="font-size: 20;"><?php 
	$chn=tmq("select * from chainer where code='$chainid' ");
	$chn=tmq_fetch_array($chn);
	$chn[name]=getlang($chn[name]);
	$chn[word]=getlang($chn[word]);
	echo getlang($chn[name]);
	?> 
	:: <A HREF="index.php?chainid=<?php  echo $chainid?>"><?php  echo getlang("กลับ::l::Back");?></A>
	</TD>
	</TR>
	<TR>
	<TD colspan=9 class=table_td style="text-align: left;"><?php 
	res_brief_dsp($chainmaster);				
	?></TD>
	</TR>
	</TABLE>

<?php 
      if (empty($page)){
        $page=1;
    }
    // หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT *  FROM chainerlink where chain='$chainid' and fromid='$chainmaster' ";

  $sql1="$sql1 order by id desc";
//echo $sql1;


    $result = tmqp($sql1,"items.php?chainmaster=$chainmaster&MID=$chainmaster&chainid=$chainid");
         
?>
<table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3" class=table_border> 
<TR>
	<TD colspan=3><B>&nbsp;<A HREF="../library.book/addDBbook.php?chainid=<?php  echo $chainid?>&chainmaster=<?php  echo $chainmaster?>"><?php  echo getlang("เพิ่ม::l::Add new");?></A></B></TD>
</TR>
<tr > 
<td width="9%" class=table_head><?php  echo getlang("ลำดับที่::l::No."); ?></td> 
<td class=table_head><?php  echo getlang($chn[fromtxt]); ?></td>
<td width="26%" class=table_head><?php  echo getlang("ดูรายละเอียด/ลบ/แก้ไข::l::View/Edit/Delete"); ?></td> 
</tr> 
                  <?php  
       	/* */
		$i=1;  

         while($row = tmq_fetch_array($result)){ 
                $mID = $row[destid]; 
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
		  if ($chn[usemid]=="yes") {
			  echo "<BR><FONT class=smaller>&nbsp;";
			  $chainmidinfo=tmq("select * from media_mid where id='$row[frommid]' ");
			  if (tmq_num_rows($chainmidinfo)==0) {
				echo "Item not found, id=$row[frommid] ";
			  } else {
				$chainmidinfo=tmq_fetch_array($chainmidinfo);
				echo getlang("โยงกับไอเทม::l::Linkto item");
				echo "<A class=smaller HREF='../dublin.php?ID=$chainmaster&item=$chainmidinfo[bcode]' target=_blank>".marc_getserialcalln($row[frommid])."</A> <FONT style='font-size:10px;'>barcode:$chainmidinfo[bcode]</FONT>";
			  }
			  echo "</FONT>";
		  }

   echo "</td>"; 
 echo"<td class=table_td>";



echo "<a 
href='../dublin.php?ID=$mID&RESOURCE_TYPE=$mRTYPE&adm=on' target=_blank 
>".getlang("ดูรายละเอียด::l::View")."</a>";

echo "/<a onclick=\"return confirm('Confirm delete')\" 
href='../library.book/delBook.php?ID=$mID&chainid=$chainid&chainmaster=$chainmaster'  
>".getlang("ลบ::l::Delete")."</a>";

echo "/<a 
href='../library.book/addDBbook.php?IDEDIT=$mID&chainid=$chainid&chainmaster=$chainmaster'  
>".getlang("แก้ไข::l::Edit")."</a>";

 ?></td> <?php 
           echo "</tr>"; 
		$i++; 
        $s = $i-1; 
}
	
echo $_pagesplit_btn_var;
 ?> 
</table> 

  <?php 
  index_indexft($chainmaster,true);
  foot();
  ?>