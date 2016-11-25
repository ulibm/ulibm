<?php //พ
  function dspmarc($t, $b = " ") {
	if ($b=="") {
		$b =" ";
	}
	if ($b=="[empty]") {
		$b ="";
	}
	$t=str_replace("^a", $b,$t);
	$t=str_replace("^b",$b,$t);
	$t=str_replace("^c",$b,$t);
	$t=str_replace("^d",$b,$t);
	$t=str_replace("^e",$b,$t);
	$t=str_replace("^f",$b,$t);
	$t=str_replace("^g",$b,$t);
	$t=str_replace("^h",$b,$t);
	$t=str_replace("^i",$b,$t);
	$t=str_replace("^j",$b,$t);
	$t=str_replace("^k",$b,$t);
	$t=str_replace("^l",$b,$t);
	$t=str_replace("^m",$b,$t);
	$t=str_replace("^n",$b,$t);
	$t=str_replace("^o",$b,$t);
	$t=str_replace("^p",$b,$t);
	$t=str_replace("^q",$b,$t);
	$t=str_replace("^r",$b,$t);
	$t=str_replace("^s",$b,$t);
	$t=str_replace("^t",$b,$t);
	$t=str_replace("^u",$b,$t);
	$t=str_replace("^v",$b,$t);
	$t=str_replace("^w",$b,$t);
	$t=str_replace("^x",$b,$t);
	$t=str_replace("^y",$b,$t);
	$t=str_replace("^z",$b,$t);
	$t=str_replace("^0",$b,$t);
	$t=str_replace("^1",$b,$t);
	$t=str_replace("^2",$b,$t);
	$t=str_replace("^3",$b,$t);
	$t=str_replace("^4",$b,$t);
	$t=str_replace("^5",$b,$t);
	$t=str_replace("^6",$b,$t);
	$t=str_replace("^7",$b,$t);
	$t=str_replace("^8",$b,$t);
	$t=str_replace("^9",$b,$t);
	$t=str_replace("^-",$b,$t);

	return $t;
  }
?>