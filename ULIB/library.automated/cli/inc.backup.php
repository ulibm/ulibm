<?php 
;
//set_time_limit (600);


$bktype="auto";// พ

barcodeval_set("lastbackup-light-date",time());
filelogs("Operate Backup By library",thaidatestr(time()),"BACKUPLOG-$bktype");
$bkfilename="backup-$bktype.sql";
    $path=$dcrs."_output/";

    if (!is_dir($path)) mkdir($path, 0777);

	    chmod($path, 0777);

    if (file_exists($path . "$bkfilename"))
  {

			unlink($path . "$bkfilename");
        }



        $cur_time=date("Y-m-d H:i");

        $tables=tmq_list_tables();//tmq("show tables");

		echo tmq_error();
        $num_tables=tmq_num_rows($tables);
		//echo "num_tables=$num_tables;";
			$forceskipdb=getval("_SETTING","backup-forceskip");
			$forceskipdborig=$forceskipdb;
			$forceskipdb=explode("
",$forceskipdb);

			$stagdeloldtablewhenskip="NO";
			$skipdb=getval("_SETTING","backup-skip");
			$skipdborig=$skipdb;
			$skipdb=explode("
",$skipdb);

		//print_r($forceskipdb);
        $i=0;

        while ($i < $num_tables)
            {

			$newfile="";
            $table = tmq_tablename($tables, $i);

            $i++;

			echo "$table ";
			if (in_array ($table,$skipdb) || in_array ($table,$forceskipdb)) {
				echo " : skip<BR>";
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
			echo " :done.<BR>";
			}



	$gz = gzopen($path . "$bkfilename.gz",'w9');
	gzwrite($gz, file_get_contents($path . "$bkfilename"));
	gzclose($gz);
   ?>