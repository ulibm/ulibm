<?php 
include ("../inc/config.inc.php");
if ($getcsv=="yes") {
// พ
header('Content-type: text/csv');
header('Content-disposition: attachment;filename=ReportExport.csv');
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
$source=sessionval_get("stat_getcsvfromcache_source");
$cmd=sessionval_get("stat_getcsvfromcache_cmd");
$s="select * from $source where $cmd ";
//echo $s;
echo "Stat1,Stat2,d,m,y,timestamp,ref_id\n";
$s=tmq($s);
while ($r=tfa($s)) {
	echo "$r[head],$r[foot],$r[dat],$r[mon],$r[yea],$r[dt],$r[statuid],\n";
}

}
?>