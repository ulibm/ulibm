<?php ;
include("../inc/config.inc.php");// พ

$ext[csv]="csv";
$ext[csvreadable]="csv";
$ext[full]="html";
$ext[brieve]="html";
$ext[shorted]="html";
$ext[marc]="marc";

if ($exportmode=="marc" || $exportmode=="csv"|| $exportmode=="csvreadable")  {
	header("Content-type: application/ms-download\n\n");
	header("Content-Disposition: attachment; filename=\"ulibm-bibmanexport-$main.".$ext[$exportmode]."\"\n"); 
	   header("Pragma: no-cache");
   header("Expires: 0");
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
} else {
	html_start();
}
if ( $exportmode=="csv"|| $exportmode=="csvreadable")  {
	$source=tmq("select * from bkedit where systemhide='no' order by fid");
	while ($sourcer=tmq_fetch_array($source)) {
		echo trim($sourcer[fid]).',';
	}
	echo $newline;
}
$s=tmq("select distinct pid from media_mid where ismarked='YES'  ");
while ($r=tmq_fetch_array($s)) {
	$value=$r[pid];
	if ($exportmode=="full") {
		 $tmp= html_displaymarc($value);
		 $tmp = str_replace(" bgcolor="," nobgcolor=",$tmp);
		 $tmp = str_replace(" border="," noborder=",$tmp);
		 echo $tmp;
		 echo "<BR>";
	}
	if ($exportmode=="brieve") {
		 $tmp = html_displaymedia($value,false);
		 $tmp = str_replace(" bgcolor="," nobgcolor=",$tmp);
		 $tmp = str_replace(" border="," noborder=",$tmp);
		 echo $tmp;
		 echo "<BR>";
	}
	if ($exportmode=="shorted") {
		 res_brief_dsp($value,false,false);	
		 echo "$newline<BR><BR>
";
	}	
	if ($exportmode=="marc") {
		echo marc_export($value);
	}
	if ($exportmode=="csv") {
		$source=tmq("select * from bkedit where systemhide='no' order by fid");
		$media=tmq("select * from media where ID='$value' ");
		$media=tmq_fetch_array($media);
		while ($sourcer=tmq_fetch_array($source)) {
			$inf=$media[$sourcer[fid]];
			$inf=explodenewline($inf);
			$inf=$inf[0];
			$inf=str_replace(',','&#44;',$inf);
			echo $inf.',';
		}
		echo $newline;
	}
	if ($exportmode=="csvreadable") {
		$source=tmq("select * from bkedit where systemhide='no' order by fid");
		$media=tmq("select * from media where ID='$value' ");
		$media=tmq_fetch_array($media);
		while ($sourcer=tmq_fetch_array($source)) {
			$inf=$media[$sourcer[fid]];
			$inf=explodenewline($inf);
			$inf=substr($inf[0],2);
			$inf=dspmarc($inf);
			$inf=str_replace(',','&#44;',$inf);
			echo $inf.',';
		}
		echo $newline;
	}
}
die;

?>