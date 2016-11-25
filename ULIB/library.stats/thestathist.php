<?php 
	; 
		
        include ("../inc/config.inc.php");
        include ("./inc.local.php");
		head();

if ($mode=="") {
	$mode="table";
}

	$gmdata=Array();
	$gmdatatitle=Array();
	$gmdatatitle[Position]="Statistics";
	$gmid="graph_gdata:thestathist_all:$db";

		$sdbs=tmq("select * from library_modules where code='stat-cir-stathist_$db' ");
		if (tmq_num_rows($sdbs)==0) {
			die("library_modules where code='stat-cir-stathist_$db'");
		}
		$sdbs=tmq_fetch_array($sdbs);
		$sdb=local_getsdb_thestathist();
		$_REQPERM=$sdbs[code];
		$tbl="stathist_$db";
        $tmpdsp=mn_lib();

		$tmpdsp=str_replace('[ROOMWORD]',$_ROOMWORD,$tmpdsp);
		$tmpdsp=str_replace('[FACULTYWORD]',$_FACULTYWORD,$tmpdsp);

		pagesection("".$tmpdsp,"stats");
		//pagesection($sdb["checkout_member_libsite"][name],"stats");
		
		//autoclear
			 $autoclear=tmq("select id FROM `$tbl` order by id desc limit $_STATCENTER_MAXRECORD,1 ",false);
			 $autoclear=tmq_fetch_array($autoclear);
			 $autoclear=floor($autoclear[id]);
			 if ($autoclear!=0) {
			 		tmq("delete from $tbl where id<$autoclear ",false);
			 }		
			 
		if ($yrtoclearstat!="" && library_gotpermission("stat-candelete")) {
			 tmq("delete from $tbl where yea='$yrtoclearstat' ");
		}
?>
<TABLE width=620 align=center cellspacing=0 class=table_border>
<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF;?>">	
<TR valign=top>
<TD width=50% class=table_head><?php 
echo getlang("กำลังดูข้อมูล::l::Displaying stat.");
?></TD>
<TD class=table_td><?php 
echo getlang($sdb[$db][name]);

$gmdatatitle[Description]["name$monthi"]=getlang($sdb[$db][name]);

?></TD>
</TR>
<?php  if ($sdb[$db][nolimitfoot]!="yes") {?>
<TR valign=top>
<TD width=50% class=table_head><?php 
echo getlang("เลือกหัวข้อ::l::Pick Category");
  ?></TD>
  <TD class=table_td><?php 
  	$s=tmq("select distinctrow foot from $tbl order by foot");
  
  ?><SELECT NAME="limitfoot">
  	<OPTION VALUE="" SELECTED><?php  echo getlang("ไม่กำหนด::l::Not limit");?>
  	<?php 
  	while ($r=tmq_fetch_array($s)) {
  		$dspname="";
  		$dspname=$r[foot];
  		$dspname=local_getdspstr($dspname,$sdb[$db][footmode]);
  		$sl="";
  		if ($r[foot]==$limitfoot) {$sl="selected";}
  		echo "<OPTION VALUE='$r[foot]' $sl>$dspname";
  	}
  	?>	
  </SELECT></TD>
  </TR>
<?php  } ?>	
<TR valign=top>
<TD width=50% class=table_head><?php 
echo getlang("เลือกวันเริ่มนับ::l::Limit start date");
?></TD>
<TD class=table_td><?php 
if ($limitdates_dat=="") {
	$dts=time()-(60*60*24*30);
	$limitdates=time()-(60*60*24*30);
} else {
	$limitdates=form_pickdt_get("limitdates");
	$dts=$limitdates;
}
form_pickdate("limitdates",$dts);
?></TD>
</TR>
<TR valign=top>
<TD width=50% class=table_head><?php 
echo getlang("เลือกวันสิ้นสุด::l::Limit end date");
?></TD>
<TD class=table_td><?php 
if ($limitdatee_dat=="") {
	$dts=time();
	$limitdatee=time();
} else {
	$limitdatee=form_pickdt_get("limitdatee");
	$dte=$limitdatee;
}
form_pickdate("limitdatee",$dte);
?></TD>
</TR>
<TR valign=top>
<TD width=50% class=table_head></TD>
<TD class=table_td><INPUT TYPE="submit" ></TD>
</TR>

<INPUT TYPE="hidden" NAME="mode" value="<?php  echo $mode;?>">
<INPUT TYPE="hidden" NAME="db" value="<?php  echo $db;?>">
</FORM>
</TABLE><BR>
<?php 
$tmp[detail]="1";
$tmp[table]="2";
$addquery="limitdatee_dat=$limitdatee_dat&limitdatee_mon=$limitdatee_mon&limitdatee_yea=$limitdatee_yea&limitdates_dat=$limitdates_dat&limitdates_mon=$limitdates_mon&limitdates_yea=$limitdates_yea";

$tabstr=$tmp[$mode]."::b::".getlang("สถิติละเอียด::l::Detailed style").",thestathist.php?db=$db&mode=detail&$addquery";
if ($sdb[$db][notablemode]!="yes") {
  $tabstr.="::".getlang("ตารางความถี่::l::Frequency Table").",thestathist.php?db=$db&mode=table&$addquery";
} 
html_xptab($tabstr);

$limitdatee+=(60*60*24);

if ($mode=="detail") {
	include("thestathist.detail.php");
}
if ($mode=="table") {
	//USEYEA
	$start=$limitdates;
	$end=$limitdatee;
	$alllen=Array();
	for ($dtrun=$start;$dtrun<=$end;$dtrun+=(60*60*24)) {
			$thisy=date("Y",$dtrun);
			$thism=date("n",$dtrun);
			$alllen[]="$thisy-$thism";
	}
	$alllen=array_unique($alllen);
	$alllen=array_slice($alllen,-6) ;
	$alllen=array_reverse($alllen);

	$mmonthi=0;
	while (list($dtrunk,$dtrunv)=each($alllen)) {
		$mmonthi++;
		$data=explode('-',$dtrunv);
		$USEYEA=$data[0];
		$USEMON=$data[1];
		$gmdatatitle[Description]["name$mmonthi"]=$thaimonstr[$USEMON]." ".( $USEYEA+543);
		include("thestathist.table.php");	
		echo "<br />
";		
	}
	if (count($gmdata)>0) {
		echo "<CENTER><A HREF='$dcrURL"."library.stats/graph.php?gid=$gmid'  rel='gb_page_fs[]'   class='smaller2 a_btn'>".getlang("กราฟสรุป::l::Summary Graph")."</A><BR><BR></CENTER>";
	}

	html_dialog("Warning",getlang("ระบบสถิติจะแสดงรายละเอียดแบบตารางย้อนหลังเพียง 6 เดือนเท่านั้น::l::Only last 6 month will display on table style"));

	$gmdataall[data]=$gmdata;
	$gmdataall[title]=getlang($sdb[$db][name]);
	$gmdataall[reporttitle]=getlang("กราฟสรุป ::l::Summary Graph ").$dspname;

	//printr($gmdataall);
	$gmdataalls=serialize($gmdataall);
	sessionval_set($gmid,$gmdataalls);

}

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