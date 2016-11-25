<?php 
;
      include("inc/config.inc.php");
if ($_ISULIBMASTER!="yes") {
  header("HTTP/1.0 404 Not Found");
  die;
}
			
if ($save=="yes") {
	$s=tmq("select * from ulibsv");
	$someyes="no";
	while ($r=tmq_fetch_array($s)) {
		if ($usisdblist[$r[id]]=="okyes") {
			$someyes="yes";
			eval("\$usisdb[$r[id]]='yes';");
		} else {
			eval("\$usisdb[$r[id]]='no';");
		}
	}
	if ($someyes=="yes") {
		ulibsess_register("usisdb");
	} else {
		ulibsess_unregister("usisdb");
	}
}


	   include("./index.inc.php");
	  head();
		mn_web('usis');
		pagesection("USIS - ULIBM Single Search");
 ?>


        <table width="780" align=center border="0" cellspacing="0" cellpadding="6">
          <tr> 
            <td align="center" ><font size="6" color="#FFFFFF"><b><font face="AngsanaUPC, CordiaUPC">Stop Words</font></b></font></td>
          </tr>
        </table>

<TABLE width=640 align=center cellpadding=0 cellspacing=0>
<FORM METHOD=POST ACTION="_USIS.php">
	<TR valign=top>
	<TD align=center> <fieldset><legend><?php  echo getlang("หัวเซิร์ฟเวอร์ที่ต้องการสืบค้น ::l::Servers to search");?></legend>
	<TABLE cellpadding=10 width=100%>
	<TR>
		<TD><?php 
$s=tmq("select * from ulibsv where alwayson='yes' and ishide<>'yes' and isallowed='yes' order by orgname_eng");
while ($r=tmq_fetch_array($s)) {
?><nobr><?php 
	echo "<img src='$dcrURL/neoimg/foldersearch24.png' width=24 height=24 align=absmiddle>";
	?><INPUT TYPE="checkbox" NAME="usisdblist[<?php echo $r[id]?>]" value="okyes" style="border-width: 0;" <?php 
  if ($usisdb[$r[id]]=="yes" || count($usisdb)==0) {
  	echo " checked ";
  }
  ?>> <B style='font-size: 18px; ' ><?php  echo getlang($r[orgname_thai]."::l::".$r[orgname_eng])?></B></nobr><BR>
  <?php 
}	
?><HR>
<?php  echo getlang("ใส่ข้อความสำหรับสืบค้น::l::Enter text to search");?>
	<input type="text" name="keyword" value="<?php  echo $keyword?>" />
	<INPUT TYPE="submit" value=" <?php  echo getlang("ค้นหา::l::Search");?>"> 
	</TD>
	</TR>
	</TABLE>
	</fieldset></TD>
</TR>

<INPUT TYPE="hidden" NAME="save" value="yes">
</FORM>
</TABLE>
<script language="javascript"> 
function resizeIframe2(id) { 
	try { 
		frame = document.getElementById(id); 
		frame.scrolling = "no"; 
		innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document; 
		objToResize = (frame.style) ? frame.style : frame; 
		 tmpfrheight = innerDoc.body.scrollHeight + 2; 
		 if (tmpfrheight>600) {
			 tmpfrheight=600;
		 }
		 objToResize.height = tmpfrheight;
	} catch (e) { 
		window.status = e.message; 
	} 
} 
</script> 
<?php 

if ($keyword!="") {
?><br />
<table border="0" cellpadding="0" cellspacing="0" width=780 align=center>
<tr><td><?php 
  $s=tmq("select * from ulibsv where alwayson='yes' and ishide<>'yes' and isallowed='yes' order by orgname_eng");
	$i=0;
  while ($r=tmq_fetch_array($s)) {
    if ($usisdb[$r[id]]=="yes" || count($usisdb)==0) {
    } else {
		  continue;
		} 
		$i++;
		pagesection(getlang("ค้นหาจาก::l::Search From")." : ".getlang($r[orgname_thai]."::l::".$r[orgname_eng]),"usissearchsection");
      ?><iframe width=770 scrolling="no" height=25 src="_USIS.presearch.php?time=<?php  echo $i;?>&url=<?php  echo urlencode($r[url]);?>&keyword=<?php  echo $keyword?>" frameborder="0"
			id="iframe_usis<?php  echo $i;?>" onload="resizeIframe2('iframe_usis<?php  echo $i;?>');"></iframe><?php 
	  }	
?></td></tr>
</table><br />
<br />
<?php 
}

foot();
?>