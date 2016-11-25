<?php 
	; 
        include ("../inc/config.inc.php");
if ($download=="yes") {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename('robots.txt'));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('../robots.txt'));
    readfile('../robots.txt');
    exit;
}
		head();

		$_REQPERM="editrobotstxt";

        mn_lib();
if ($issave=="yes") {	
	$thecss=stripslashes($thecss);
	fso_file_write("../robots.txt","w",$thecss);
	viewdiffman_add("editrobotstxt","editrobotstxt",$thecss);
}
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข Robots.txt ::l::Edit Robots.txt"));
?>
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">

<input type=hidden name="issave" value="yes">
 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("แก้ไข Robots.txt::l::Edit Robots.txt");?></td>
 </tr>
  <tr valign = "top">
  <td  align=center class=table_td colspan=2><TEXTAREA NAME="thecss" ID="thecss" ROWS="50" COLS="50" style="width:700; height: 500"><?php 
  
  $tmp= file_get_contents("../robots.txt");
  echo stripslashes($tmp);
  
  ?></TEXTAREA><br>
  <a href="javascript:void(null);" onclick="localset();" class=a_btn><?php  echo getlang("ตั้งค่าแบบมาตรฐาน::l::General Settings"); ?></a>
  <script type="text/javascript">
  <!--
	function localset() {
		tmp=getobj("thecss");
		tmp.value="User-agent: * \nDisallow: /<?php echo $dcr?>/*.sql$ \nDisallow: /<?php echo $dcr?>/*.js$ \nDisallow: /<?php echo $dcr?>/*.inc$ \nDisallow: /<?php echo $dcr?>/*.css$ \nDisallow: /<?php echo $dcr?>/*.txt$ \nDisallow: /<?php echo $dcr?>/library.*\nDisallow: /<?php echo $dcr?>/root.*\nDisallow: /<?php echo $dcr?>/library/\nDisallow: /<?php echo $dcr?>/root/\n\nsitemap: <?php  echo $dcrURL?>sitemap.xml";
	}
  //-->
  </script><br><?php  echo getlang("ไฟล์ robots.txt ควรอยู่ที่ www root::l::Robots.txt should placed at www root"); ?><br>
  <a href="index.php?download=yes" class="smaller2 a_btn" target=_blank>Download</a>
  </td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <?php viewdiffman("editrobotstxt","editrobotstxt");?></td>
</tr></form>
</table>
<?php 
				foot();
?>