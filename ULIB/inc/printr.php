<?php // พ
function printr($wh,$mode="") {
	////func("printr");
	if ($mode=="") {
		echo "<pre>";
		print_r($wh);
		echo "</pre>";
	} elseif ($mode=="key") {
		echo "<BLOCKQUOTE>";
		while (list($key, $val) = each($wh)) {
			echo "$key <BR>\n";
		}
		echo "</BLOCKQUOTE>";
	}
}
?>