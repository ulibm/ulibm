<?php 

function viewpost($dat) {
	global $TID;
	global $_TBWIDTH;
	global $_tmid;
	global $backto;
	global $picalbum;
	global $ismanager;
	global $tmiddata;
	global $postdata;
	global $_VAL_FILE_SAVEPATHurl;
?>	<TABLE noclass=table_border border=0 width="<?php  echo $_TBWIDTH?>" align=center cellspacing=0 cellpadding=2>
<TR valign=top>
	<TD class=table_head width=20%><?php  echo getlang("ชื่อหัวข้อ::l::Topic");?></TD>
	<TD class=table_head ><B><?php 
	if ($dat[ishide]=="yes" && $ismanager==true)	 {
		echo "[<A HREF=\"viewtopic.realdelete.php?setdelete=$dat[id]&picalbum=$picalbum\" style=\"color: darkred; font-weight: bold;\">".getlang("ลบทิ้ง::l::Delete")."</A>] ";
		echo "[<A HREF=\"viewtopic.undelete.php?setdelete=$dat[id]&picalbum=$picalbum\" style=\"color: darkgreen; font-weight: bold;\">".getlang("แสดงข้อความนี้::l::Undelete")."</A>] ";
	}
	$topic=$dat[topic];
	$istopic=strpos($topic, ':');
	if ($istopic!==false) {
		$istopic=true;
		$topica=explode(':',$topic);
		$topicid=trim($topica[0]);
		$topicid=trim($topicid,'.');
		$topicid=trim($topicid);
		$topicida=explode('.',$topicid);
		$topicid="";
		for ($ti=0;$ti<count($topicida)-1;$ti++) {
			//echo "[$topicida[$ti]]";
			$topicid.=".".$topicida[$ti];
		}
		$topicid=trim($topicid,'.');
		$topic=trim($topica[1]);
	} else {
		$istopic=false;
	}
echo $topic ?></B></TD>
</TR>
<TR valign=top>

	<TD class=table_td  style="background-color: white; 
	padding-left: 6px;
	padding-right: 6px;
	padding-bottom: 10px;
	" align=left height=1 colspan=2>
	<div align=right>
	<?php  echo ymd_datestr($dat[dt],'shortdt')?>
<?php 
if (($tmiddata[isans]=="on" && $postdata[iscan_ans]!="no") || $ismanager==true) {
	?> | <A HREF="addtopic.php?ID=<?php echo $dat[boardid]; ?>&replying=<?php  
	if ($dat[nestedid]==0) {
		echo $dat[id];
	} else {
		echo $dat[nestedid];
	}
		
	?>&quote=<?php  echo $dat[id]?>&picalbum=<?php echo $picalbum?>"><?php  echo getlang("ตอบโดยอ้างข้อความ::l::Quote");?></A> <?php 
}
if ($ismanager==true) {
	if (editperm_chk("web-id-$TID")==true) {

?> | <A HREF="addtopic.php?ID=<?php echo $dat[boardid]; ?>&editing=<?php  echo $dat[id]?>&backto=<?php  echo $backto ;?>&picalbum=<?php echo $picalbum?>"><?php  echo getlang("แก้ไข::l::Edit");?></A>
	| <A HREF="viewtopic.setdelete.php?TID=<?php  echo $TID; ?>&setdelete=<?php  echo $dat[id]?>&startrow=<?php  echo $startrow?>&picalbum=<?php echo $picalbum?>" onclick="return confirm('<?php  echo getlang("กรุณายืนยัน::l::Please Confirm");?>');"><?php  echo getlang("ซ่อน::l::Hide");?></A><?php 
	} else {
		echo "  | " .getlang("คุณไม่มีสิทธิ์ลบ/แก้ไข::l::You cannot edit/delete");
	}
	echo "<BR>";
	editperm_dsp("web-id-$TID");
}	

?>&nbsp;</div>
<img src='x' width=1 height=7><BR><?php 
if ($dat[nestedid]==0 && $istopic==true) {
	$chk=tmq("select *,REPLACE(topic,' ','') as topic2 from webpage_articles where nestedid=0 and boardid='$dat[boardid]'  having topic2 like '$topicid%'  order by topic limit 12",false);
	if (tnr($chk)>1) {
		?><img src='../neoimg/spacer.gif' width=250 height=290 align=right><div style="z-index: 100;position:absolute; "><TABLE width=250 align=right cellpadding=1 cellspacing=1
		 border=0 bgcolor=FFCC00  style="filter: alpha (opacity=85);">
		<TR>
			<TD bgcolor="#FFFFCC" ><B><?php echo getlang("หัวข้อที่เกี่ยวข้อง::l::Related articles;");?></B><BR>
		<?php 
		while ($chkr=tmq_fetch_array($chk)) {
			$chkrtopic=$chkr[topic];
			$chkristopic=strpos($chkrtopic, ':');
			if ($chkristopic!==false) {
				$chkrtopica=explode(':',$chkrtopic);
				$topic=trim($chkrtopica[1]);
			}

			$local_subcount=0;
			if ($chkristopic!==false) {
				$local_topica=explode(':',$chkrtopic);
				$local_topic=trim($local_topica[1]);
				$local_subcount=trim($local_topica[0]);
				$local_subcount=trim($local_subcount,'.');
				$local_subcount=explode('.',$local_subcount);
				$local_subcount=count($local_subcount)-1;
			}
			for ($local_subcounti=1;$local_subcounti<=$local_subcount;$local_subcounti++) {
				echo "<B style='color: 888888'>&nbsp;&nbsp;</B>";
			}
			echo "<IMG SRC='../neoimg/Document32.gif' BORDER=0 align=absmiddle width=16 height=16> ";
			if ($chkr[id]<>$dat[id]) {
				echo "<A HREF='viewtopic.php?TID=$chkr[id]&picalbum=$picalbum' class=smaller>";
			} else {
				echo "<font class=smaller>";
			}
			echo "$topic</A><BR>";
		}	
		?></TD>
		</TR>
		</TABLE></div><?php 
	}
}
?>
<?php  echo str_webpagereplacer(stripslashes($dat[text]))?>
</TD>
</TR>

<TR>
		<TD colspan=2 align=right><?php  echo getlang("ผู้โพสท์::l::Poster");?> : 
	<?php 
		echo html_library_name($dat[tmid]);
?></TD></TR>

<?php 
$file=tmq("select * from webpage_article_attatch where postid='$dat[id]' ",false);	
if (tmq_num_rows($file)!=0) {
	?><TR valign=top>
	<TD class=table_head colspan=2 align=center><?php  echo getlang("ไฟล์แนบ::l::Attatch files");?><BR><?php 
		$i=0;
	while ($filer=tmq_fetch_array($file)) {
		$imgpos = strpos("$dat[text]", "/$filer[hidename]");
		//echo "[$imgpos$_VAL_FILE_SAVEPATHurl]";
		$ext=explode('.',$filer[filename]);
		$ext=strtolower($ext[count($ext)-1]);
		$i++;
		if ($imgpos === false && ($ext=="jpg" || $ext=="gif" || $ext=="png" || $ext=="bmp")) {
		 $filer[filename]=addslashes($filer[filename]);
			echo "<a href='$_VAL_FILE_SAVEPATHurl$filer[hidename]'  rel='lightbox[post$r[id]]' title='$filer[filename]'>
			<img src=\"$_VAL_FILE_SAVEPATHurl$filer[hidename]".".thumb.jpg\" border=1 ";
			if ($dat[picalbum]=="yes") {
				echo " width=140 ";
			} else {
				echo " width=80 ";
			}
			echo " bordercolor=000000 style='border-color: black;' align=absmiddle></a> <WBR>";
		}
		/*echo "<B>$i. <a href='$_VAL_FILE_SAVEPATHurl$filer[hidename]' target=_blank>$filer[filename]</a></B>";
		if ($i>=1) {
			echo ", &nbsp;";
		}
		echo "<BR>";*/

}
			if ($dat[picalbum]=="yes") {
			?><center>
<br /><a href="../getfeed.php?feed=articlephoto&postid=<?php  echo $TID;?>" class=feedbtn><img align=absmiddle src="../neoimg/feed-icon-14x14.png" border=0> <?php  echo getlang("Feed Photoes::l::Feed Photoes");?></a>
</center><?php 
			}
?></TD>
</TR>
<?php 
}
	//print_r($dat);	
	
?>
</TABLE><TABLE align=center width="<?php  echo $_TBWIDTH?>" cellpadding=0 cellspacing=0 >
<TR>
	<TD height=5px bgcolor=#330099></TD>
</TR>
</TABLE>
<?php 
}

?>