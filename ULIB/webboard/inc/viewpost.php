<?php 

function viewpost($dat) {
	global $TID;
	global $_tmid;
	global $backto;
	global $ismanager;
	global $tmiddata;
	global $postdata;
	global $_VAL_FILE_SAVEPATHurl;
	global $_TBWIDTH;

?>	<TABLE noclass=table_border border=1 width="<?php  echo $_TBWIDTH?>" align=center cellspacing=0 cellpadding=2>
<TR valign=top>
	<TD class=table_head width=20%><?php  echo getlang("ชื่อหัวข้อ::l::Topic");?></TD>
	<TD class=table_head ><B><?php 
	if ($dat[ishide]=="yes" && $ismanager==true)	 {
		echo "[<A HREF=\"viewtopic.realdelete.php?setdelete=$dat[id]\" style=\"color: darkred; font-weight: bold;\">".getlang("ลบทิ้ง::l::Delete")."</A>] ";
		echo "[<A HREF=\"viewtopic.undelete.php?setdelete=$dat[id]\" style=\"color: darkgreen; font-weight: bold;\">".getlang("แสดงข้อความนี้::l::Undelete")."</A>] ";
	}
	
echo str_censor($dat[topic]) ?></B></TD>
</TR>
<TR valign=top>
	<TD class=table_td width=20%><TABLE width=100% cellpadding=3 cellspacing=3>
	<TR>
		<TD align=center style="border-color: blue; border-style: solid; border-width: 1px; background-color: #F0FAFF"><?php  echo getlang("ผู้โพสท์::l::Poster");?> <BR>
	<?php 
	if ($dat[tmid]=="") {
		if ($dat[memid]=="") {
			echo "".getlang("โดย ผู้เยี่ยมชม::l::By visitor");;
			echo "<BR><B>$dat[postername]</B><BR>";
			echo "<B>$dat[postermail]</B>";
			echo "<BR>$dat[inf_ip]";
			$dat[inf_all]=addslashes($dat[inf_all]);
			$dat[inf_all]=str_replace("'",'',$dat[inf_all]);
			$dat[inf_all]=str_replace("\n",'\\n',$dat[inf_all]);
			echo "<B onclick=\"alert('$dat[inf_all]')\">&nbsp;</B>";
		} else {
			echo "<BR><B>$dat[postername]</B><BR>";
			echo "<B>$dat[postermail]</B>";
			echo "<BR>$dat[inf_ip]";
			echo "<BR><FONT class=smaller color=darkblue>".get_member_name($dat[memid])."<BR>($dat[memid])</FONT>";;
		}

	} else {
		echo html_library_name($dat[tmid]);
		echo "($dat[tmid])";
	}

?></TD>
	</TR>
	</TABLE></TD>
	<TD class=table_td  style="background-color: white; 
	padding-left: 6px;
	padding-right: 6px;
	padding-bottom: 10px;
	" align=left height=1>
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
		
	?>&quote=<?php  echo $dat[id]?>"><?php  echo getlang("ตอบโดยอ้างข้อความ::l::Quote");?></A> <?php 
}
if ($ismanager==true) {
?> | <A HREF="addtopic.php?ID=<?php echo $dat[boardid]; ?>&editing=<?php  echo $dat[id]?>&backto=<?php  echo $backto ;?>"><?php  echo getlang("แก้ไข::l::Edit");?></A>
	| <A HREF="viewtopic.setdelete.php?TID=<?php  echo $TID; ?>&setdelete=<?php  echo $dat[id]?>&startrow=<?php  echo $startrow?>" onclick="return confirm('<?php  echo getlang("กรุณายืนยัน::l::Please Confirm");?>');"><?php  echo getlang("ซ่อน::l::Hide");?></A><?php 
}	
?>&nbsp;</div>
<img src='x' width=1 height=7><BR><?php  echo str_censor(stripslashes($dat[text]))?></TD>
</TR>

<?php 
$file=tmq("select * from webboard_post_attatch where postid='$dat[id]' ");	
if (tmq_num_rows($file)!=0) {
	?><TR valign=top>
	<TD class=table_head><?php  echo getlang("ไฟล์แนบ::l::Attatch files");?></TD>
	<TD class=table_td style="background-color: white;"><?php 
		$i=0;
	while ($filer=tmq_fetch_array($file)) {
		$imgpos = strpos("$dat[text]", "/$filer[hidename]");
		//echo "[$imgpos$_VAL_FILE_SAVEPATHurl]";
		$ext=strtolower(substr($filer[filename],-3));
		$i++;
		echo "<nobr><B>$i. ";
		if ($imgpos === false && ($ext=="jpg" || $ext=="gif" || $ext=="png" || $ext=="bmp")) {
			echo "<a href='$_VAL_FILE_SAVEPATHurl$filer[hidename]' target=_blank><img src=\"$_VAL_FILE_SAVEPATHurl$filer[hidename].thumb.jpg\" border=1 width=24 bordercolor=000000 align=absmiddle></a> ";
		}
		echo "<a href='$_VAL_FILE_SAVEPATHurl$filer[hidename]' target=_blank>$filer[filename]</a></B></nobr>";
		if ($i>=1) {
			echo ", &nbsp;<wbr>";
		}
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