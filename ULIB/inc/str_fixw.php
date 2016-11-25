<?php // พ
function str_fixw($str,$width,$c="0") {
	$tmp="$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c$c";
	return substr("$tmp$str",-$width);
}
?>