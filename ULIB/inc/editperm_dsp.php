<?php 
function editperm_dsp($mid,$force=true) { 
	 $mid=urldecode($mid);
	 $mid=urldecode($mid);
	 $mid=urldecode($mid);
	 $mid=urlencode($mid);

	$c=tmq("select * from library_editperm where classid='$mid' ",false);
	$s="<FONT class=smaller style='color:darkred'>".getlang("การอนุญาตการแก้ไข::::l::Edit permission::")."</FONT>";
	if (tmq_num_rows($c)==0) {
		$s.=getlang("อนุญาตทั้งหมด::l::Allow all.");
	} else {
		$c=tmq_fetch_array($c);
		$chkcomma=str_replace(',','',$c[editable]);
		if ($chkcomma=="") {
			$s.=getlang("อนุญาตทั้งหมด::l::Allow all.");
		} else {
			$allowed=explode(',',$c[editable]);
			$allowed=arr_filter_remnull($allowed);
		$s.=getlang("อนุญาตให้ - ::l::Allow users - ");
			while (list($c,$v)=@each($allowed)) {
				$s.=get_library_name($v);
				$s.=' ,';
			}
		}
	}
	$s=trim($s,',');
	if ($force==true || library_gotpermission("webeditpagepermission")==true) {
		echo "<FONT class=smaller>$s</FONT>";
	}
}
?>