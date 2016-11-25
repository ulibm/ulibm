<?php 
	; 
        include ("../inc/config.inc.php");

		head();

		$_REQPERM="editopensearch";

        mn_lib();
if ($issave=="yes") {	
	$thecss=stripslashes($thecss);
	fso_file_write("../opensearch.xml","w",$thecss);
	viewdiffman_add("opensearch","opensearch",$thecss);
}
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข OpenSearch ของทั้งโปรแกรม::l::Edit OpenSearch"));
?>
<form method=post action="<?php  echo $PHP_SELF?>">
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0 class=table_border>

<input type=hidden name="issave" value="yes">
 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("แก้ไขตัวเลือก ::l::Edit OpenSearch");?></td>
 </tr>
  <tr valign = "top">
  <td  align=center class=table_td colspan=2><TEXTAREA NAME="thecss" ROWS="50" COLS="50" style="width:700; height: 500"><?php 
  if ($loaddef=="yes") {
	?><<?php ?>?xml version="1.0" encoding="UTF-8"?>
<OpenSearchDescription xmlns:moz="http://www.mozilla.org/2006/browser/search/" 
      xmlns="http://a9.com/-/spec/opensearch/1.1/">
  <ShortName>ShortName</ShortName>
  <Description>Search LibraryName</Description>
    <OutputEncoding>UTF-8</OutputEncoding>
    <InputEncoding>UTF-8</InputEncoding>
  <Url method="GET" type="text/html" template="<?php  echo $dcrURL;?>searching.php?KW={searchTerms}"/>
  <Image height="16" width="16" type="image/png"><?php  echo $dcrURL;?>neoimg/ulibfavicon.png</Image>

</OpenSearchDescription><?php 
  } else {
	  $tmp= file_get_contents("../opensearch.xml");
	  echo stripslashes($tmp);
  }
  ?></TEXTAREA></td>
 </tr>
	<tr valign = "top">
	  <td colspan=1 align=center><?php  echo getlang("ควรมีโด้ดดังนี้อยู่ใน Metadata ของเว็บไซต์::l::The following code should be in your website's Metadata");?></td>
	  <td colspan=1 align=center> <code><?php 
	  echo htmlspecialchars('<link href="/'.$dcr.'/opensearch.xml" rel="search" title="LibrarySearch" type="application/opensearchdescription+xml">');
	  ?>
</code></td>
</tr>



	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <a class="a_btn smaller" href="<?php  echo $PHP_SELF?>?loaddef=yes"><?php echo getlang("โหลดค่ามาตรฐาน::l::Load defaults");?></a> <?php viewdiffman("opensearch","opensearch");?> </td>
</tr>
</table></form>
<?php 
				foot();
?>