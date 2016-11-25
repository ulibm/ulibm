<?php ;
include("../inc/config.inc.php");// พ

$rsdb=tmq_dump("media_type","code","name");

header("Content-type: application/ms-download\n\n");
header("Content-Disposition: attachment; filename=\"ulibm-bibmanexport-$main.csv\"\n"); 
   header("Pragma: no-cache");
   header("Expires: 0");
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
   
   
echo "Title,Barcode,Tabean,Vol,CallNumber,Location,Price,status,ResourceType,Year
";
$s=tmq("select * from media_mid where ismarked='YES' ");
while ($r=tmq_fetch_array($s)) {
	echo marc_gettitle($r[pid]).",";
	echo "=\"".($r[bcode])."\",";
	echo "=\"".($r[tabean])."\",";
	echo ($r[inumber]).",";
	echo marc_getmidcalln($r[bcode]).",";
	echo str_replace(",","-",strip_tags(get_itemplace_name($r[place]))).",";
	echo ($r[price]).",";
	echo ($r[status]).",";
	echo ($rsdb[$r[RESOURCE_TYPE]]).",";
	$yrsdat=tmq("select tag260 from media where ID='$r[pid]' ");
	$yrsdatr=tmq_fetch_array($yrsdat);
   $yrs=marc_getsubfields($yrsdatr[tag260]);
   //printr($yrs);
   echo trim($yrs[c],". [] {}");
echo "
";
}
die;

?>