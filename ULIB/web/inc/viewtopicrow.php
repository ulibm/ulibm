<?php  
function viewtopicrow($r,$mode="normal") {
	global $_tmid;
	global $kw;
	global $picalbum;
	global $_VAL_FILE_SAVEPATHurl;
	global $ismanager;
	global $_topicstatus;
	global $row_per_page;
if ($r[ishide]=="yes" && $ismanager !=true  ) {
	return;
}
?>
<TR bgcolor=white valign=top>
<!-- 	<TD >
	<?php  
//echo ymd_datestr($r[dt],'shortd');
?><?php  
if (strpos($r[viewers],",$_tmid,")===false) {
	$img="red-small";
} else {
	$img="green-small";
}

?><IMG SRC="./<?php echo $img?>.gif" BORDER="0" <?php echo $_topicstatus[$img];?>></TD> -->

	<TD noclass=table_td>
	<?php  
	if ($mode=="pin") {
		echo "<B>".getlang("ปักหมุด::l::Pinned")."</B>:";
	}
	if ($kw!="") {
		$r[topic]=str_replace($kw,"<U>$kw</U>",$r[topic]);
	}
	$topic=$r[topic];
	$istopic=strpos($topic, ':');
	$subcount=0;
	if ($istopic!==false) {
		$topica=explode(':',$topic);
		$topic=trim($topica[1]);
		$subcount=trim($topica[0]);
		$subcount=trim($subcount,'.');
		$subcount=explode('.',$subcount);
		$subcount=count($subcount)-1;
	}

	for ($subcounti=1;$subcounti<=$subcount;$subcounti++) {
		echo "<B style='color: 666666'>&nbsp;&nbsp;+-</B>";
	}
	echo "<A HREF='viewtopic.php?TID=$r[id]&picalbum=$picalbum'>";
	?><IMG SRC="../neoimg/Document32.gif" BORDER="0" align=absmiddle>
	
	<FONT  COLOR="#556480"><font style='font-size: 16px;font-weight:bold'><?php 
	if ($ismanager==true)	 {
		echo "<FONT COLOR=darkred>$topica[0]</FONT>";
	}		
	echo str_webpagereplacer(stripslashes($topic));?></font></A><BR><?php  
	if ($r[ishide]=="yes" && $ismanager==true)	 {
		echo "[<A HREF=\"viewtopic.realdelete.php?setdelete=$r[id]&picalbum=$picalbum\" style=\"color: darkred; font-weight: bold;\">".getlang("ลบทิ้ง::l::Delete")."</A>] ";
		echo "[<A HREF=\"viewtopic.undelete.php?setdelete=$r[id]&picalbum=$picalbum\" style=\"color: darkgreen; font-weight: bold;\">".getlang("แสดงข้อความนี้::l::Unhide")."</A>] ";
	}
$tmp=tmq("select * from webpage_articles where nestedid='$r[id]' and ishide<>'yes' ");
	$anscount=tmq_num_rows($tmp);

	if ($anscount>$row_per_page) {
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo pageengine(1,$anscount,"viewtopic.php?TID=$r[id]","","nohtml");
	}
	?></TD>
	<!-- <TD align=center noclass=table_td><?php  
	echo "$anscount";
	$tmp=tmq("select * from webpage_articles where nestedid='$r[id]' and ishide='yes' ");
	$anscount2=tmq_num_rows($tmp);
	if ($anscount2!=0) {
		echo "<nobr>(".getlang("ซ่อน::l::Hidden")." $anscount2)</nobr>";
	}
	?></TD> -->
	<TD align=center noclass=table_td><?php  
	if ($r[tmid]=="") {
		echo getlang("โดย ผู้เยี่ยมชม::l::By visitor");
	} else {
		echo get_library_name($r[tmid]); 
	}
	?></TD>
	<!-- <TD align=center noclass=table_td style='font-size: 12px;'><?php  
	if ($mode=="search") {
		$tmp=tmq("select * from webboard_boardcate where id='$r[boardid]' limit 1 ");
		$tmp=tmq_fetch_array($tmp);
		echo "<nobr style='font-size: 12px;'>".getlang($tmp[name]);
	} else {
		$tmp=tmq("select * from webpage_articles where nestedid='$r[id]' and ishide<>'yes' order by lastactive desc limit 1 ");
		if (tmq_num_rows($tmp)==0) {
			echo "<FONT  COLOR=darkgray style='font-size: 12px;'>".getlang("ยังไม่มีผู้ตอบ::l::No reply")."</FONT>";
		} else {
			$tmp=tmq_fetch_array($tmp);
			if ($tmp[tmid]=="") {
				echo ymd_datestr($tmp[dt],"shortdt");
				echo "<BR>".getlang("โดย ผู้เยี่ยมชม::l::By visitor");;
			} else {
				echo ymd_datestr($tmp[dt],"shortdt");
				echo "<BR><nobr><FONT COLOR=777777  style='font-size: 12px;'> ".getlang("โดย ::l::By ")." ".get_library_name($tmp[tmid])."</FONT></nobr>";
			}
		}
	}
	?></TD> -->

	</TD>
</TR>
<?php  
	if ($r[picalbum]=="yes")	 {
	?>
<TR>

	<TD colspan=4 style='padding-left: 50px;'><?php  
	$file=tmq("select * from webpage_article_attatch  where postid='$r[id]' limit 6 ");	
		$i=0;
	while ($filer=tmq_fetch_array($file)) {
		//print_r($filer);
		$imgpos = strpos("$dat[text]", "/$filer[hidename]");
		//echo "[$imgpos$_VAL_FILE_SAVEPATHurl]";
		$ext=explode('.',$filer[filename]);
		$ext=strtolower($ext[count($ext)-1]);
		$i++;
		if ($imgpos === false && ($ext=="jpg" || $ext=="gif" || $ext=="png" || $ext=="bmp")) {
		$imgurl="$_VAL_FILE_SAVEPATHurl$filer[hidename]";
		 $filer[filename]=addslashes($filer[filename]);
			echo "<a href='$imgurl' rel='lightbox[post$r[id]]' title='$filer[filename]'><img src=\"$imgurl.thumb.jpg\" border=1 width=80 bordercolor=000000 align=absmiddle style='border-color: #000000'></a> ";
		}
		/*
		echo "<B>$i. $filer[filename]</B>";
		if ($i>=1) {
			echo ", &nbsp;";
		}*/
	}
	?></TD>
</TR>
<?php  
	}
}
?>