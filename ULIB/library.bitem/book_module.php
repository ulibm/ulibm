<a href="addMedia_type.php?MID=<?php 
echo $MID;?>&remotes_row=<?php 
echo $remotes_row;?>"  class=a_btn><IMG SRC="../neoimg/plus.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php  echo getlang("เพิ่ม Item::l::Add Item"); ?> </a>
<?php  

$libsitedb=tmq_dump2("library_site","code","name");
$placedb=tmq_dump2("media_place","code","name");
$placeparentdb=tmq_dump2("media_place","code","main");
  $sql1 ="SELECT *  FROM media_mid "; 
 $sql1= "$sql1 WHERE 1 and (pid = '$MID') " ; 

	$sql2 = "$sql1 order by length(inumber), inumber ";
//echo $sql2;
	$result = tmqp($sql2,"media_type.php?MID=$MID&remotes_row=$remotes_row");
						
?> 

<table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3" class=table_border>
		<form name="form1" action="media_type.php" method="post" >

  <tr bgcolor="#006699"> 
	<td width="2%" class=table_head><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></td>
	<td width="5%" class=table_head><nobr><?php  echo getlang("ประเภท::l::Type"); ?></td>
     <td width=30%  class=table_head><?php  echo getlang("เลขเรียก::l::CallNumber"); ?></td>
	 <td width=30%  class=table_head><?php  echo getlang("บาร์โค้ด::l::Barcode"); ?>/<?php  echo getlang("เลขทะเบียน::l::Code"); ?></td> 
 <td width=30% class=table_head><?php  echo getlang("สาขา/ที่จัดเก็บ::l::Branch/Shelf"); ?></td> 
  
	<td width="5%"  class=table_head><nobr><?php  echo getlang("ลบ/แก้ไข::l::Delete/Edit"); ?></td>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];
               $name=$row[name];
$ittt = ($startrow)+$i;
      if ($i % 2 ==0) {
          echo"<tr valign=top bgcolor=#ffffff height=2 class=table_dr>";
      } else {
          echo"<tr bgcolor=#F2F2F2 height=2 valign=top class=table_dr>";
      }             
            echo"<td  class=table_td><nobr>$ittt </td>";
            $i2 = $i2 +1;  
//การดูสื่อประกอล
//echo "</td>";
echo "<td width=1%  class='table_td smaller2' align=center >";
echo "<img border=0 width=24 height=24 src='";
	if (file_exists("$dcrs/_tmp/mediatype/$row[RESOURCE_TYPE].png")==true) {
		echo  "$dcrURL/_tmp/mediatype/$row[RESOURCE_TYPE].png";
	} else {
		echo "$dcrURL/_tmp/mediatype.png";
	}
	echo "'>";

	echo "<BR>".get_media_type($row[RESOURCE_TYPE]);

"</td>";

$t01=tmq("select * from media where id='$MID' ");
$t01=tmq_fetch_array($t01);
$dsp=marc_getmidcalln($row[bcode]);

echo "<td width=1% width=2   class=table_td> $dsp&nbsp;$row[inumber]</td>";
echo "<td width=1% width=2   class=table_td> <FONT class=smaller>$row[bcode]";
if ($row[status]!="") {
 echo " *(".getlang("สถานะ::l::Status")."=".get_mid_status($row[status]).")";
}
echo "</FONT><BR><FONT class=smaller2>$row[tabean]</FONT>";
echo "</td>";
echo "<td width=1% width=2   class=table_td><FONT COLOR=#6F0000>";
//printr($row);
echo getlang($libsitedb[$row[libsite]]);
echo "</FONT><BR><FONT class=smaller2 color=#45516B>";
echo getlang($placedb[$row[place]]);
echo ",";
echo getlang($libsitedb[$placeparentdb[$row[place]]]);
echo "</FONT></td>";

 echo"<td class='table_td smaller' align=center>";
	 echo"<a href='delMedia_type.php?ID=$ID&MID=$MID&remotes_row=$remotes_row&barcodeforlog=$row[bcode]' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</a> : <font face='MS Sans Serif' 
	size=2>";
	echo "<a href='editMedia_type.php?ID=$ID&TYPE=$mType&MID=$MID&remotes_row=$remotes_row'>".getlang("แก้::l::Edit")."</a>";
	echo "<BR><a href='media_type.php?torepairroom=$row[bcode]&TYPE=$mType&MID=$MID&remotes_row=$remotes_row'>".getlang("ส่งซ่อม::l::Repair.")."</a>";

echo "</td>";
           echo"</tr>";
$row[note]=trim($row[note]);
if ($row[note]!="") {
	?><TR bgcolor=white><TD></TD><TD colspan=5 class=smaller style="font-size: 10"> Note.<?php  echo $row[note]?></TD>
	</TR><?php 
}
	$row[adminnote]=trim($row[adminnote]);
if ($row[adminnote]!="") {
	?><TR bgcolor=white><TD></TD><TD colspan=5 class=smaller style="font-size: 10"> Admin. Note.<?php  echo $row[adminnote]?></TD>
	</TR><?php 
}
    $i++;
		$s = $i-1;	
       } 
echo $_pagesplit_btn_var;
 ?>
                </table>

<table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3" >

<TR>
	<TD><A HREF="moveitemtothisbib.php?MID=<?php  echo $MID;?>&linkfrom=<?php echo $MID?>&remotes_row=<?php echo $remotes_row?>" class="smaller a_btn"><?php  echo getlang("ย้าย item จาก Bib อื่นมาอยู่ใน Bib นี้::l::Move item from other Bib. to this Bib.");?></A></TD>
</TR>
</TABLE>