<?php // พ
	function ssql_rembool($var) {
		if ($var!="[[AND]]" && $var !="[[OR]]" && $var != "[[NOT]]" ) {
			return true;
		} else {
			return false;
		}	
	}
?>