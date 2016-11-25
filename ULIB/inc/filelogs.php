<?php  //พ
function filelogs($cate,$descr="",$forcefilename="") {
	//echo "filelogs($cate,$descr,$forcefilename)";
//	return;
	global $dcrs;
	global $PHPSESSID;
	global $_SERVER;
	$specialadd="";
	if ("$PHPSESSID"=="") {
		$specialadd="specialadd_".rand(0,1000000000);
	}
	$dirname=date("Y_m");
	$logpath="$dcrs/_logs/$dirname/";

	if (!file_exists("$dcrs/_logs/")) {
		mkdir("$dcrs/_logs/");
	}
	if (!file_exists("$logpath")) {
		mkdir($logpath);
	}
	if ($forcefilename!="") {
		$filename = $logpath.'force.'."$forcefilename".'.html';
	} else {
		$filename = $logpath.'logs.'.$PHPSESSID."_".$specialadd.'.html';
	}
		$somecontent = "<TABLE>
		<TR valign=top bgcolor=EEEEEE>
			<TD><B>$cate</B></TD>
			<TD>".$_SERVER[REMOTE_ADDR]."-".$_SERVER[HTTP_VIA]."-".date("Y/m/d H:i:s")."</TD>
			<TD>".($descr)."</TD>
		</TR>
		<TR valign=top>
			<TD colspan=3><PRE>".print_r($_SESSION,true)."</PRE>
<br></TD>
		</TR>
		</TABLE>\n";

		///".print_r(debug_backtrace(),true)."
		// Let's make sure the file exists and is writable first.
		// In our example we're opening $filename in append mode.
		// The file pointer is at the bottom of the file hence 
		// that's where $somecontent will go when we fwrite() it.
		if (!$handle = fopen($filename, 'a+')) {
			 echo "Cannot open file ($filename) ";
			 exit;
		}
	if (is_writable($filename)) {
		// Write $somecontent to our opened file.
		if (fwrite($handle, $somecontent) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
	}
		
	  //  echo "Success, wrote ($somecontent) to file ($filename)";
		
		fclose($handle);
						
}
?>