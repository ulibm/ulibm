<?php 
	; set_time_limit(600);
        include ("../inc/config.inc.php");
if ($download=="yes") {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename('sitemap.xml'));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('../sitemap.xml'));
    readfile('../sitemap.xml');
    exit;
}
		head();

		$_REQPERM="editsitemapxml";

        mn_lib();
if ($issave=="yes") {	
	$thecss=stripslashes($thecss);
	fso_file_write("../sitemap.xml","w",$thecss);
	viewdiffman_add("editsitemapxml","editsitemapxml",$thecss);
}
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข sitemap.xml ::l::Edit sitemap.xml"));
?>
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">

<input type=hidden name="issave" value="yes">
 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("แก้ไข sitemap.xml::l::Edit sitemap.xml");?></td>
 </tr>
  <tr valign = "top">
  <td  align=center class=table_td colspan=2><TEXTAREA NAME="thecss" ID="thecss" ROWS="50" COLS="50" style="width:700; height: 500"><?php 
if ($create=="yes") {
?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation=" http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<!--
 created with Sitemap Generator ULibM.net
--><?php 
	$s=tmq("select * from sitemap_temp where isdone='yes' order by depth1 ");
	while ($r=tfa($s)) {
		//printr($r);
		?>
<url>
<loc><?php  echo $r[url];?></loc>
<lastmod><?php  echo date("Y-m-d\TH:i:sP");?></lastmod>
<changefreq>weekly</changefreq>
<priority><?php  echo number_format(floor(10-floor($r[depth1]))*0.1,2);?></priority>
</url>
<?php 
	}
	?></urlset>
<?php 
} else {
  $tmp= file_get_contents("../sitemap.xml");
  echo stripslashes($tmp);
}
  ?></TEXTAREA>

<br><?php  echo getlang("ไฟล์ sitemap.xml ควรอยู่ที่ www root::l::sitemap.xml should placed at www root"); ?><br>
  <a href="index.php?download=yes" class="smaller2 a_btn" target=_blank>Download</a>
  </td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <?php viewdiffman("editsitemapxml","editsitemapxml");?></td>
</tr></form>
</table>
<center><form method="post" action="gen.php">
<input type="hidden" name="firsttimesubmit" value="yes">

<input type="submit" value="<?php  echo getlang("สร้างจากเนื้อหาหน้าเว็บ::l::Create from homepage html"); ?>">
<?php  echo getlang("ระดับของการเชื่อมโยง::l::depth to retrieve"); ?>
<select name="setdepth">
	<option value="3" selected>3
	<option value="1">1
	<option value="2">2
	<option value="3">3
	<option value="4">4
	<option value="5">5
	<option value="6">6
	<option value="7">7
	<option value="8">8
	<option value="9">9
</select>
  </form></center>
<?php 
				foot();
?>