<?php 
set_time_limit(5);// พ
include("../../../inc/config.inc.php");
include("../info.php");
include("../func.php");
$cmd=trim($cmd);
if ($cmd=="listmodule") {
	//echo "here";
	$result=tmq_dump2("addonsdb_0ulibupdate","id","code,name,descr"," where isshow='yes' ");
	//printr($result); 
	//echo "xx$result;";
	$tmp=serialize($result);
	//printr($tmp);
	$tmp=base64_encode($tmp);
	echo $tmp;

}
$sectionname=base64_decode($sectionname);
$sectionname=trim($sectionname);
$sectionname=strtolower($sectionname);
//printr($_GET);
if ($cmd=="getsectiondetail"&& $sectionname!="") {
	$result=tmq_dump2("addonsdb_0ulibupdate","id","code,name,descr"," where isshow='yes' and code='$sectionname' ");
	//printr($result);
	if (count($result)!=1) {
		die("section $sectionname not found");
	}
	list($k,$v)=each($result);
	$tmp=$v;
   //echo "here";
	$inf=local_archiveit_getinfo($dcrs."".$sectionname);
	//printr($inf);
	$tmp[hashdata]=$inf[hashdata];
	$tmp[size]=$inf[size];
	$tmp=serialize($tmp);
	$tmp=base64_encode($tmp);
	echo $tmp;

}
$getsectionname=base64_decode($getsectionname);
$getsectionname=trim($getsectionname);
$getsectionname=strtolower($getsectionname);
if ($cmd=="getsection"&& $getsectionname!="") {
	$result=tmq_dump2("addonsdb_0ulibupdate","id","code,name,descr"," where isshow='yes' and code='$getsectionname' ");
	if (count($result)!=1) {
		die("section $getsectionname not found");
	}
	list($k,$v)=each($result);
	$tmp=$v;
	//printr($tmp); die;
	$inf=local_archiveit_getinfo($dcrs."".$getsectionname,"download");
	//printr($inf);
	$tmp[hashdata]=$inf[hashdata];
	$tmp[size]=$inf[size];
	$tmp[dlfilename]=$inf[dlfilename];
	$tmp=serialize($tmp);
	$tmp=base64_encode($tmp);
	echo $tmp;

}
if ($cmd=="xxxx") {
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
				if ($file=="moduleupdate") {
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