<?php 
function addons_module($w) {
	/*
	available location
// พ

	*/
	global $dcrs;
	global $dcrURL;
	global $addons_module_db;
	if (!is_array($addons_module_db)) {
		$addons_module_db=tmq_dump2("addons","classid","disabled,name");
	}
	$s=tmq("select * from  addons_exec where location='$w' ");
	while ($r=tfa($s)) {
	  //printr($r);
		if ($addons_module_db["$r[classid]"][0]=="yes") {
			continue;
		}
		if (file_exists($dcrs."_addons/$r[classid]/mod.$w.php")) {
			echo "<!-- addons_module($w) start executing $r[classid]/$w  -->
";
			@include($dcrs."_addons/$r[classid]/mod.$w.php");
			echo "<!-- addons_module($w) end executing $r[classid]/$w  -->
";
		} else {
			echo "<!-- addons_module($w) exec. file not found $r[classid]/$w  -->
";
		}
	}
	//add hist
	$chk=tmq("select id from addons_requesthist where classid='$w' ");
	if (tnr($chk)==0) {
		tmq("insert into addons_requesthist set classid='$w' ");
	}
}
?>