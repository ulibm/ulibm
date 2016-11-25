<?php 
;
set_time_limit (3600);

include("../inc/config.inc.php");

if ($push=='yes' && barcodeval_get("activateulib-status")=="registered") {
	if (!file_exists("../_output/backup-full.sql.gz")) {
		die("backup file (.gz) not exists");;
	}
	html_start();
	?><style>
	BODY {
		background-color: #FFF3CE;
	}	
	</style><?php 
	 echo "<BR><CENTER><img src='../neoimg/upload-32.png' align=absmiddle> <A HREF='".getval("SYSCONFIG","ulibmasterurl")."/activateulib/bkpush/index.php?certid=".barcodeval_get("activateulib-refcode")."'>Push to <B>ULibM Central</B></A></CENTER>";
	die;
}
head();
$_REQPERM="fullbackup";
$tmp=mn_lib();
if ($bktype=="") {
	html_dialog("Error",getlang("กรุณากด Back ไปเลือกรูปแบบการสำรองข้อมูลด้วย::l::Please click Back on your browser to select backup type"));	
	foot();
	die;
}

if ($bktype=="MAX") {

	include("archive.php");
	$b = new gzip_file("_output/maxbackup.tgz");
	$b->set_options(array('basedir' => "$dcrs", 'overwrite' => 1, 'level' => 1));
	//$b->set_options(array( 'overwrite' => 1, 'level' => 1));
	if (!file_exists($dcrs."_output/maxbackup.tgz")) {
		touch($dcrs."_output/maxbackup.tgz");
	}
	if (!file_exists($dcrs."_output/maxbackup.tgz.tmp")) {
		touch($dcrs."_output/maxbackup.tgz.tmp");
	}
	$b->add_files(array("$dcrs"));
	$b->exclude_files($dcrs."_output/*");
	/*
	$b->exclude_files("_output/*.tgz");
	$b->exclude_files("_output/*.tmp");
	$b->exclude_files("_output/maxbackup.tgz");
	$b->exclude_files("_output/maxbackup.tgz.tmp");
	*/
	//printr($b->exclude);
	$b->exclude_files($dcrs."_logs/*");
	$b->exclude_files($dcrs."_input/*");
	$b->exclude_files($dcrs."_session/*");
	$b->exclude_files($dcrs."_cache/*");
	//$b->make_list();
	//printr($b->files);
	echo count($b->files);
	//die;
	$b->create_archive();
	if (count($test->errors) > 0) {
		print ("Errors occurred."); // Process errors here
	}
	barcodeval_set("lastbackup-MAX-date",time());
	$now=time();
	//$newname=randid()."_maxbackup.tgz";
	//@rename("../_output/maxbackup.tgz","../_output/".$newname);
	tmq("update backup_log set filename='deleted' where filename='maxbackup.tgz' ");
	tmq("insert into backup_log set
	dt='$now',
	type1='max',
	useradmin='$useradminid',
	filename='$bkfilename'
	");
		echo " <center>done.</center>";
	redir("index.php",1);

	die;
}
?>

<html>

    <head>

        <title> :: Backup <?php  echo getlang("เสร็จเรียบร้อย::l::Complete"); ?></title>

        <style type = "text/css">

body

    {

    font-family: "verdana", sans-serif

    }

        </style>

    </head>
<BR><BR><BR><BR>
	<TABLE width=650 align=center>
	<TR>
		<TD><div style="width: 650px; height: 300px; display:block; overflow:scroll;" ID=datadspdiv>
<script>
function localautoscroll() {
   elem = getobj('datadspdiv');
   elem.scrollTop = elem.scrollHeight;
}
var autoscrolltimeout=setInterval("localautoscroll();",100);
</script>
<?php 

barcodeval_set("lastbackup-$bktype-date",time());
filelogs("Operate Backup",thaidatestr(time()),"BACKUPLOG-$bktype");

$bkfilename="backup-$bktype.sql";
	$now=time();
	$newname=randid()."_$bkfilename";
	@rename("../_output/$bkfilename","../_output/".$newname);
	tmq("update backup_log set filename='$newname' where filename='$bkfilename' ");
	tmq("insert into backup_log set
	dt='$now',
	type1='$bktype',
	useradmin='$useradminid',
	filename='$bkfilename'
	");
	//keep last 30
	$sbk=tmq("select * from backup_log order by dt desc");
	$sbki=0;
	while ($sbkr=tfa($sbk)) {
		$sbki++;
		if ($sbki<=30) {
			continue;
		}
		if ($sbkr[filename]!="" && $sbkr[filename]!="deleted") {
			@unlink("../_output/$sbkr[filename]");
			tmq("delete from backup_log where id='$sbkr[id]' ",false);
		}
	}
    flush();

    $path=$path . "../_output/";

    if (!is_dir($path))

        mkdir($path, 0777);

		chmod($path, 0777);

		if (file_exists($path . "$bkfilename")) {

			@unlink($path . "$bkfilename");
        }



        $cur_time=date("Y-m-d H:i");

        $tables=tmq_list_tables();;

		//printr($tables);
        $num_tables=tmq_num_rows($tables);

		//echo "[num_tables=$num_tables]";
			$forceskipdb=getval("_SETTING","backup-forceskip");
			$forceskipdborig=$forceskipdb;
			$forceskipdb=explodenewline($forceskipdb);
		if ($bktype=="light") {
			$stagdeloldtablewhenskip="NO";
			$skipdb=getval("_SETTING","backup-skip");
			$skipdborig=$skipdb;
			$skipdb=explodenewline($skipdb);
		} else {
			$stagdeloldtablewhenskip="YES";
			$skipdb=Array();
		}
		//print_r($forceskipdb);
        $i=0;

        while ($i < $num_tables)
            {

			$newfile="";
            $table = tmq_tablename($tables, $i);

				//echo "[$table]";
            $i++;

			echo "<IMG SRC='../neoimg/Green.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='' align=absmiddle> Operating ... $table";
			if (in_array ($table,$skipdb) || in_array ($table,$forceskipdb) || $table=="addonsdb_serverwatch_log") {
				echo " <I style='color: #990000'>skip</I>.<BR>";
				$newfile.=get_def($dbname, $table, "$stagdeloldtablewhenskip");
				$newfile.="\n\n";
				fso_file_write($path . "$bkfilename","a",$newfile);
				continue;
			}
            $newfile.=get_def($dbname, $table);

            $newfile.="\n\n";

            $newfile.=get_content($dbname, $table);

            $newfile.="\n\n";

			fso_file_write($path . "$bkfilename","a",$newfile);
			echo " <I style='color: darkgreen;'>done</I>.<BR>";
			}

	$gz = gzopen($path . "$bkfilename.gz",'w9');
	gzwrite($gz, file_get_contents($path . "$bkfilename"));
	gzclose($gz);


?>
</div>
</TD>
	</TR>
	</TABLE>
    <CENTER>

        <BR>

        <BR>

        <TABLE WIDTH = "750">

            <TR>

                <TD>

                    <H1> :: <?php  echo getlang("การสำรองข้อมูลเสร็จเรียบร้อย::l::Backup complete"); ?></H1>

                    <BR> <!--

                     <b>Your backup request was processed.</b> If you did not receive any errors on the screen, then 

                     you should find a directory called "dump" (without the quotes) in the sub-directory that you 

                     created when you installed MySQL PHP Helper. In the "dump" directory, you should find a file 

                     titled "backup.sql" (without the quotes). This file is an unzipped backup of your database and 

                     must have the same name if you wish to do a restore using MySQL PHP Helper. Also you may zip 

                     the backup, but before restoring, you must unzip the backup before proceeding with the restore.

                     <BR><BR>-->


				<BLOCKQUOTE>
				<B><?php  echo getlang("หมายเหตุ :: ไฟล์ต่อไปนี้ถูกยกเว้นไม่ให้ได้รับการ Backup::l::Note :: following tables are skipped form backup"); ?></B><BR><BR><?php  
$skipdb = array_merge($skipdb, $forceskipdb);
$skipdb = array_unique($skipdb);
foreach ($skipdb as $a) {
	echo "<nobr><IMG SRC='../neoimg/Seal.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='' align=absmiddle> $a </nobr><wbr>";
}
?>

</BLOCKQUOTE>                </TD></TR></TABLE>

        <BR>

        <BR>
        <B><A HREF = "get.php?mode=<?php  echo $bktype; ?>" target = _blank><?php  echo getlang("ดาวน์โหลดไฟล์ข้อมูล::l::Download backup file"); ?></A></B> [<?php  echo getlang("คลิกขวาแล้วเลือก::l::Right-click then choose"); ?> Save Target As....]


        <BR>

        <B><A HREF = "get.php?mode=<?php  echo $bktype; ?>&iszip=.gz" target = _blank><?php  echo getlang("ดาวน์โหลดไฟล์ข้อมูล::l::Download backup file"); ?></A></B> (<?php echo getlang("บีบอัดแล้ว::l::Compressed")?>)

        <BR>

        <BR>
<script>

clearTimeout(autoscrolltimeout);
</script>
		<?php 
$cl=barcodeval_get("activateulib-status");
if (!file_exists("../_output/backup-full.sql.gz")) {
if ($cl=="registered") {
	?><div align=center><iframe src="backup.php?push=yes&picker=<?php  echo randid();?>" align=absmiddle FRAMEBORDER="no" BORDER=0
 SCROLLING=NO width=420 height=80 style="float:center"></iframe></div><?php 
}
}
		?>
<!--

phpMyBackup Copyright &copy; 2000-2001 by Holger Mauermann.<br>

MySQL PHP Helper Copyright &copy; 2002 by zMola Washer.<br><br>

-->

        <?php 

foot();        ?>