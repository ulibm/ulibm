<?php ;
include("../inc/config.inc.php");// พ

$rsdb=tmq_dump("media_type","code","name");

$main=tmq("select * from countuse_name where countuse='$qnid'");
	if (tmq_num_rows($main) ==0 )  {
		$name="unnamed";
	} else {
	$main=tfa($main);
		$name=$main[name] ;
	}
	
header("Content-type: application/ms-download\n\n");
header("Content-Disposition: attachment; filename=\"ulibm-bibmanexport-$qnid-$name.csv\"\n"); 
   header("Pragma: no-cache");
   header("Expires: 0");
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
echo "Title,Barcode,Tabean,Vol,CallNumber,Location,Price,status,ResourceType
";
$s=tmq("select * from media_mid where $qnid='YES' ");
while ($r=tmq_fetch_array($s)) {
	echo marc_gettitle($r[pid]).",";
	echo ($r[bcode]).",";
	echo ($r[tabean]).",";
	echo ($r[inumber]).",";
	echo marc_getmidcalln($r[bcode]).",";
	echo str_replace(",","-",strip_tags(get_itemplace_name($r[place]))).",";
	echo ($r[price]).",";
	echo ($r[status]).",";
	echo ($rsdb[$r[RESOURCE_TYPE]]).",";

echo "
";
}
die;

?>