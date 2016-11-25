<?php 
function local_archiveit($dir,$mode="") {
//echo "local_archiveit($dir,$mode);";
	global $dcrs;// พ
	//echo($dcrs."_addons/moduleupdate/archive.php");
	include_once($dcrs."_addons/0moduleupdate/archive.php");
	//echo $dir."<BR>";die;;
	if (!file_exists($dir."archive.tgz")) {
		touch($dir."archive.tgz");
	}
	if (!file_exists($dir."archive.tgz.tmp")) {
		touch($dir."archive.tgz.tmp");
	}
	if (!file_exists($dir."localarchive.tgz")) {
		touch($dir."localarchive.tgz");
	}
	if (!file_exists($dir."localarchive.tgz.tmp")) {
		touch($dir."localarchive.tgz.tmp");
	}
	$b = new gzip_file($dir.$mode."archive.tgz");
	$b->set_options(array('basedir' => "$dir", 'overwrite' => 1, 'level' => 0,'storepaths' => 0));
	//$b->set_options(array( 'overwrite' => 1, 'level' => 1));
	   $fss=fso_listfile($dir);
   //printr($fss);
   @reset($fss);
   $filestozip=Array();
   while (list($k,$v)=each($fss)) {
      if (!is_dir($dir."/".$v)) {
         $ext=strtolower(substr($v,-4));
         if ($ext==".tmp") continue;
         if ($ext==".log") continue;
         if ($ext==".bak") continue;
         if ($ext==".tgz") continue;
         if ($ext=="s.db") continue;
         $filestozip[]=$v;
      }
   }

	$b->add_files($filestozip);/*
   	$b->exclude_files($dir."*.tmp");
	$b->exclude_files($dir."*.log");
	$b->exclude_files($dir."*.db");
	$b->exclude_files($dir."*.gz");
	$b->exclude_files($dir."*.tgz");
	$b->exclude_files($dir."*.bak");
   
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

}
?>