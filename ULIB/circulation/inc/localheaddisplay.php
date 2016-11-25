<?php // พ
function localheaddisplay($txt,$col="darkgreen") {
	?><TABLE cellpadding=0 border=0 cellspacing=0 width=100% bgcolor='<?php  echo $col;?>'>
	<TR>
		<TD align=left bgcolor=white><B style="color:<?php  echo $col?>; font-size:18px; "><?php  echo getlang($txt);?></B></TD>
	</TR>
	</TABLE><?php 
}
	$_TBWIDTH="100%";

?>