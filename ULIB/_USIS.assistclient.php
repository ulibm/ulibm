<?php 
;
      include("inc/config.inc.php");
		//	html_start();
/*
		include("search.inc.sqlcollection.php");
		include("_usis.inc.mediarow.php");
		include("_usis.inc.header.php");		
		*/
	$allsearchstr=trim(iconvth($keyword));
	if (trim($allsearchstr)!="") { //if searching
		$sql="SELECT id,mid FROM index_db where 1  ";

$mapdb="kw";
//print_r($mapdb);
/*
index_init_INDEXWORDDB();
		*/
			$sql = "$sql  " . ssql(trim($allsearchstr),$mapdb) .
				 ssql("[[OR]] ".trim($allsearchstr),"ISBN") .
				 ssql("[[OR]] ".trim($allsearchstr),"auth") .
				 ssql("[[OR]] ".trim($allsearchstr),"titl") .
			" ";

	//print_r($ssql_searchedword);
		$allsearchurl="keyword=$keyword";
		$dspv=$allsearchurl;
		//echo $dspv;
$sql.=" order by rand()";
                    $result=tmq($sql);
///////////////////////////                    
//echo "<PRE>$sql</PRE>";
//////////////////////////
                   $NRow=tmq_num_rows($result);
                    // Query ข้อมูลตามจำนวนที่กำหนด
                    $result4sum=tmq($sql);
                    $NRow4sum=tmq_num_rows($result4sum);

	?><table border="0" cellpadding="0" cellspacing="0" >
<tr><td>&nbsp;&nbsp;&nbsp;<?php 
  echo "<nobr>".getlang("พบ::l::Found")." " . number_format($NRow4sum) . "  ".getlang("รายการ::l::record(s)")."</nobr>";
	?></td></tr>

        <tr>
            <td valign = "top" align = left>
                <?php 
		if ($NRow == 0) { 
		?>
		<center><font style='font-size: 12; color: darkred'><?php  echo getlang("ไม่มีรายการใดตรงกับเงื่อนไข::l::No record satisfy your search"); ?> </font></center>
	<?php 
		} else {
	echo "<FONT style='font-size: 12; color: 656565' >".getlang("ตัวอย่าง:::l::Examples:")."</FONT><BR>";
    $i=0;
$allsearchstr=explode(' ',$allsearchstr);
  while ($row=tmq_fetch_array($result))  {
	  if ($i>=4) {
		break;
	  }
	  $i++;
	  //echo marc_gettitle($row[mid]);
	  $title1=marc_melt($row[mid]);
	  $title=trim($title1[tag245_a],'/:');
	  $title1[tag245_b]=trim($title1[tag245_b]);
	  //echo "[$title1[tag245_b]]";
	  if ($title1[tag245_b]!='') {
		  $title.=' : ' .trim($title1[tag245_b],'/');
	  }
	foreach ($allsearchstr as $x) {
		$x2=strtoupper($x);
		$title=str_replace($x2,"<U>$x2</U>",$title);
		$x=strtolower($x);
		$title=str_replace($x,"<U>$x</U>",$title);
	}
	if (trim($title)=="") {
		 $title="<i>".getlang("ไม่มีชื่อเรื่อง::l::Untitled")."</i>";
	}
    echo "<FONT  COLOR='#3A3A3A' style='font-size: 13px; border-width: 0px; border-style: dotted; border-color: black; border-bottom-width: 1px; display: block;'>".$title."</FONT>";
  }
  ?><div align=right><A HREF="<?php  echo $dcrURL?>/advsearching.php?kw[]=<?php  echo urlencode($keyword);?>&bool[]=[[AND]]&searchopt[]=kw" target=_blank><FONT style="font-size: 13px;" COLOR="#6A7EB5">..<?php  echo getlang("มีอีก::l::more");?></FONT></A></div><?php 
	


		}
?></TD>
</TR>
</TABLE><?php 
}
        ?>