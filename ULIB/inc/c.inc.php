<?php //พ
	$__AUTOCONFIG="no";
	if ($__AUTOCONFIG=="yes") {
		$host = "localhost"; 
		$user="root";
		$passwd="";
		$dbname=strtolower("$dcr");
		$dbmode="mysqli";

	} else {
		$host = "localhost"; 
		$user="root";
		$passwd="";
		$dbname="ulib6";
		$dbmode="mysqli";
		
	}
	$dbcoll="utf8";

		$memberspechtml = " width=128 height=144 ";
		$memberspechtml_w=128;
		$memberspechtml_h=144;
$newline="
";		

		$_GLOBAL_UPLOADSIZE=1024*1024*500; //bytes
?>