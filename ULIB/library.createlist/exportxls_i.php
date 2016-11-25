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
$sbib=tmq("select * from createlist_result where pid='$main' ",false);
while ($rbib=tmq_fetch_array($sbib)) {

$s=tmq("select * from media_mid where pid='$rbib[mid]' ",false);
while ($r=tmq_fetch_array($s)) {
	echo str_replace(",","_",marc_gettitle($r[pid])).",";
	echo "=\"".($r[bcode])."\",";
	echo "=\"".($r[tabean])."\",";
	echo ($r[inumber]).",";
	echo marc_getmidcalln($r[bcode]).",";
	echo str_replace(",","-",strip_tags(get_itemplace_name($r[place]))).",";
	echo ($r[price]).",";
	echo ($r[status]).",";
	echo getlang($rsdb[$r[RESOURCE_TYPE]]).",";
	$yrsdat=tmq("select tag260 from media where ID='$r[pid]' ");
	$yrsdatr=tmq_fetch_array($yrsdat);
   $yrs=marc_getsubfields($yrsdatr[tag260]);
   //printr($yrs);
   echo trim($yrs[c],". [] {}");
echo "
";
}
}
die;

?>