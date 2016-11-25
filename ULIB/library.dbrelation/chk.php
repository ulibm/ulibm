<?php 
; 
include ("../inc/config.inc.php");
include("_REQPERM.php");
include("conf.php");
$export=trim($export);
if ($export!="") {
   $tmp=$rules[$export][fromsql];
   $tmp=str_replace("distinct","*,",$tmp);
   $tmp=str_replace(",count(id) as ccdsp","",$tmp);
   $tmp=explode("group by",$tmp);
   $tmp=$tmp[0];
   $sx=tmq($tmp." having var1 ='$key' order by TRIM( var1 ) =  '' ",false);

   echo "all=".tnr($sx)."<BR>";
   while ($r=tfa($sx)) {
      echo implode($r,",")."<BR>";
      //echo $r[var1]."<BR>";
   }
   die;
}html_start();
loginchk_lib();

pagesection(getlang($rules[$id][name]));
//printr($rules[$id]);
?><TABLE width=100% align=center>
<TR>
	<TD class=table_head>Code/Variable</TD>
	<TD class=table_head><?php  echo getlang("ผลการตรวจสอบ::l::Test results");?></TD>
</TR>

<?php 
$sx=tmq($rules[$id][fromsql]." order by TRIM( var1 ) =  '' ",false);
//echo tnr($sx);
$i=0;/*
while ($r=tfa($sx)) {
   printr($r);
}*/
while ($r=tfa($sx)) {
   $i++;
   //echo $i;
   $var1use=$r[var1];
   //echo $dbname;
   //printr($r);
   $dspstr=$r[var1];
	if ($dspstr=="") {
		$dspstr=getlang("-ค่าว่าง-::l::-Empty-");
	}
   $c=tmq("select *,count(id) as ccc from ".$rules[$id][to_tb]." where 
   ".$rules[$id][to_field]."='".$var1use."'
   ",false); //limit 1
   //echo tnr($c);
   if ($rules[$id][skipfound]=='yes' && tnr($c)==1) {
      //echo "continue;";
   	continue;
   }
?>
<TR>
	<TD class=table_head2> <?php  echo $dspstr ?></TD>
	<TD class=table_td> <?php  
	//echo tnr($sx);
	$cc=0;
	$cc=tnr($c);
   if (tnr($c)==0) {
   	if ($rules[$id][skipempty]!="yes") {
   		echo "<B style='color: red'>".getlang("ไม่พบข้อมูล::l::Relation lost")."</B>";
   	} else {
   		echo "<B style='color: darkgreen'>".getlang("ไม่พบข้อมูล::l::Relation lost")."</B>";
   	}
   } else {
   	$c=tfa($c); //printr($r);
   	echo $c[$rules[$id][to_namefield]];
   	if (trim($c[$rules[$id][to_namefield]])=="") {
      	echo $r[var1];
   	}
   	echo " (";
   	echo number_format($r[ccdsp]);
   	echo ")";
   }
?>
 <a href="chk.php?export=<?php echo $id; ?>&key=<?php echo $c[$rules[$id][to_field]]; ?>" class=smaller2 target=_blank>Export</a></TD>
</TR>
<?php 

} ?>
</TABLE>
