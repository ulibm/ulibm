<?php // พ

	function rem2space($x) {
		while (strpos($x,"  ")!==false) {
		  $x = str_replace("  "," ",$x);
		}
		return $x;
	
	}
?>