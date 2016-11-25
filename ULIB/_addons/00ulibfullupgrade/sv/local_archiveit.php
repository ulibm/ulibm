<?php
function local_archiveit($dir,$mode="") {
//echo "local_archiveit($dir,$mode);";
	global $dcrs;// พ
	global $dcrURL;// พ
	//echo($dcrs."_addons/moduleupdate/archive.php");
	//echo $dir."<BR>";die;;
   $aname=substr($dir,strlen($dcrs));
   $aname=str_replace("/","__",$aname);
   $aname=trim($aname,"= ");
   if ($aname=="") {
      $aname="___root___";
   }
   //echo "[aname=$aname]";
   $output=$dcrs."_addons/00ulibfullupgrade/sv/out/$aname.tgz";
   $outputurl=$dcrURL.substr($output,strlen($dcrs));
   
   //echo("$outputurl"); die;
   //echo("$output"); die;
   //echo "output=$output<BR>   dir=$dir";
   @unlink($output);
   @unlink($output.".tmp");
   /*
	if (!file_exists($output)) {
		touch($output);
	}
	if (!file_exists($output.".tmp")) {
		touch($output.".tmp");
	}*/
   /*
	if (!file_exists($dir."localarchive.tgz")) {
		touch($dir."localarchive.tgz");
	}
	if (!file_exists($dir."localarchive.tgz.tmp")) {
		touch($dir."localarchive.tgz.tmp");
	}*/
   
	$b = new gzip_file($output);
	$b->set_options(array('basedir' => "$dir", 'overwrite' => 1, 'level' => 3,'storepaths' => 0));
	//$b->set_options(array( 'overwrite' => 1, 'level' => 1));
	//$b->add_files(array("$dir"));
   $fss=fso_listfile($dir);
   //printr($fss);
   @reset($fss);
   $filestozip=Array();
   while (list($k,$v)=each($fss)) {
      if (!is_dir($dir."/".$v)) {
         $ext=strtolower(substr($v,-4));
         $ext3=strtolower(substr($v,-3));
         if ($v=="c.inc.php") continue;
         if ($v=="config.inc.sv.php") continue;
         if ($ext3==".gz") continue;
         if ($ext==".psd") continue;
         if ($ext==".bak") continue;
         if ($ext==".sql") continue;
         if ($ext==".exe") continue;
         if ($ext==".zip") continue;
         if ($ext==".tmp") continue;
         if ($ext==".tgz") continue;
         if ($ext=="s.db") continue;
         $filestozip[]=$v;
      }
   }
   //printr($filestozip);
	$b->add_files($filestozip);
	//$b->add_files(array("index.php"));
      //echo "here";
	//$b->exclude_files($dir."/*.zip");

   /*
	$b->exclude_files($dir."archive.tgz");
	$b->exclude_files($dir."archive.tgz.tmp");
	$b->exclude_files($dir."localarchive.tgz");
	$b->exclude_files($dir."localarchive.tgz.tmp");
	$b->exclude_files($dir."*.tmp");
	$b->exclude_files($dir."*.log");
	$b->exclude_files($dir."*.bak");*/
	/*
	$b->exclude_files("_output/*.tgz");
	$b->exclude_files("_output/*.tmp");
	$b->exclude_files("_output/maxbackup.tgz");
	$b->exclude_files("_output/maxbackup.tgz.tmp");
	$b->exclude_files($dcrs."_logs/*");
	$b->exclude_files($dcrs."_input/*");
	$b->exclude_files($dcrs."_session/*");
	$b->exclude_files($dcrs."_cache/*");
	*/
	//printr($b->exclude);
	//$b->make_list();
	//printr($b->files);
	//echo count($b->files);

	//die;
	$b->create_archive();
	if (count($test->errors) > 0) {
		print ("Errors occurred."); // Process errors here
	}
   return $outputurl;
}
?>