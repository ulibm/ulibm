<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("cachebrowser");
		pagesection("Cache Browser");
		// พ
if ($dir!="") {
	$test=str_replace($dcrs_pcache,'',$dir);
	if ($dir==$test) {
		filelogs("  - ",$dir,"CACHE-off-zone-limit");
		die('off-zone-limit');
	}
}

if ($erasing!="") {
	$dirtodelete=$dcrs_pcache.$erasing."/";

		$f=fso_listfile("$dirtodelete");
		foreach ($f as $fi) {
			unlink( $dirtodelete."/".$fi);
		}

		rmdir($dirtodelete);

		filelogs("Commit delete cache files",$erasing,"Clearcachefile");
}


?><BR><TABLE align=center width=550>
<?php 

	if ($dir=="") {
		$dir=$dcrs_pcache;
	}
	if (@$handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) { 
			echo "<TR>";
			if ($file != "." && $file != "..") { 
				if (is_dir("$dir/$file")) {
					echo "<TD style=\"border-bottom-style: solid; border-bottom-color: #595959; border-bottom-width: 1px;\"><IMG SRC='../neoimg/View.gif' WIDTH='16' HEIGHT='16' BORDER='0' Align=absmiddle> <A HREF=\"index.php?dir=$dir$file/\">$file</A> </TD><TD><A HREF=\"index.php?dir=$dir&erasing=".($file)."\" onclick=\"return confirm('ERASING LOS(s) CONFIRM?');\"><IMG SRC='../neoimg/Delete.gif' WIDTH='16' HEIGHT='16' BORDER='0' Align=absmiddle> Unlink</A></TD>";
				} else {
					$ext=substr($file,-4);
					
					if ($ext=="html") {
						$stourl=$dir.$file;
						if ($searchme!="") {
							$all=strip_tags(file_get_contents("$dir/$file") );
							$pos = strpos($all, $searchme);
							if ($pos === false) {
								continue;
							}

						}
						echo "<TD><A HREF=\"view.php?f=$stourl\"> <IMG SRC='../neoimg/Book.gif' WIDTH='16' HEIGHT='16' BORDER='0' Align=absmiddle> $file</A></TD><TD>".number_format(filesize($stourl))."</TD>\n";
					}
				}
			} 
			echo "</TR>";
		}
		closedir($handle); 
	}

?> 

</TABLE>


<BR><BR>
<B><CENTER><A HREF="index.php">Back</A></CENTER></B>
<BR><?php 
foot();
?>