<?php  //พ
function html_ugallery($wh,$width=800) {
	//return;
	//echo "html_ugallery($wh,$width)";
	global $_TBWIDTH;
	global $dcrURL;
	$chk=tmq("select * from globalupload where keyid='".addslashes($wh)."' and (
	hidename like '%.jpg'  or 
	hidename like '%.png'  or 
	hidename like '%.gif'  or 
	hidename like '%.jpeg'  	
	) limit 15",false);
	//chk count
	if (tnr($chk)==0) { return;	}

	?><div style="clear: both;"></div>
	<div style="position: relative; display:block; border: 0px solid #cacaca; width: <?php  echo $width?>px; height: 75px; background-color: black; overflow: hidden;" >	
	
	<div style="position: absolute; padding-left: 3px;"
	><a href="<?php echo $dcrURL?>js/galleria/index.php?code=<?php  echo $wh;?>" rel="gb_page_fs[]">
	<nobr><?php 
	while ($r=tfa($chk)) {
		$imgurl=$dcrURL."_globalupload/$wh/".$r[hidename];
		?><img src="<?php  echo $imgurl?>" height=75 xxxxstyle="padding-right: 3px;" border=0> <?php 
	}
	?></nobr></a>
	</div>
	<div style="position: absolute; background-image:url(<?php echo $dcrURL?>js/galleria/fader.png); width: 200px; height: 75px;top: 0px; left: <?php  echo $width-200?>px;">&nbsp;</div>

	</div>
	
	<div style="clear: both;"></div><?php 

	//echo "html_ugallery($wh)";
}
?>