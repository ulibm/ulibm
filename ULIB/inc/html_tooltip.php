<?php // พ
function html_tooltip($html,$w=200) {
	////func("html_tooltip");
	global $html_tooltip_int_ed;
	if ($html_tooltip_int_ed!=true) {
		////func("html_tooltip");
		die("html_tooltip_int_ed not called");
	}

	return " onMouseover=\"ddrivetip('$html', $w)\" onMouseout=\"hideddrivetip()\" style=\"cursor: hand; cursor: pointer;\" ";
}
?>