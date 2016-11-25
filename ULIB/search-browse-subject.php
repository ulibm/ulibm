<?php 
include("./inc/config.inc.php");
 include("./index.inc.php");
  stat_add("visithp_type","browsesubject");
head();
		mn_web("browse-subject");

$tbname="index_db_subj";

function locallinkout($wh) {
	return "<A HREF='searching.php?MSUBJECT=$wh[word1]' target=_blank>$wh[word1]</A>";
	//return "<A HREF='advsearching.php?&searchdb[su]=%20[[AND]]%20$wh[word1]' target=_blank>$wh[word1]</A>";
}
$dsp[2][text]="Subject";
$dsp[2][field]="word1";
$dsp[2][width]="70%";
$dsp[2][filter]="module:locallinkout";

$dsp[4][text]="จำนวนทรัพยากร::l::Materials";
$dsp[4][field]="midcount";
$dsp[4][align]="center";
$dsp[4][width]="30%";

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"word1","","*,count(distinct mid) as midcount","group by word1");


foot();
?>