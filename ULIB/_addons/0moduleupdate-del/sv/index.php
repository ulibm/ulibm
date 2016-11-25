<?php 
set_time_limit(5);
include("../../../inc/config.inc.php");
include("../info.php");
include("../func.php");
// พ
if ($cmd=="listmodule") {
	//echo $cmd;
	$result=Array();
	$adddir=$dcrs."_addons";
	if ($handle = opendir($adddir)) {
		while (false !== ($file = readdir($handle))) {
			//echo ($adddir."/$file<br>");
			if (is_dir($adddir."/$file")) {
				//echo "$file\n";
				if (substr($file,0,1)==".") {
					continue;
				}
				if (substr($file,0,1)=="_") {
					continue;
				}
				if ($file=="0moduleupdate") {
					//continue; //allow update
				}
				//echo ($adddir."/$file<br>");
				$result[$file]=Array();
				$result[$file][code]=$file;
				@include("$adddir/$file/info.php");
				$result[$file][name]=$addon_name;
				//archive and get md5
				local_archiveit("$adddir/$file/");
				$result[$file][hashdata]=md5_file($dcrs."_addons/$file/archive.tgz");;
				$result[$file][size]=filesize($dcrs."_addons/$file/archive.tgz");;
				/*	include("../archive.php");

	$b = new gzip_file($dir."archive.tgz");*/


			}
		}
	}
	//printr($result);
	$tmp=serialize($result);
	$tmp=base64_encode($tmp);
	echo $tmp;
}
?>