<?php 
include("../inc/config.inc.php");
	 head();
	 
	 mn_root("filebrowser");


$xx1master=$dcrs;

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
$currentpath=$dcrs."/".$xx1;

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

   foot();
   die;
}
if (trim($showsource)!="") {
   html_dialog("",getlang("Show Source $showsource"));
   ?><table align=center width='<?php echo $_TBWIDTH;?>'><tr><td bgcolor=white><?php
   show_source($currentpath."/".$showsource);
   ?></td></tr></table><?php
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
<TABLE width=780 align=center class=table_border>
<TR>
	<TD class=table_head>Path</TD>
	<TD class=table_td><?php  echo getlang($dcrs);?></TD>
</TR>
<TR>
	<TD class=table_head width=50%><?php  echo getlang("โฟลเดอร์ปัจจุบัน::l::Current Path"); ?>:</TD>
	<TD class=table_td> <?php  echo $xx1; ?></TD>
</TR>
</TABLE>
<table border=0 width=1000 align=center class=table_border>
<tr >
	<td style="border-width:0px;border-bottom-width: 1; border-style: solid; border-color: gray;"> <b><?php  echo getlang("Folders"); ?>:</b> </td>
	<td  style="border-width:0px;border-bottom-width: 1; border-style: solid; border-color: gray; border-left-width: 1"> <b><?php  echo getlang("files"); ?></b> </td>
</tr>

<tr><td valign="top">
<B>
<?php 

//display folders
sort($folders);
//printr($folders);
//for ($xx8=0; $xx8<count($folders); $xx8++) {
while (list($k,$v)=each($folders)) {
		echo "<a href='index.php?FTCODE=$FTCODE&mid=$mid&pathid=$pathid&xx1=".$v."'> <IMG SRC='../neoimg/Folder-icon.png' WIDTH=16 HEIGHT=16 BORDER=0 align=absmiddle> " . $v . "</a><br>";
}
?></B><?php 
if ($xx1!='') {
	echo "<BR><a href='index.php?FTCODE=$FTCODE&mid=$mid&pathid=$pathid&xx1=$parentsubdir' ><IMG SRC='../neoimg/Up.gif' WIDTH=16 HEIGHT=16 BORDER=0 align=absmiddle> ".getlang("ขึ้น 1 ระดับ::l::Up 1 level")."</a>";
}
?>

</td>


<td valign="top"   style="border-width: 0px; border-style: solid; border-color: gray; border-left-width: 1px;">


<?php 
//calculate size of window
@sort($files);
//printr($files);
//for ($xx10=0; $xx10<count($files); $xx10++) {
while (list($k,$fil)=each($files)) {
	//$fil =$files[$xx10];

	//$filename=$filesname[$xx10];
   //$filename=$fil;
   $fileinfo=pathinfo($fil);
   //printr($fileinfo);
   $filename=$fileinfo[basename];
	$setdef_url=$pathinf[url]."/".$xx1."/".$filename;
	
	echo "<a href=\"index.php?FTCODE=$FTCODE&mid=$mid&pathid=$pathid&xx1=$xx1&showsource=$filename\" target=_blank>";
	echo html_geticon($filename,"width=16 height=16");

	echo " " . $filename . "</a>";
   $ext=strtolower(substr($filename,-3));
   if ($ext=="jpg" || $ext=="gif" ||$ext=="png") {
   	echo "  <a href=\"$dcrURL".$xx1."/".$filename."\" target=_blank>";
   	echo html_geticon($filename,"width=16 height=16");
   	echo " </a>";
   }
   if ($ext=="php" || $ext=="txt" ||$ext=="log"||$ext=="xml") {
   	echo "  <a href=\"edit.php?file=".base64_encode($xx1."/".$filename)."\" target=_blank>";
   	echo "<img border=0 src='../neoimg/gicons/image/ic_edit_black_18dp.png' width=10>";
   	echo " </a>";
   }

   echo "<BR>";

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