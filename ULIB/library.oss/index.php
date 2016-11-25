<?php 
	; 
		
    include ("../inc/config.inc.php");
// พ
		head();
		$_REQPERM="ossmenu";
    mn_lib();
?>
                <div align = "center">
<?php 
pagesection(getlang("One Stop Service"));
?>
<table border = 0 cellpadding = 0 width = 700 
align = center cellspacing=2>
	<tr>
	  <td valign = "top" >
 <?php 
html_librarymenu("oss");
?><BR>
</td>
</tr>
</table>
<?php 
				foot();
?>