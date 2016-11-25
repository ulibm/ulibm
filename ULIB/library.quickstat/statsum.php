<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
$notfoundsql="select distinct tag060 where (0 ";
$db=barcodeval_get("quickstat-descr");
$db=explodenewline($db);
$db=arr_filter_remnull($db);
@reset($db);
$dba=Array();
while (list($dbk,$dbv)=each($db)) {
	$db1=explode("=",$dbv);
	$dba[trim($db1[0])]=trim(getlang($db1[1]));
}
	?><B><?php echo getlang("สถิติสรุป::l::Summary Statistic")?></B><BR>
	<?php 
	$s=tmq("select * from quickstat where 1");
	$totalsum=0;
	while ($srow=tmq_fetch_array($s)) {
		$statsum=0;


//echo getlang("ดึงข้อมูลจากแท็ก::l::Use tag").": ".getlang($srow[tag]). " ";
//echo getlang("เฉพาะข้อมูลในปี::l::These year(s) only").": ".($srow[yea]);
if (trim($srow[yea])=="") {
	//echo getlang("ทุกปี::l::All years");
}
$x=explodenewline($srow["stat"]);
$x=arr_filter_remnull($x);
@reset($x);

$yea=explodenewline($srow["yea"]);

$yeasql="";
while (list($yeak,$yeav)=each($yea)) {
	if ($yeasql!="") {
		$yeasql="$yeasql or";
	}
	$yeasql="$yeasql tag008 LIKE  '_______$yeav%'";
}
		$yeasql="($yeasql)";
		//echo $yeasql;
@reset($yea);
	//printr($yea);


//printr($dba);
@reset($x);
	 while (list($k,$v)=each($x)) {
		$thissum=0;
		$srowql="select * from media where $yeasql ";

		$srowql.=" and (
				tag$srow[tag] like '__$v%'  
				or
				tag$srow[tag] like '__^a$v%'  
				) ";
			//echo $srowql;
			$srowql=tmq($srowql,false);
			$cc =tmq_num_rows($srowql);
			$totalsum=$totalsum+$cc;
			$statsum=$statsum+$cc;
			$thissum=$thissum+$cc;
			 //echo $v."=$cc<br> ";
			while ($notfoundr=tmq_fetch_array($srowql)) {
				$notfoundsql.=" or ID='$notfoundr[ID]' ";				
			}
		}
	echo "<b>".$srow[name]."</b> ";
	echo number_format($statsum)."<hr>";
}
$notfoundsql.=")";
//echo $notfoundsql;
$s="select * from media where $notfoundsql";

	echo "<br><br><font style='font-size:24px;'>Total Sum ".number_format($totalsum)."</font>";
			
			?>
