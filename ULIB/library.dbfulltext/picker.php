<?php 
include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();



$pathinf=tmq("select * from filesonserver where id='$pathid' ");
if (tmq_num_rows($pathinf)!=1) {
	die("filesonserver where id='$pathid' ");
}
$pathinf=tmq_fetch_array($pathinf);
$xx1master=$pathinf[path];

if ($forceaddall!="") {
	$forceaddall_orig=$forceaddall;
	$forceaddall=str_replace('..','',$forceaddall);
	$forceaddall=trim($forceaddall,'/');
	$forceaddall=trim($forceaddall,'\\');
	$forceaddall=$pathinf[path]."/".$forceaddall;

	$xx3 = opendir($forceaddall);    //opens selected path
//echo "$forceaddall/";
	$i=0;
	while (false !== ($xx5 = readdir ($xx3))) {
		if (is_file($forceaddall . "/" . $xx5)) {
			if ($xx5=="Thumbs.db" ) { 
				continue;
			}
			$xx5=addslashes($xx5);
			$i++;
			$setdef_url=addslashes($pathinf[url]."/".$forceaddall_orig."/".$xx5);;
			$s="insert into media_ftitems set
			mid='$mid',
			fttype='$FTCODE',
			uploadtype='url',
			text='$xx5',
			filename='$setdef_url'			
			";
			tmq($s);
			media_updatelastdt($mid,"ft");
		}
	}
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("added <?php  echo $i;?> records;");
	self.location="mediacontent.php?mid=<?php echo $mid; ?>&FTCODE=<?php echo $FTCODE; ?>"
	//-->
	</SCRIPT><?php 
	die;
}
//printr($pathinf);
//$xx1="";$xx1master;


//set paths, read paths
/*if (substr($xx1, strlen($xx1)-1, 1)=="/") {
	$xx1=substr($xx1,0,strlen($xx1)-1);
}
*/
$currentpath=str_replace('..','',$currentpath);
$currentpath=trim($currentpath,'/');
$currentpath=trim($currentpath,'\\');
$currentpath=$pathinf[path]."/".$xx1;

/*if ($navigation==1) {
	$currentpath=$pathinf[path]."/".$xx2;
}
*/
$parentsubdir=substr($currentpath, 0, strrpos($currentpath, "/"));    //this is the path up one level
$parentsubdir=str_replace($xx1master,'',$parentsubdir);
$parentsubdir=trim($parentsubdir,'/');
$parentsubdir=trim($parentsubdir,'\\');

$xx3 = @opendir($currentpath);    //opens selected path
if (!$xx3) {
   html_dialog("",getlang("ไม่สามารถเปิดโฟลเดอร์ $currentpath บนเซิร์ฟเวอร์ได้::l::Cannot open $currentpath on server"));
   if (library_gotpermission("filesonserver")==true) {
      echo "<center><a href='../library.filesonserver/' class=a_btn>".getlang("จัดการ::l::Manage")."</a></center>";
   }
   foot();
   die;
}
$ifile=0;
$ifolder=0;
while (false !== ($xx5 = readdir ($xx3))) {
	if (is_dir($currentpath . "/" . $xx5) && $xx5 != "."&& $xx5 != "..") {
		$folders[$ifolder]=$currentpath . "/" . $xx5;
		$folders[$ifolder]=str_replace($xx1master,'',$folders[$ifolder]);
		$folders[$ifolder]=trim($folders[$ifolder],'/');
		$folders[$ifolder]=trim($folders[$ifolder],'\\');
		//$folders[$ifolder]=$xx5;
		$foldersname[$ifolder]=$xx5;
		$ifolder++;
	}
	if (is_file($currentpath . "/" . $xx5)) {
		$files[$ifile]=$xx1master . "/" . $xx5;
		$filesname[$ifile]= $xx5;
		$ifile++;
	}
}
@reset($folders);
@reset($files);
@reset($filesname);
//printr($folders);
?>
<form method="post" action="">
	
<TABLE width=780 align=center class=table_border>
<TR>
	<TD class=table_head><?php  echo getlang("เพิ่มไฟล์ให้::l::Add file to"); ?></TD>
	<TD class=table_td><?php  echo marc_gettitle($mid);?></TD>
</TR>

<TR>
	<TD class=table_td colspan=2 align=center>
	<A HREF="../library.book/"><?php  echo getlang("กลับไปฐานข้อมูล::l::Back to database");?> </A>
	::
	<A HREF="mediacontent.php?FTCODE=<?php  echo $FTCODE?>&mid=<?php  echo $mid?>"><?php  echo getlang("จัดการไฟล์ของรายการนี้::l::Back to files of this records");?></A>
	</TD>
