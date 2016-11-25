<?php 
	; 
        include ("../inc/config.inc.php");
		head();// พ
		$_REQPERM="oaiman_namemap";
        $tmp=mn_lib();
if ($issave=="yes") {
	tmq("delete from barcode_valmem");
	barcodeval_set("oaiman_namemap",addslashes($oaiman_namemap));	
	redir("$PHP_SELF");
	die;
}
?>
                <div align = "center">
<?php 
pagesection($tmp);
?>
<table border = 0 cellpadding = 0 width = 1000 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Element name");?></td>
  <td align=center class=table_td><?php  form_quickedit("oaiman_namemap",barcodeval_get("oaiman_namemap"),"longtext");
  ?> </td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> </td>
</tr></form>
</table>
<?php 
				foot();
?>