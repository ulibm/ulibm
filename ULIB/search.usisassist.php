<?php 
;
die;
      include("inc/config.inc.php");
if ($_ISULIBMASTER!="yes") {
  header("HTTP/1.0 404 Not Found");
  die;
}
//printr($_GET);
   include("./index.inc.php");
pcache_s("autourl",0,0,false,"search-usisassist");
sleep(1);
	  html_start();
		//mn_web('usis');
		//pagesection("USIS - ULIBM Single Search");
 ?>
<TABLE width=100% height=100%>
<TR>
	<TD  style="background-color: #ffffff; padding-top:0;" valign=top>


<table width=100%>
<tr><td onclick="self.location='<?php  echo $PHP_SELF?>?fromrefcode=<?php  echo $fromrefcode;?>&keyword=<?php  echo $keyword?>&rand=<?php  echo randid();?>'" style="background-image: url(./neoimg/search.usis.png); background-repeat: repeat-x; height: 60; padding-left: 30px; padding-top: 30px; cursor: hand; cursor: pointer;" TITLE=' click to refresh' valign=top>
<B><?php  echo getlang("USIS-Search");?></B></td></tr>
</table>


<?php 
$keyword=trim($keyword);
$keyword=stripslashes($keyword);
$keyword=stripslashes($keyword);
$keyword=stripslashes($keyword);
$keyword=stripslashes($keyword);
if ($keyword!="") {

	echo "<CENTER><FONT style='color: #676767;font-size: 12px;'>[$keyword]</FONT></CENTER>";
	$refcode1=substr($fromrefcode,0,5);
	$refcode2=floor(substr($fromrefcode,-2));
  $s=tmq("select * from ulibsv where alwayson='yes' and isonusis='yes' and ishide<>'yes' and isallowed='yes' and not (refcode='$refcode1' and refordr ='$refcode2') order by rand(), orgname_eng limit 3");
	$i=0;
	//printr($usisdb);
  while ($r=tmq_fetch_array($s)) {
	  /*
		if ($usisdb[$r[id]]=="yes" && count($usisdb)!=0) {
		} else {
		  continue;
		} */
		$i++;



$searchuri=urldecode($r[url])."/_USIS.assistclient.php?keyword=".urlencode($keyword);
$handle = @fopen($searchuri, "r");
if ($handle) {
	?><TABLE width=100% align=center cellspacing=0 cellpadding=2 border=0>
	<TR>
		<TD style="padding-left: 5px" valign=middle align=left bgcolor="#ffffff"
		 style="background-repeat: repeat-x;background-color: white" background="./neoimg/usissitebg.jpg">
		 <A HREF="<?php  echo urldecode($r[url]);?>/advsearching.php?kw[]=<?php  echo urlencode($keyword);?>&bool[]=[[AND]]&searchopt[]=kw" target=_blank	><FONT SIZE="" COLOR=""  style="font-size: 14px; font-weight: bolder; color: #1779C1"><img src="./neoimg/usissiteicon.png" border=0 align=absmiddle> 
		<?php echo getlang(getlang($r[orgname_thai]."::l::".$r[orgname_eng]));?></FONT></A>
		
		<?php 
	$buffer="";
    while (!feof($handle)) {
        $buffer .= fgets($handle, 4096);
    }
	if (strlen($buffer)<50) {
		echo "<FONT SIZE=-2 COLOR=gray>".getlang("มีปัญหาในการสืบค้น::l::Connection Problems")."</FONT>";
	} else {
		echo $buffer;
	}
    @fclose($handle);
	?>


<br />	</TD>
	</TR>
	</TABLE>
	<?php 
}



				
			}	
?>
<?php 
}

//foot();
?>

	</TD>
</TR>
</TABLE>
<?php 
pcache_e();
?>