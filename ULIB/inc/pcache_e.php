<?php // พ
function pcache_e() {
	//return;
	global $dcrs_pcache_s_runned;
	global $dcrs_pcache_s_ccode;
	global $dcrs_pcache_s_subdir;
	global $pcache_s_forcestopto_e;
	global $dcrs_pcache;
	global $_DEFDBENCODE;
	if ($pcache_s_forcestopto_e=="yes") {
		echo "<!-- pcache_e() disabled due pcache_s_forcestopto_e=true -->";
		return; // 
	}

	global $REQUEST_METHOD;
	$REQUEST_METHOD2=strtolower($REQUEST_METHOD);
	if ($REQUEST_METHOD2=="post") {
		echo "<!-- pcache_e() disabled due to post_method  -->";
		return; // disable cache on post_method
	}
	if (loginchk_lib("return")==true) {
		echo "<!-- pcache_e() disabled due loginchk_lib()=true -->";
		return; // disable cache on post_method
	}


	if ($dcrs_pcache_s_runned!="yes") {
		die ("Pcache_e error pcache_s() never called; halting");
	}
	if ($dcrs_pcache_s_ccode=="") {
		die ("Pcache_e error \$dcrs_pcache_s_ccode not defined; halting");
	}
	if ($dcrs_pcache=="") {
		die ("Pcache_e error \$dcrs_pcache not defined; halting");
	}
	$cachefile = "$dcrs_pcache/$dcrs_pcache_s_ccode.html";

	//echo "Pcache_e save cache file: $cachefile<BR>\n";

	$fp = fopen($cachefile, 'w');
	fwrite($fp, ob_get_contents());
	fclose($fp);
	ob_end_clean();
	if (!headers_sent()) {
		header('Content-Type: text/html; charset='.$_DEFDBENCODE);
	}
	include($cachefile);
	//echo ($cachefile);
	//ob_end_flush(); 
}
?>