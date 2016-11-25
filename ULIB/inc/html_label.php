<?php  //พ
function html_label($wh,$code,$nolink="no",$dspnow=true) { 
	global $dcrURL;
 $db["i"]=("Item");
 $db["b"]=("Bib");
 if ($db[$wh]!="") {
 		$wh=$db[$wh];
 }
 $result='<TABLE style="	width: 220px;
	border-style: solid;
	border-width: 0px;
	border-color: #7D7D7D;
	border-top-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 2px;
	
	-webkit-border-top-left-radius: 2px;
-webkit-border-bottom-left-radius: 2px;
-moz-border-radius-topleft: 2px;
-moz-border-radius-bottomleft: 2px;
border-top-left-radius: 2px;
border-bottom-left-radius: 2px;
">
<TR valign=middle>
	<TD style="	width: 80px;
	background-color: #FFFFD9;
	font-size: 12px;
	color: black;
	border-style: dotted;
	border-width: 0px;
	border-color: #7D7D7D;
	border-right-width: 1px;">'. $wh.'</TD>
	<TD style="	text-align: right;
	padding-right: 3px;
	font-size: 12px; color: black;
">';

if ($wh=='Bib') {
	if ($nolink!="yes") {
		$result.= "<A HREF='$dcrURL/dublin.php?ID=$code' target=_blank style='text-decoration: none;	font-size: 12px; color: black;'>";
	}
}	
$result.= $code;
if ($wh=='Bib') {
	if ($nolink!="yes") {
		$result.= "</A>";
	}
}	
$result.='</TD>
</TR>
</TABLE>';
	if ($dspnow==true) {
		echo $result;
	} else {
		return $result;
	}
} 
?>