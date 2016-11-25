<?php 
function html_dialog($title="",$text=" ",$width=402) {
	if ($title=="") {
		$title="ข้อความ";
	}
	?><center>
	<div style="-webkit-box-shadow: 0px 0px 30px 0px rgba(50, 50, 50, 0.75);
-moz-box-shadow: 0px 0px 30px 0px rgba(50, 50, 50, 0.75);
box-shadow: 0px 0px 30px 0px rgba(50, 50, 50, 0.75);
width: <?php  echo $width?>px; margin: 20px 20px 20px 20px; text-align: center;" 
align=center>
	<TABLE width=<?php  echo $width?> align=center style="border: 1px solid #b9b9b9">
	<TR>
		<TD  style="color: black; background-color: #eaeaea; font-weight: bold; text-align: center;"><?php  echo getlang($title);?></TD>
	</TR>
	<TR>
		<TD xclass=table_td style="background-color: white; padding 5px 5px 5px 5px;"><?php  echo getlang($text);?></TD>
	</TR>
	</TABLE>
	</div></center><?php 
}
?>