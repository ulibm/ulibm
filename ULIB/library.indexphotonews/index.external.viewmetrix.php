<?php 

        include ("../inc/config.inc.php");
        include ("./_REQPERM.php");
        include ("./cfg.inc.php");
		//head();
        //mn_lib();
		html_start();
$now=time();
	$showcase="select * from webpage_indexphotonews where cate='news' and dtstart<=$now and dtend>=$now order by dt desc limit 8 ";
	$showcase=tmq($showcase,false);


if (tmq_num_rows($showcase)==0) {
	die("-");
}
//html_start();
if ($bgcolor=="") {
	$bgcolor="#C9C9C9";
} 
		$set_width=floor($set_width);
		$set_height=floor($set_height);
		if ($set_width==0) {
			$set_width=400;
		}
		if ($set_height==0) {
			$set_height=280;
		}
?>
<TABLE width=100% align=center border=0 cellpadding=0 cellspacing=0>
<TR>
	<TD >


<?php 


	if (tmq_num_rows($showcase)!=0) {
		//index_sepper(getlang("รายการที่น่าสนใจ"));
		while ($r=tmq_fetch_array($showcase)) {
		?><TABLE width="<?php echo floor($set_width/2)-10?>" cellpadding=2 cellspacing=0 border=0 style="float:left;" height=70>
		<TR valign=top>
			<TD width=107><?php 
			if ($r[linkto]!="") {
				echo "<A HREF='$r[linkto]' target=_blank TITLE='".stripslashes($r[title])."'>";
			} else {
				echo "<A HREF='$dcrURL/library.indexphotonews/view.php?id=$r[id]' target=_top TITLE='".stripslashes($r[title])."'>";
			}
			$img=fft_upload_get("webpage_indexphotonews","coverimg",$r[id]);

			echo "<img src='$img[url]' width=107 height=60 border=0>";
		echo "</A>";
?></TD>
			<TD align=left><A HREF="<?php  
			if ($r[linkto]!="") {
				echo "$r[linkto]";
			} else {
				echo "$dcrURL/library.indexphotonews/view.php?id=$r[id]";
			}

//echo "$dcrURL/library.indexphotonews/view.php?id=$r[id]";

?>" target=_top style="font-family:Tahoma; font-size:13; color:blue;text-decoration:none"><?php  
	$title= stripslashes($r[title]);
	if (mb_strlen($title)>50) {
		$title=mb_substr($title,0,50)."..";
	}
	echo $title;
?></A></TD>
		</TR>
		</TABLE><?php 
			//show_mediaicon($r[randid],"show","yes",100,180);
		}
	}
?>
</TD>
</TR>
<TR>
	<TD><A HREF='<?php  echo "$dcrURL/library.indexphotonews/index.php"?>' target=_top  style="font-family:Tahoma; font-size:11; color:blue">ข่าวทั้งหมด</A>
</TD>
</TR>
</TABLE>

<?php 

?>