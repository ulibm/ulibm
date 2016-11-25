<?php

$x=explodenewline($s["stat"]);
$x=arr_filter_remnull($x);
@reset($x);

$yea=explodenewline($s["yea"]);

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

$db=barcodeval_get("quickstat-descr");
$db=explodenewline($db);
$db=arr_filter_remnull($db);
@reset($db);
$dba=Array();
while (list($dbk,$dbv)=each($db)) {
	$db1=explode("=",$dbv);
	$dba[trim($db1[0])]=trim(getlang($db1[1]));
}
//printr($dba);
			$sql="select * from media where $yeasql ";

			$sql.=" and (
				tag$s[tag] like '__$subid%'  
				or
				tag$s[tag] like '__^a$subid%'  
				) ";
			$sql=tmq($sql);
			//

			$sql="select distinct media.ID from media,media_mid where media.ID=media_mid.pid and $yeasql ";

			$sql.=" and (
				tag$s[tag] like '__$subid%'  
				or
				tag$s[tag] like '__^a$subid%'  
				) ";
            $_SQLFORCEORDERBY=trim($_SQLFORCEORDERBY);
            if ($_SQLFORCEORDERBY!="") {
               $sql.=" order by $_SQLFORCEORDERBY";
            }
			$sql=tmq($sql,false);
			
			?>