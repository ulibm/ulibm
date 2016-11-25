<?php 
	; 
		
        include ("../inc/config.inc.php");


		head();
		$_REQPERM="api";
        mn_lib();
				//include("sys_var.inc.php");

if ($issave=="yes") {
	barcodeval_set("ulibapi_iprange",addslashes($ulibapi_iprange));			
	barcodeval_set("ulibapi_enable",addslashes($ulibapi_enable));			
	barcodeval_set("ulibapi_encoderesult",addslashes($ulibapi_encoderesult));			

	////////////////

	//settings

}
?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ-API::l::System variables-API"));

?><table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Enable API");?></td>
  <td  align=center class=table_td><?php  form_quickedit("ulibapi_enable",barcodeval_get("ulibapi_enable"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Encode Result");?></td>
  <td  align=center class=table_td><?php  form_quickedit("ulibapi_encoderesult",barcodeval_get("ulibapi_encoderesult"),"list:none,th,utf"); ?></td>
 </tr>

  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("API Client's IP");?></td>
  <td  align=center class=table_td><?php  form_quickedit("ulibapi_iprange",barcodeval_get("ulibapi_iprange"),"longtext"); ?></td>
 </tr>






	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <?php 
	  if (library_gotpermission("apilivetest")==true) {
	  ?> <a href="livetest.php" class="smaller a_btn">Live Test</a>
	  <?php  } ?>
	  </td>

</tr></form>
</table>
<?php 
				foot();
?>