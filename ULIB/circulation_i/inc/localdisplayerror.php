<?php 
function localdisplayerror($txt,$col="darkred") {
	if ($col=="darkgray") {
		$col="#404040";
	}
	$localdisplayerrordb["membernotfound"]="ผิดพลาด ไม่พบสมาชิกบาร์โค้ดดังกล่าว::l::Error, member's barcode not found";
	$localdisplayerrordb["mediaid_notexist"]="ผิดพลาด ไม่พบวัสดุบาร์โค้ดดังกล่าว::l::Error, media's barcode not found";
	$txtdsp=$localdisplayerrordb[$txt];
	if ($txtdsp=="") {
		$txtdsp=$txt;
	}
	?><TABLE cellpadding=0 border=0 cellspacing=0 width=100% height=150 bgcolor='<?php  echo $col;?>'>
	<TR>
		<TD align=center bgcolor=white valign=middle><B style="color:<?php  echo $col?>; font-size:24 px; ">[<?php  echo getlang($txtdsp);?>]</B></TD>
	</TR>
	</TABLE><?php 
}
?>