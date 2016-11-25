<?php 
    ;
    include ("inc/config.inc.php");
	?><table width=985 border=0 align=center bgcolor=white cellpadding=0 cellspacing=0>
	<TR valign=top>
		<TD><?php head();
		//$mn_web_nohomepage="yes";
		mn_web("advsearch");?></TD>
	</TR>
	<TR valign=top>
		<TD style='height: 12; background-color: white'></TD>
	</TR>
	</TABLE><?php 


    include ("./search.inc.header.php");
	include ("./search.inc.mediarow.php");
		
if (is_array($kw) && is_array($searchopt)) { //ถ้า referer เป็น advsearch form
foreach ($kw as $key => $value) {
	$tmp.=$value;
}
if (trim($tmp)=="") {
	echo "<BR>";
	include("webpage.inc.quicksearch.php");
	include("search.inc.pleaseenter.php");
	foot();
	die;
}
	$db=tmq_dump("index_ctrl","code","name");

	$searchdb=Array();
	foreach ($kw as $key => $value) {
		if ($kw[$key]=="") {
			continue;
		}
		reset($db);
		//echo " &nbsp;<B>".$word[$searchopt[$key]]."</B> ด้วยคำว่า $bool[$key] <U>$value</U><br />\n";
		foreach ($db as $dbkey => $dbvalue) {
			//echo "$searchopt[$key]";
			$kw[$key]=str_replace('--',' ',$kw[$key]);
			if ($dbkey==$searchopt[$key]) {
				$searchdb[$dbkey].=" ".$bool[$key]." ".$kw[$key];
			}
		}
	}
}


$_PAGE_FILE="advsearching.php";
$_PAGE_FILEBACK="index.php?setforcehpmode=advsearch";

//$_IGNOTE_SEARCHLIMIT="yes";
include("searchmodule.php");
		foot();	
die;

		?>