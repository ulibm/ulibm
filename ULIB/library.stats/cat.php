<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();


	
		$_REQPERM="stat-catalog";
	$tbl="media_edittrace";
        mn_lib();
		pagesection("สถิติการลงรายการ::l::Catalog Statistics","stats");
		
		//autoclear
		/*
			 $autoclear=tmq("select id FROM `$tbl` order by id desc limit $_STATCENTER_MAXRECORD,1 ",false);
			 $autoclear=tmq_fetch_array($autoclear);
			 $autoclear=floor($autoclear[id]);
			 if ($autoclear!=0) {
			 		tmq("delete from $tbl where id<$autoclear ",false);
			 }		*/
			 
		if ($yrtoclearstat!="" && library_gotpermission("stat-candelete")) {
				$dts=ymd_mkdt(1,1,$yrtoclearstat);
				$dte=ymd_mkdt(31,12,$yrtoclearstat);

			 tmq("delete from $tbl where dt>$dts and dt<$dte ");
		}
?>
<form method="post" action="<?php  echo $PHP_SELF?>">
	<TABLE width=620 align=center cellspacing=0 class=table_border>

<TR valign=top>
<TD width=50% class=table_head><?php 
echo getlang("เลือกชื่อเจ้าหน้าที่เพื่อดู::l::Select Librarian.");
?></TD>
<TD class=table_td><?php 

form_quickedit("libtoview",$libtoview,"foreign:-localdb-,library,UserAdminID,UserAdminName,allowblank");
?> <input type="submit" value="<?php  echo getlang("เลือก::l::Select");?>"></TD>
</TR>
</TABLE>
</form><BR>
<?php 
if ($libtoview=="") {
	//die;
}

	//USEYEA
	$start=time()-(60*60*24*30*10);
	$end=time();
	$alllen=Array();
	for ($dtrun=$start;$dtrun<=$end;$dtrun+=(60*60*24)) {
			$thisy=date("Y",$dtrun);
			$thism=date("n",$dtrun);
			$alllen[]="$thisy-$thism";
	}
	$alllen=array_unique($alllen);
	$alllen=array_slice($alllen,-12) ;
	$alllen=array_reverse($alllen);
	$mmonthi=0;
	//printr($alllen);

	while (list($dtrunk,$dtrunv)=each($alllen)) {
		$mmonthi++;

		$data=explode('-',$dtrunv);
		$USEYEA=$data[0];
		$USEMON=$data[1];
		$gmdatatitle[Description]["name$mmonthi"]=$thaimonstr[$USEMON]." ".( $USEYEA+543);
		include("cat.table.php");	
		echo "<br />
";		
	}
	if (count($gmdata)>0) {
		echo "<CENTER><A HREF='$dcrURL"."library.stats/graph.php?gid=$gmid'  rel='gb_page_fs[]'   class='smaller2 a_btn'>".getlang("กราฟสรุป::l::Summary Graph")."</A><BR><BR></CENTER>";
	}
	html_dialog("Warning",getlang("ระบบสถิติจะแสดงรายละเอียดแบบตารางย้อนหลังเพียง 12 เดือนเท่านั้น::l::Only last 12 month will display on table style"));

	
	$gmdataall[data]=$gmdata;
	$gmdataall[title]=$gmdatatitle;
	$gmdataall[reporttitle]=getlang("กราฟสรุป ::l::Summary Graph ").$dspname;

	//printr($gmdataall);
	$gmdataalls=serialize($gmdataall);
	sessionval_set($gmid,$gmdataalls);


if (library_gotpermission("stat-candelete")) {
	 ?><br />
<br />

	 <table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>
<form action="<?php  echo $PHP_SELF?>" method="post" onsubmit="return confirm('Please Confirm');">
<input type="hidden" name="db" value="<?php  echo $db;?>" />
<tr><td class=table_head><?php  echo getlang("เคลียร์สถิติ::l::Clear Stat.");?></td>
<td class=table_td>
<select name="yrtoclearstat"><?php 
for($y=$_MSTARTY;$y<=$_MENDY;$y++) {
	echo "<option value='".($y-543)."'>$y";
}
?></select> <input type="submit" value="Clear"><?php 

?></td>
</tr>
</form>
</table>
	 <?php 
}
                foot();
?>