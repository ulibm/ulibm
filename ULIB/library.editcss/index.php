<?php 
	; 
        include ("../inc/config.inc.php");

		head();

		$_REQPERM="editcss";

        mn_lib();
if ($issave=="yes") {	
	$thecss=stripslashes($thecss);
	fso_file_write("../css/ulib5.css","w",$thecss);
	viewdiffman_add("editcss","editcss",$thecss);
}
?>
                <div align = "center">
<?php 
pagesection(getlang("แก้ไข CSS ของทั้งโปรแกรม::l::Edit program's CSS"));
?>
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">

<input type=hidden name="issave" value="yes">
 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("แก้ไขตัวเลือก ::l::Edit CSS");?></td>
 </tr>
  <tr valign = "top">
  <td  align=center class=table_td colspan=2><TEXTAREA NAME="thecss" ROWS="50" COLS="50" style="width:700; height: 500"><?php 
  
  $tmp= file_get_contents("../css/ulib5.css");
  echo stripslashes($tmp);
  
  ?></TEXTAREA></td>
 </tr>




	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <?php viewdiffman("editcss","editcss");?> </td>
</tr></form>
</table>
<?php 
				foot();
?>