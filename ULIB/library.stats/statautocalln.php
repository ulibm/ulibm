<?php  
    ;
    set_time_limit (2000);
	include("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
	pagesection(getlang("รายงานทรัพยากรตามเลขเรียกกำหนดเอง::l::Stat by auto callnumber"));
	$helpsuggeststr_localcallc=getval("MARC","def_local_callnum");

?>
    <table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">
        <tr valign = "top">
            <td>
        <table width = "100%" border = "0" cellspacing = "1" cellpadding = "10">

            <tr align = "center">
                <td colspan = "3">
                    <table width = "780" border = "0" cellspacing = "1" cellpadding = "3" bgcolor = #F9EA9F class=table_border>
                        <tr bgcolor = "#A27100" class=table_head>
                            <td width = "9%">
                                <nobr><b><font face = "MS Sans Serif" size = "2"><?php echo getlang("ลำดับที่::l::No."); ?></font></b></font></td>
                            <td width = "" align = center>
                              <b><font face = "MS Sans Serif" size = "2"><nobr><?php echo getlang("หมวดของวัสดุสารสนเทศ::l::Classification"); ?></font></b></font></td>
                            <td width = 20% colspan = 1>
                                <b><font face = "MS 
Sans Serif" size = "2"><nobr><?php echo getlang("รวม::l::Total"); ?></font></b></font>
<font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"></font></b></font></td><td>&nbsp;</td>
                        </tr>
            <?php  
                /* */
                $i=0;
                $allc=0;
               $maxc=0;
                //echo $dcsub;
				$keyhelp_callngennersql="select * from keyhelp_callngenner order by name";
$keyhelp_callngenner=tmq($keyhelp_callngennersql);
                while ($keyhelp_callngennerr=tmq_fetch_array($keyhelp_callngenner)) {
					$prefDcsearch="__";
                    $sql1="SELECT count(id) AS sum2  FROM media where  ";

					$sql1="$sql1 LOWER($helpsuggeststr_localcallc) like '$prefDcsearch^a$keyhelp_callngennerr[prefix] %'";

                  //  echo $sql1 . "<BR>";
                    $result=tmq( $sql1,false);
                    echo tmq_error();
                    $NRow=tmq_num_rows($result);
                    $row=tmq_fetch_array($result);
					//printr($row);
                    $summ=$row[sum2];
                    if ($summ>$maxc) $maxc=$summ;
					$stat[$keyhelp_callngennerr[id]]=$summ;
					$allc=$allc + $summ;
				}
$keyhelp_callngenner=tmq($keyhelp_callngennersql);
                while ($keyhelp_callngennerr=tmq_fetch_array($keyhelp_callngenner)) {

                    $countt=$countt + 1;
                    $ittt=1 + $i;
                        echo "<tr  class=table_td> ";

                    echo "<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
                    echo "<td><font face='MS Sans Serif' size=2>  $keyhelp_callngennerr[name] [$keyhelp_callngennerr[prefix]]</font></td>";
                    echo "<td><font face='MS Sans Serif' size=2>  ".number_format($stat[$keyhelp_callngennerr[id]])."</font></td>";
                    echo "<td><font face='MS Sans Serif' size=2>  ".html_graph("W",$maxc,$stat[$keyhelp_callngennerr[id]],10,300)."</font></td>";
                    echo "</td>";
                    $i++;
                    $s=$i - 1;
                    }
            ?>
                <tr>
                    <td colspan = 2 align = right>
                        <?php echo getlang("รวม::l::Sum.");?></td>
                    <td>
                        <U><B><?php  
                echo "$allc";
            ?></B></U></td>
			<?php              
			//	echo "<td><font face='MS Sans Serif' size=2>  ".html_graph("W",$allc,$allc,10,300)."</font></td>";
			?>
			</tr>
                    <tr>
                        <td colspan = 2 align = right>
                            <?php echo getlang("เฉลี่ย::l::Avg.");?></td>
                        <td>
                            <U><B><?php  
                echo number_format(round($allc / $i,2),2);
            ?></B></U></td>
                    </tr>
        </table>
            </td>
        </tr>
    </table>
    </td>
    </tr>
    </table><BR>
	<CENTER><?php  
	$r=tmq("select count(id) as aa from media ");
	$r=tmq_fetch_array($r);
	echo "ผลจากสถิติ ประมวลผลได้ ".number_format($allc)." รายการ จากทั้งหมด ".number_format($r[aa])." รายการในฐานข้อมูล<BR>";
	$free=$r[aa]-$allc;
	if ($free!=0) {
		echo "มี ".number_format($free)." รายการไม่สามารถจำแนกเลขหมู่ได้ <!-- <A HREF=\"../library.book/DBbook.php?search=wrongdc\">กรุณาคลิกที่นี่</A> เพื่อแสดงรายการ -->";
	}

	?></CENTER>


	<?php  
	foot();
	?>