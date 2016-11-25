<?php 
;
      include("../inc/config.inc.php");

	$keyword=trim($keyword);
	$isn=trim($isn);
	$authorname=trim($authorname);
	if ((strlen($keyword)>=3 || strlen($isn)>=3 || strlen($authorname)>=3)) { //if searching
		$sql="SELECT *  FROM media where 1  ";

		if ($keyword!="") {
				$sql = "$sql  and (tag245 like '__^a$keyword%' or tag245 like '__$keyword%' ) "; 
		}
		if ($authorname!="") {
				$sql = "$sql  and (tag100 like '__^a$authorname%' or tag110 like '__$authorname%' ) "; 
		}
		if ($isn!="") {
				$sql = "$sql  and (tag020 like '__^a$isn%' or tag020 like '__$isn%' 
				or
				tag022 like '__^a$isn%' or tag022 like '__$isn%' 
				or
				tag024 like '__^a$isn%' or tag024 like '__$isn%' ) "; 
		}

	//print_r($ssql_searchedword);

		$dspv=$allsearchurl;
		//echo $dspv;
$sql.=" order by tag245,tag100,tag020,tag022,tag024";
                    $result=tmq($sql);
///////////////////////////                    
//echo "<PRE>$sql</PRE>";
//////////////////////////
					
                   $NRow=tmq_num_rows($result);
                    // Query ข้อมูลตามจำนวนที่กำหนด
                    $result4sum=tmq($sql);
                    
                    $NRow4sum=tmq_num_rows($result4sum);

	echo "<nobr>".getlang("พบ::l::Found")." " . number_format($NRow4sum) . "  ".getlang("รายการ::l::record(s)")."</nobr>";

	?><table border="0" cellpadding="0" cellspacing="0" >


        <tr>
            <td valign = "top" align = left>
                <?php 
		if ($NRow == 0) { 
		?>
		<center><font style='font-size: 12; color: darkred'><?php  echo getlang("ไม่มีรายการใดตรงกับเงื่อนไข::l::No record satisfy your search"); ?> </font></center>
	<?php 
		} else {
	echo "<FONT style='font-size: 12; color: 656565' >".getlang("รายการที่พบ:::l::Founds:")."</FONT><BR>";
    $i=0;

  while ($row=tmq_fetch_array($result))  {
	  if ($i>=20) {
		break;
	  }
	  $i++;
	  $title=marc_gettitle($row[ID]);
	if (trim($title)=="") {
		 $title="<i>".getlang("ไม่มีชื่อเรื่อง::l::Untitled")."</i>";
	}
    echo "<FONT  COLOR='#3A3A3A' style=' border-width: 0px; border-style: dotted; border-color: black; border-bottom-width: 1px; display: block;'>";
		echo " <b>Title</b>:".$title;
		echo " <b>Auth</b>:".marc_getauth($row[ID]);
		echo " <b>ISN</b>:".dspmarc($row[tag020]).','.dspmarc($row[tag022]).','.dspmarc($row[tag024]);
		?> [<A HREF="<?php  echo $dcrURL?>dublinfull.php?ID=<?php  echo $row[ID]?>" target=_blank>View</A>]
		<?php 
		?> [<A HREF="marcgetter.php?loadfrom=<?php  echo urlencode("$dcrURL");?>&ID=<?php  echo $row[ID]?>" target=_self><b>Get MARC</b></A>]
		
		</FONT>
		<?php 
  }

	


		}
?></TD>
</TR>
</TABLE><?php 
}
        ?>