<?php 

    ;

    //echo "$loginadmin sdfgsdfgsdf";

include("../inc/config.inc.php");
//print_r($_SERVER);
$tmp1=getval("SYSCONFIG","ulibmasterurl");
$tmp2=md5(barcodeval_get("activateulib-refcode"));
//echo $certid."-".$tmp2."\n"; 
if ($tmp2!=$certid) {
   loginchk_lib();
}
// พ
//echo $filename;
if ($filename!="") {
	$filename=base64_decode($filename);
	//echo $filename;
	header("Content-Disposition: attachment; filename=\"ulibbackup.".date("Y-m-d").".$filename\"\n"); 
	header ("Content-Type: application/download\n");
	//header ("Content-Disposition: attachment; filename=\"./dump/backup.sql\"");
	//die;
	$fd=fopen("../_output/$filename", "r");
	while ($line=fgets($fd, 1000)) {
		//    $alltext.=$line;
			echo $line;
	}
	fclose ($fd);
	die;
}
        //header("file-name: bak.bak\n");

		if ($mode=="MAX") {
			header("Content-Disposition: attachment; filename=\"ulib-backup.MAX.".date("Y-m-d").".tgz\"\n"); 
			header ("Content-Type: application/download\n");
			//header ("Content-Disposition: attachment; filename=\"./dump/backup.sql\"");
			//die;
			$fd=fopen("../_output/maxbackup.tgz", "r");
			while ($line=fgets($fd, 1000)) {
				//    $alltext.=$line;
					echo $line;
			}
			fclose ($fd);

			die;
		}
		header("Content-Disposition: attachment; filename=\"ulib-backup.".date("Y-m-d").".$mode-backup$iszip\"\n"); 
        header ("Content-Type: application/download\n");

        //header ("Content-Disposition: attachment; filename=\"./dump/backup.sql\"");

        //die;

        $fd=fopen("../_output/backup-$mode.sql$iszip", "r");

        while ($line=fgets($fd, 1000))

            {

            //    $alltext.=$line;

            echo $line;

            }

        fclose ($fd);

?>