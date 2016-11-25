<?php // พ
function html_rows0_str($res,$str,$span=1) {
	if (tmq_num_rows($res)==0) {
		$str="<TR>
			<TD class=table_td colspan=$span align=center style=\"padding-top: 7px; padding-bottom: 7; color: #A6A6A6\"><B>".getlang($str)."</B></TD>
		</TR>";
		echo $str;
	}
}
?>