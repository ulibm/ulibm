<?php  //พ
	$gdata=Array();
	$gdatatitle=Array();
	$gdatatitle[Position]="Statistics";
	$gid="graph_gdata:thestathist:$db:$USEMON:$USEYEA";

	$sql1 ="SELECT distinctrow foot  FROM $tbl where dt>='$limitdates' and dt<='$limitdatee' and mon='$USEMON' and yea='$USEYEA' "; 

	$sql2 = "$sql1 order by foot";
	$result=tmq($sql2);
			unset($tmpsum);
?> 
                <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3" class=table_border>
                  <tr bgcolor="#006699"> 
                    <td class=table_head rowspan=2 width=150>Statistics</td>
                    <td class=table_head  colspan=31>
										<?php echo $thaimonstr[$USEMON]; ?> <?php echo $USEYEA+543; ?></td>
			</tr>
                  <tr bgcolor="#006699"> 
<?php 
	$lastdofm=date("t",mktime(0, 0, 0, $USEMON, 1, $USEYEA));

for ($i=1;$i<=$lastdofm;$i++) {
	$tmp="0$i";
	$tmp=substr($tmp,-2);
?><td class=table_td align=center <?php 
	$today=date("N",mktime(0, 0, 0, $USEMON, $i, $USEYEA));
	if ($today==6) {
		echo " style='background-color: #BFDFFF' ";
	}
	if ($today==7) {
		echo " style='background-color: #FFB3B3' ";
	}
	
?> style="font-size: 12px;"><?php  echo$tmp?></td><?php 
}
?>				</tr>
                  <?php 
         $i=1; 
		 $monthi=0;
         while($row = tmq_fetch_array($result)){
			 $monthi++;
$rowsum[$row[head]]=0;
$ittt = ($startrow)+$i;
          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";
            echo"<td   class=table_td><font face='MS Sans Serif' size=3 color=#003366>";
			$tmplocaldsp= local_getdspstr($row[foot],$sdb[$db][footmode]);
			echo $tmplocaldsp;
			echo "</td>";
///collecting data
$USEMON=floor($USEMON);
	$t="select dat  as dat2,count(id) as cc from $tbl where dt>='$limitdates' and dt<='$limitdatee'  and foot='$row[foot]' and mon='$USEMON' and yea='$USEYEA' ";

	$t.=" group by foot,dat,mon,yea ";

	$t=tmq($t,false);
	$tmp=Array();
	while ($r=tmq_fetch_array($t)) {
		//print_r($r);
		$tmp[$r["dat2"]]=$r["cc"];//=$r["aa"];
	}
	//printr($tmp);
///collecting data-end

	$gdatatitle[Description]["name$monthi"]=$tmplocaldsp;

for ($i=1;$i<=$lastdofm;$i++) {
	$col=$coldb[$tmp[$i]];
	if ($col=="") {
		$col="#ffcc00";
	}
	if ($tmp[$i]==0) {
		$col="#FFFFFF";
	}
	?><td class=table_td align=center style="font-size: 12px;"
	<?php 
	$today=date("N",mktime(0, 0, 0, $USEMON, $i, $USEYEA));
	if ($today==6) {
		echo " style='border-bottom-color: #BFDFFF; border-bottom-style: solid; border-bottom-width: 2' ";
	}
	if ($today==7) {
		echo " style='border-bottom-color: #FFB3B3; border-bottom-style: solid; border-bottom-width: 2' ";
	}

	$gdata[$monthi]["Serie$i"]=floatval($tmp[$i]);

	$tmpsum[$i]=$tmpsum[$i]+$tmp[$i];
	$rowsum[$row[head]]=$rowsum[$row[head]]+$tmp[$i];
	?> style="background-color: <?php  echo $col;?>;"	><?php 
	if (floor($tmp[$i])!=0) {
		?><a href="_detailthestathist.php?stat=stathist&db=<?php  echo $db;?>&m=<?php  echo $USEMON?>&y=<?php  echo $USEYEA?>&d=<?php  echo $i;?>&foot=<?php echo $row[foot]?>" target=_blank class=smaller2><?php 
	}	
	?><?php  echo number_format($tmp[$i])?></a></td><?php 
}
echo "<td align=right class=table_td>". number_format($rowsum[$row[head]])."</td>";

echo"</tr>";

    $i++;
		$s = $i-1;	
       } 
	  // echo $_pagesplit_btn_var;
 ?>
                   <tr bgcolor="#006699"> 

                    <td class=table_head rowspan=2 width=150>Sum</td>
<?php 
$maxonsumthismonth=0; 
for ($i=1;$i<=$lastdofm;$i++) {
		if ($maxonsumthismonth<floor($tmpsum[$i])) {
		 $maxonsumthismonth=floor($tmpsum[$i]);
		}
?><td class=table_td align=center ><?php  echo number_format($tmpsum[$i])?></td><?php 
}
?>
<td class=table_head align=center ><?php  echo number_format(@array_sum($tmpsum))?></td>
</tr>

<tr bgcolor="#ffffff" valign=bottom height=50> 
<?php 
	for ($i=1;$i<=$lastdofm;$i++) {
	?><td class=table_td align=center ><div 
	style="xxx; width: 100%; background-color: #999999!important; border:1px solid #dddddd; height: <?php echo floor(percent_cal($maxonsumthismonth,floor($tmpsum[$i]))/2);?>px">&nbsp;</div>
</td><?php 
	}
?><td class=table_head align=center > </td>
</tr>

<?php 
if (count($gdata)>0) {
	echo "
	<TR>
		<TD colspan=33 align=right>";
	echo "<A HREF='$dcrURL"."library.stats/graph.php?gid=$gid'  rel='gb_page_fs[]'   class='smaller2 a_btn'>".getlang("กราฟ::l::Graph")." 1</A>";
	echo "<A HREF='$dcrURL"."library.stats/graph2.php?gid=$gid'  rel='gb_page_fs[]'   class='smaller2 a_btn'>".getlang("กราฟ::l::Graph")." 2</A>";
	echo "</TD>
	</TR>";
}
?>
                </table><?php 

$gdataall[data]=$gdata;
$gdataall[title]=$gdatatitle;
$gdataall[reporttitle]=$dspname." - ".$thaimonstr[$USEMON]." ".($USEYEA+543);;

//printr($gdataall);
$gdataalls=serialize($gdataall);
sessionval_set($gid,$gdataalls);
//echo $sqlgdata;
//echo serialize($gdata);
?>