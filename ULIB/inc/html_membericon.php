<?php  //พ
function html_membericon($memid,$size="normal") {
	global $memberspechtml;
	global $memberspechtml_h;
	global $memberspechtml_w;
	global $dcr;
	$picpath=member_pic_url($memid);
	if ($size=="normal") {
	$s="<TABLE width=136 height=148 cellpadding=0 cellspacing=0 class=table_border>
	<TR>
		<TD class=table_td><img src='$picpath' $memberspechtml onerror=\"this.src='/$dcr/pic/no.jpg'\"></TD>
	</TR>
	<TR>
		<TD class=table_head align=center><FONT class=smaller2 style='font-weight: normal'>".get_member_name($memid)."</FONT></TD>
	</TR>
	</TABLE>";
	} else {
		$s="<TABLE width='".floor($memberspechtml_w*0.6)."' height='".floor($memberspechtml_h*0.6)."' cellpadding=0 cellspacing=0 class=table_border>
		<TR>
			<TD class=table_td><img src='$picpath' width='".floor($memberspechtml_w*0.6)."' height='".floor($memberspechtml_h*0.6)."' onerror=\"this.src='/$dcr/pic/no.jpg'\"></TD>
		</TR>
		<TR>
			<TD class=table_head align=center><FONT class=smaller2 style='font-weight: normal' >".get_member_name($memid," class=smaller2 ")."</FONT></TD>
		</TR>
		</TABLE>";
	}

	return $s;
}
?>