</TR>
<tr><td class=table_head><?php echo getlang("ประเภทเนื้อหา::l::Content type");?></td>
<td><SELECT NAME="jumpftcate"  onchange="self.location='picker.php?FTCODE='+this.value+'&mid=<?php  echo $mid?>&pathid=<?php  echo $pathid?>'">
	<?php 
	$s=tmq("select * from media_fttype where code='$FTCODE' ");
	$s=tmq_fetch_array($s);
	echo "<OPTION VALUE='$s[code]' SELECTED>".getlang($s[name])."</OPTION>";
		$sall1=tmq("select * from media_fttype where code<>'$FTCODE' order by name ");
	while ($sall1r=tmq_fetch_array($sall1)) {
		echo "<OPTION VALUE='$sall1r[code]' >".getlang($sall1r[name]);
	}

	?>
		
		
	</SELECT></td></tr>
<TR>
	<TD class=table_td colspan=2 align=center><?php  echo getlang("กรุณาเลือกไฟล์::l::Please choose a file you want");?></TD>
</TR>
</TABLE>
</form>
<BR>

<TABLE width=780 align=center class=table_border>
<TR>
	<TD class=table_head><?php  echo getlang("ที่เก็บไฟล์::l::File path"); ?></TD>
	<TD class=table_td><?php  echo getlang($pathinf[name]);?></TD>
</TR>
<TR>
	<TD class=table_head width=50%><?php  echo getlang("โฟลเดอร์ปัจจุบัน::l::Current Path"); ?>:</TD>
	<TD class=table_td> <?php  echo $xx1; ?></TD>
</TR>
</TABLE>
<table border=0 width=780 align=center class=table_border>
<tr >
	<td style="border-width:0px;border-bottom-width: 1; border-style: solid; border-color: gray;"> <b><?php  echo getlang("โฟลเดอร์::l::Folder"); ?>:</b> </td>
	<td  style="border-width:0px;border-bottom-width: 1; border-style: solid; border-color: gray; border-left-width: 1"> <b><?php  echo getlang("คลิกเลือกไฟล์ที่นี่::l::Choose file here"); ?></b> </td>
</tr>

<tr><td valign="top">
<B>
<?php 

//display folders
for ($xx8=0; $xx8<count($folders); $xx8++) {
		echo "<a href='picker.php?FTCODE=$FTCODE&mid=$mid&pathid=$pathid&xx1=".$folders[$xx8]."'> <IMG SRC='../neoimg/Folder-icon.png' WIDTH=16 HEIGHT=16 BORDER=0 align=absmiddle> " . $foldersname[$xx8] . "</a><br>";
}
?></B><?php 
if ($xx1!='') {
	echo "$xx1<BR><a href='picker.php?FTCODE=$FTCODE&mid=$mid&pathid=$pathid&xx1=$parentsubdir' ><IMG SRC='../neoimg/Up.gif' WIDTH=16 HEIGHT=16 BORDER=0 align=absmiddle> ".getlang("ขึ้น 1 ระดับ::l::Up 1 level")."</a>";
}
?>

</td>


<td valign="top"   style="border-width: 0px; border-style: solid; border-color: gray; border-left-width: 1px;">


<?php 
//calculate size of window

for ($xx10=0; $xx10<count($files); $xx10++) {
	$fil =$files[$xx10];

	$filename=$filesname[$xx10];
	$setdef_url=$pathinf[url]."/".$xx1."/".$filename;
	if ($filename=="Thumbs.db" ) { 
		continue;
	}
	
	echo "<a href=\"mediacontent.php?fftmode=add&FTCODE=$FTCODE&mid=$mid&setdef_url=$setdef_url&setdef_name=$filename\">";
	echo html_geticon($filename,"width=16 height=16");

	echo " " . $filename . "</a> <BR>";

}
if (count($files)>=2 && $xx1!="") {
	echo "<BR><a href='picker.php?mid=$mid&FTCODE=$FTCODE&pathid=$pathid&forceaddall=$xx1' onclick=\"return confirm('add all file?');\"><IMG SRC='../neoimg/plus.gif' WIDTH=16 HEIGHT=16 BORDER=0 align=absmiddle> ".getlang("เพิ่มทั้งหมด::l::Add all")."</a>";
}
?>


</td></tr></table>

<!-- form pick files&folders -->


<form name="forwardlink" action="<?php  $PHP_SELF ?>" method = "post">
	<input type="hidden" name="xx2" value="<?php  echo $xx2; ?>">
	<input type="hidden" name="mid" value="<?php  echo $mid; ?>">
	<input type="hidden" name="pathid" value="<?php  echo $pathid; ?>">
	<input type="hidden" name="navigation" value="1">
</form>
<?php 
foot();
?>