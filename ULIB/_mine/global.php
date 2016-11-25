<?php 
;
      include("../inc/config.inc.php");

		//mn_web('usis');
		//pagesection("USIS - ULIBM Single Search");

	$refcode1=substr($fromrefcode,0,5);
	$refcode2=floor(substr($fromrefcode,-2));
	$referdb=tmq("select * from ulibsv where (refcode='$refcode1' and refordr ='$refcode2') and iscanminer='yes' ",false);
if (tmq_num_rows($referdb)==0) {
	html_dialog("ผิดพลาดในการหาข้อมูล","ไม่สามารถหารายชื่อโค้ดของไซต์คุณได้ กรุณายืนยันให้แน่ใจว่า ได้ทำการลงทะเบียนโปรแกรม ULIBM เรียบร้อยแล้ว");
	die;
}
	$referdb=tmq_fetch_array($referdb);
 ?>
 <base href="<?php  echo $referdb[url]?>_mine/" />
 <?php 
 	  html_start();
 ?>
<TABLE width=100% height=100%>
<TR>
	<TD  style="background-color: #ffffff; padding-top:0;" valign=top>

<table width=100%>
<tr><td onclick="self.location=self.location;" style="background-image: url(../neoimg/search.usis.png); background-repeat: no-repeat; " valign=top>
<B><?php  echo getlang("ULIBM - Union Catalog Search");?></B></td></tr>
</table>

<?php 
$keyword=trim($keyword);
if ((strlen($keyword)>=3 || strlen($isn)>=3 || strlen($authorname)>=3)) {

	echo "<CENTER><FONT style='color: #676767;font-size: 12px;'>[$keyword/$isn/$authorname]</FONT></CENTER>";

  $s=tmq("select * from ulibsv where ismine='yes' and not (refcode='$refcode1' and refordr ='$refcode2') order by rand(), orgname_eng");
	///$s=tmq("select * from ulibsv where ismine='yes' and 1 ");
	$i=0;
  while ($r=tmq_fetch_array($s)) {
		$i++;

$searchuri=urldecode($r[url])."/_mine/minerclient.php?fromrefcode=$fromrefcode&keyword=".urlencode($keyword)."&isn=".urlencode($isn)."&authorname=$authorname";
//echo $searchuri;
$handle = @fopen($searchuri, "r");
	?><TABLE width=100% align=center cellspacing=0 cellpadding=2 border=0>
	<TR>
		<TD style="padding-left: 5px" valign=middle align=left bgcolor="#ffffff">
		 <A HREF="<?php  echo urldecode($r[url]);?>" target=_blank	><FONT SIZE="" COLOR=""  style="font-size: 14px; font-weight: bolder; color: #1779C1"><img src="../neoimg/usissiteicon.png" border=0 align=absmiddle> 
		<?php echo getlang(getlang($r[orgname_thai]."::l::".$r[orgname_eng]));?></FONT></A>
<?php 
if ($handle) {

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
		
		
} else { // cannot create handle;
	echo  getlang("ไม่สามารถเชื่อมต่อ!::l::Unable to connect to server!");
}
	?>


<br />	</TD>
	</TR>
	</TABLE>
	<?php 

		}
}

//foot();
?>

	</TD>
</TR>
</TABLE>