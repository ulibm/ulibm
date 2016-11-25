<?php 
;
      include("inc/config.inc.php");
			html_start();

		include("search.inc.sqlcollection.php");
		include("_usis.inc.mediarow.php");
		include("_usis.inc.header.php");		
		
				$allsearchstr=trim($keyword);
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

                   // $result=tmqp($sql,"$PHP_SELF?$allsearchurl","",5);
                    $result=tmqp($sql,"_USIS.presearch.php?url=".urlencode($dcrURL)."&keyword=".urlencode($keyword),"",5);
///////////////////////////                    
//echo "<PRE>$sql</PRE>";
//////////////////////////
                   $NRow=tmq_num_rows($result);
                    // Query ข้อมูลตามจำนวนที่กำหนด
                    $result4sum=tmq($sql);
                    $NRow4sum=tmq_num_rows($result4sum);

	

	?><table border="0" cellpadding="0" cellspacing="0" >
<tr><td width=160 align=center><?php 
$gstr2=getlang("<b>Homepage</b>").",index.php?setforcehpmode=advsearch,blue,_blank";
	html_guidebtn($gstr2);?></td><td><?php 
  echo getlang("ค้นหา ::l::Searching ")."'".trim($keyword,",")."' ";
  echo getlang("พบจำนวน::l::Found")." " . number_format($NRow4sum) . "  ".getlang("รายการ::l::record(s)")."</nobr>";
	echo "<br />".getlang("คลิกปุ่ม Homepage เพื่อไปยังหน้าหลักของห้องสมุดนี้โดยตรง::l::Click 'Homepage' button to visit this library");
	?></td></tr>
</table></div>
    <table width = "780" align=center border = 0 cellspacing = "0" cellpadding = "0">
        <tr>
            <td width = "70" colspan = "4">
                <img src = "./neoimg/spacer.gif" width = 3 height = 5 border = 0 hspace = 0 vspace = 0></td>
        </tr>
        <tr>
            <td valign = "top" align = center>
                <?php 
		if ($NRow == 0) { 
		?>
		<center><font size=+2 face='MS Sans Serif' color=darkred><nobr><b><?php  echo getlang("ไม่มีรายการใดตรงกับเงื่อนไขการค้นหา::l::No record satisfy your search"); ?> </b>
<?php 

		
		} else {
                ?>
<table width = "780" align = center border = "0" cellspacing = "1" cellpadding = "3">

<?php 
local_media_usisheadtr();
    $i=1;
  while ($row=tmq_fetch_array($result))  {
    usis_inc_media($row);
  }
	
				echo $_pagesplit_btn_var;	
			?>
    </table>
    <?php 


		}

} else{ //if not searching
    ?>
                <div align = "center">
                    <center>
                        <b><font color = red size = +1><?php  echo getlang("กรุณาใส่ข้อมูลสำหรับสืบค้น::l::Please enter something to search"); ?>
</font></b></center>

                </div>
        <?php 
                }
        ?>