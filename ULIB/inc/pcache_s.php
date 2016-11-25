<?php // พ
function pcache_s($ccode,$cmin=0,$chrs=0,$forcerecache=false,$setsubdir="") {

	//if (!headers_sent()) {
	//	header('Content-Type: text/html; charset=tis-620');
	//	echo('Content-Type: text/html; charset=tis-620');
	//}
	global $_GET;
	global $_memid;
	global $lang_control_set;
	global $pcache_s_forcestopto_e;
	global $REQUEST_URI;
	if ($cmin==0 && $chrs==0) {
		$chrs=getval("global","pcache_defhrs");
	}
	if ($cmin==0) {
		$cmin=getval("global","pcache_defmin");
	}
	//echo "pcache_s[$cmin/$chrs]";
	if ($cmin==0 && $chrs==0) {
		$pcache_s_forcestopto_e="yes";
		echo "<!-- pcache_s() disabled due to settings   -->";
		return;
	}
	if (getval("global","pcache_defhrs")==-1 && getval("global","pcache_defmin")==-1) {
		$pcache_s_forcestopto_e="yes";
		echo "<!-- pcache_s() disabled due to settings (FORCE -1)   -->";
		return;
	}
//echo "[$chrs/$cmin]";
	global $REQUEST_METHOD;
	$REQUEST_METHOD2=strtolower($REQUEST_METHOD);
	//echo "$REQUEST_METHOD2";
	if ($REQUEST_METHOD2=="post") {
		echo "<!-- pcache_s() disabled due to post_method  -->";
		return; // disable cache on post_method
	}

	if (loginchk_lib("return")==true) {
		echo "<!-- pcache_s() disabled due loginchk_lib()=true -->";
		return; // disable cache on loginchk_lib()=true
	} else {
		//echo "not logedin";
	}
	if ($_memid!="") {
		echo "<!-- pcache_s() disabled due _memid = (member logged in) -->";
		return; // disable cache on loginchk_lib()=true
	} 

	if ($ccode=="autourl") {
		$ccode=$REQUEST_URI."-$lang_control_set-".implode('+',$_GET);
		$ccode=str_replace('?','-',$ccode);
		$ccode=str_replace('/','-',$ccode);
		$ccode=str_replace('=','_',$ccode);
		$ccode=str_replace('&','_',$ccode);

		$ccode=str_replace('__','_',$ccode);
		$ccode=str_replace('__','_',$ccode);
		$ccode=str_replace('__','_',$ccode);
		$ccode=str_replace('__','_',$ccode);

		$ccode=str_replace('--','-',$ccode);
		$ccode=str_replace('--','-',$ccode);
		$ccode=str_replace('--','-',$ccode);
		$ccode=str_replace('--','-',$ccode);

		$ccode=str_replace('__','_',$ccode);
		$ccode=str_replace('--','-',$ccode);
	}
	global $lang_control_val; 
	global $dcrs_pcache;
	global $dcrs_pcache_s_runned;
	global $dcrs_pcache_s_ccode;
	global $dcrs_pcache_s_subdir;
	$dcrs_pcache=trim($dcrs_pcache);
	$setsubdir=trim($setsubdir);
	$setsubdir=str_replace('/','',$setsubdir);

	if ($dcrs_pcache=="") {
		die ("Pcache error \$dcrs_pcache not defined; halting");
	}
	if ($ccode=="") {
		die ("Pcache error \$ccode not entered; halting");
	}
	$ccode=str_replace('/','',$ccode);
	
	//add language detection
	$ccode=$lang_control_val."-".$ccode;

	if (!file_exists("$dcrs_pcache")) { 
	   @mkdir ("$dcrs_pcache", 0777); 
	}
	if ($setsubdir!="") {
		if (!file_exists("$dcrs_pcache/$setsubdir")) { 
		   @mkdir ("$dcrs_pcache/$setsubdir", 0777); 
		}
		$ccode="$setsubdir/$ccode";
	}
	$cachefile = "$dcrs_pcache/$ccode.html";
	$cachetime = ($cmin * 60)+($chrs*60*60);
	// Serve from the cache if it is younger than $cachetime
	
	/*
	if (file_exists($cachefile)) {
		echo "CACHE FILE EXISTS [$cachefile];";
	}
	*/
	if (
			$forcerecache==false &&
			file_exists($cachefile) &&
			(time() - $cachetime < filemtime($cachefile))
		) {
		echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." for '$ccode' <BR> \n-->";
		echo "<!-- timeleft to re-cache is " .number_format(( filemtime($cachefile) +$cachetime) -time() ). " seconds<BR> -->";
		include($cachefile);
		//echo "<!-- Cache ended for '$ccode'  -->\n";
		exit;
	} else {
		//echo "start capture for new cache<BR>\n";
		//echo "file to save cache is: $cachefile\n";
	}
	$dcrs_pcache_s_runned="yes";
	$dcrs_pcache_s_ccode=$ccode;
	$dcrs_pcache_s_subdir=$setsubdir;
	function localpcaches_callback($buffer)
	{
	  // replace all the apples with oranges
	  return (($buffer));
	}
	ob_start("localpcaches_callback"); // Start the output buffer
	ob_start(); // Start the output buffer
}
?>