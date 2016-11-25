<?php  //พ
function html_xpbtn($str,$isecho=true) {
	//frm= text,url,color [,_target]
	global $dcrURL;
	$str=explode("::",$str);
	$result="";
	$result.='<TABLE align="" border = "0" cellspacing = "0" cellpadding =0 ><TR>';

	while (list($k,$v)=each($str)) {
		$i=explode(',',$v);
		//printr($i);
		if ($i[0]=="") {
		 continue;
		}
		if ($i[3]=="") {
			//$i[3]="_top";
		}
		$result.='';
		$result.='<TD>&nbsp;</TD>
		<TD><img src="'. $dcrURL.'neoimg/media/roundedge-'.$i[2].'-left.png"></TD>
		<TD background="'.$dcrURL.'neoimg/media/roundedge-'.$i[2].'-right.png" style="background-repeat: no-repeat; background-position: top right; padding-right: 10px;padding-left: 4px;"><nobr>
		<a  href="'.$i[1].'" target="'.$i[3].'" style="color:white;font-size:14px;font-weight:bold">'.getlang($i[0]).'</a> </nobr></TD>';
	}
	$result.='</TR></TABLE>';
	if ($isecho==true) {
		echo $result;
	} else {
		return $result;
	}
}
?>