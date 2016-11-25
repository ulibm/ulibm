<?php 
	; 
        include ("../inc/config.inc.php");

		head();

		$_REQPERM="editsitemapxml";

        mn_lib();
if ($issave=="yes") {	
	$thecss=stripslashes($thecss);
	fso_file_write("../wiki/.htaccess","w",$thecss);
	viewdiffman_add("editsitemapxml","editsitemapxml",$thecss);
}
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข .htaccess ::l::Edit .htaccess"));
?>
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">

<input type=hidden name="issave" value="yes">
 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("แก้ไข .htaccess::l::Edit .htaccess");?></td>
 </tr>
  <tr valign = "top">
  <td  align=center class=table_td colspan=2><TEXTAREA NAME="thecss" ID="thecss" ROWS="50" COLS="50" style="width:700; height: 500"><?php 
if ($create=="yes") {
		$tab=tmq("select * from webbox_tab where module='Wiki_Home' ");
		$tab=tfa($tab);
	echo "
# CREATED BY ULibM

Options +FollowSymlinks
RewriteEngine on
RewriteRule ^([^/]*)\$ /$dcr/index.php?deftab=$tab[id]&webboxload=yes&title=\$1

";
} else {
  $tmp= file_get_contents("../wiki/.htaccess");
  echo stripslashes($tmp);
}
  ?></TEXTAREA><br>
  <a href="index.php?create=yes" class=a_btn><?php  echo getlang("ตั้งค่ามาตรฐาน::l::Generate Common"); ?></a>
  </td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '>  <?php viewdiffman("editsitemapxml","editsitemapxml");?> </td>
</tr></form>
</table>
<?php 
				foot();
?>