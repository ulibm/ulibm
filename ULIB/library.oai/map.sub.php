<?php  
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="oaiman_map";
        $tmp=mn_lib();
if ($issave=="yes") {
	tmq("delete from barcode_valmem");
	barcodeval_set("oaiman_map-$indexid",addslashes($oaiman_map));	
	redir("map.php");
	die;
}
?>
                <div align = "center">
<?php  
pagesection($tmp);
$s=tmq("select * from index_ctrl where code='$indexid' ");
$s=tfa($s);
html_dialog("Index",getlang($s[name]));
?>
<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=0>
<form method=post action="<?php echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<input type=hidden name="indexid" value="<?php echo $indexid;?>">

  <tr valign = "top">
	<td class=table_head> <?php echo getlang("ค่าตัวแปรที่ใช้ทำ Index::l::Variable to index");?></td>
  <td align=center class=table_td><?php form_quickedit("oaiman_map",barcodeval_get("oaiman_map-$indexid"),"longtext");
  ?> </td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <a href="map.php" class=a_btn><?php echo getlang("กลับ::l::Back"); ?></a></td>
</tr></form>
</table>
<?php  
				foot();
?>