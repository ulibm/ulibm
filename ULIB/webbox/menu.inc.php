<?php // พ
if ($deftab=="contentread") {
	$deftabmodule="contentread";
} elseif ($viewtopmenulist=="yes" && floor($listid)!=0) {
	$deftabmodule="viewtopmenulist";
} else {
	$deftab=floor($deftab);
	if ($deftab==0) {
		$deftab=tmq("select * from webbox_tab where deftab='yes' ");
		$deftab=tmq_fetch_array($deftab);
		//printr($deftab);
		$deftabmodule=$deftab[module];
		$deftablayout=$deftab[layout];
		if ($deftabmodule!='Webpage') {
			$deftablayout="noneWebpage";
		} else {
			if ($deftab[layout_mannual]!="") {
				$deftablayout="layout_mannual";
				$layout_mannual=trim($deftab[layout_mannual]);
				$layout_mannual=explode(",",$layout_mannual);
				$tablayouts[layout_mannual][colnum]=count($layout_mannual);
				@reset($layout_mannual);
				$layout_mannuali=0;
				while (list($k,$v)=each($layout_mannual)) {
					$layout_mannuali=$layout_mannuali+1;
					$tablayouts[layout_mannual][colwidth][$layout_mannuali]=floor(($tablayouts[Full_Width][colwidth][1]*$v)/100);
				}
			}
		}
		$deftab=$deftab[id];
	} else {
		$deftab=tmq("select * from webbox_tab where id='$deftab' ");
		$deftab=tmq_fetch_array($deftab);
		$deftabmodule=$deftab[module];
		$deftablayout=$deftab[layout];
		if ($deftabmodule!='Webpage') {
			$deftablayout="noneWebpage";
		} else {
			if ($deftab[layout_mannual]!="") {
				$deftablayout="layout_mannual";
				$layout_mannual=trim($deftab[layout_mannual]);
				$layout_mannual=explode(",",$layout_mannual);
				$tablayouts[layout_mannual][colnum]=count($layout_mannual);
				@reset($layout_mannual);
				$layout_mannuali=0;
				while (list($k,$v)=each($layout_mannual)) {
					$layout_mannuali=$layout_mannuali+1;
					$tablayouts[layout_mannual][colwidth][$layout_mannuali]=floor(($tablayouts[Full_Width][colwidth][1]*$v)/100);
				}
			}
		}
		$deftab=$deftab[id];
	}
	//printr($tablayouts[layout_mannual]);

	/*if ($deftablayout=="") {
	$deftablayout="Full_Width";
	}
*/
}
?>