<?php 

	$tab=tmq("select * from webbox_tab where isshow='yes' order by ordr");
	$sepperstart="
	<div style='text-align:center;align:center; padding:0 0 3 0;
background-color:%bordercolor%;
border-top-left-radius: 3px 3px;
border-top-right-radius: 3px 3px;
border-bottom-left-radius: 3px 3px;
border-bottom-right-radius: 3px 3px;'> <!-- wrapper -->
	<div style=\"display:block;width:".($_menuw-7)."px !important; margin-left:2px!important; overflow:hidden; 
	background-color: %bordercolor%; height:1px!important;\"></div>
	<!-- <div style=\"display:block;width:".($_menuw-1)."px !important; margin-left:1px!important; overflow:hidden;
	background-color: %bordercolor%; height:1px!important;\"></div>
	<div style=\"display:block; border: 1px %bordercolor% solid; background-color: white; width:".($_menuw)."\">  -->
	<div style=\"width:".($_menuw)."; background-color: %bordercolor%;color:%fgcol%;font-size: 13; font-weight:bold;\">%tabtext%</div>
	";
	$sepperend="
	</div><!-- <div style=\"width:".($_menuw)."px;margin-left:1px; background-color: %bordercolor%; height:1px!important;;overflow:hidden;\"></div><div style=\"width:".($_menuw-2)."px;margin-left:2px;; background-color: %bordercolor%; height:1px!important;;overflow:hidden;\"></div>--></div> 
	<img src='$dcrURL/neoimg/spacer.gif' width=50 height=5>";
	while ($tabr=tmq_fetch_array($tab)) {
		$pos = strpos("   ".$tabr[bgcol], "#");
		if ($pos === false && strlen($tabr[bgcol])==6) {
			$tabr[bgcol]="#".$tabr[bgcol];
		} 
		if($tabr[module]=="ตัวแบ่ง"||$tabr[module]=="Seperator") {
			//printr($tabr);
			if ($tabstarted==true) {
				$thissepperend=str_replace("%bordercolor%",$lasttabbgcol,$sepperend);
				echo $thissepperend;
			}
			$thissepperstart=str_replace("%tabtext%",getlang($tabr[name]),$sepperstart);
			$thissepperstart=str_replace("%bordercolor%",$tabr[bgcol],$thissepperstart);
			$thissepperstart=str_replace("%fgcol%",$tabr[fgcol],$thissepperstart);
			$lasttabbgcol=$tabr[bgcol];
			echo $thissepperstart;
			$tabstarted=true;
			continue;
		}
		$leftident=$tabr[indent]*1;
		$linkto="index.php?deftab=$tabr[id]";
		//printr($tabr);
		$linkto_target="_top";
		if ($tabr[module]=="Link_to_URL") {
			$linkto="$tabr[linktourl_url]";
			$linkto_target="$tabr[linktourl_target]";
		}
		if ($tabr[bgcol]=="") {
			$tabr[bgcol]="transparent";
		}
		if ($tabr[fgcol]=="") {
			$tabr[fgcol]="black";
		}
			?><div style="text-align:left; nopadding-left:<?php  echo $leftident;?>; background-color: <?php  echo $tabr[bgcol]?>; color: <?php  echo $tabr[fgcol]?>; width: <?php  echo $_menuw;?>; overflow:hidden; "><A HREF="<?php  echo $linkto?>"  target="<?php  echo $linkto_target?>" style="text-decoration:none; color: <?php  echo $tabr[fgcol];?>;	font-size:<?php  echo $tabr[fontsize]; ?>px;"><?php 
			for ($stri=0;$stri<=$leftident;$srit++) {
				echo "&nbsp;";
				$stri++;
			}
			echo getlang($tabr[name]);?></A></div>
			<?php 
	}
	if ($tabstarted==true) {
		$thissepperend=str_replace("%bordercolor%",$lasttabbgcol,$sepperend);
		echo $thissepperend;
	}

	if (loginchk_lib('check')==true) {
		include($dcrs."webbox/adminmenu.php");
	}
		
		echo barcodeval_get("webboxoptions-barhtml");
		?><DIV ID="DragContainerMENU" class="DragContainer" overclass="OverDragContainer" style="width: <?php  echo $_menuw;?>; padding-bottom:5">
	<?php 
		$s=tmq("select * from webbox_box where  col='MENU' order by ordr ",false);
		$webbox_cur_columnwidth=$_menuw-$column_space;

		while ($r=tmq_fetch_array($s)) {
			local_webbox($r);
		}

	?>

</DIV>
<?php 
		local_edithtmlbtn("pagemenu-alltab","แทรก/แก้ไขเนื้อหา (ทุกแท็บ)::l::Insert/edit html (all tab)");
		local_edithtmlbtn("pagemenu-$deftab","แทรก/แก้ไขเนื้อหา (แท็บนี้)::l::Insert/edit html (this tab)");
?>