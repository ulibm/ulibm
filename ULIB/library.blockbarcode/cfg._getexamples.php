<BR><table align=center width="<?php echo $_TBWIDTH;?>"><tr><td><CENTER><?php // พ
for ($i=1;$i<=5;$i++) {
	$barcodeBC="getexample$i";
	$barcodeoutput="url";
	include("bcgen.php");
	if (trim( $barcodeBC)!="") {
	  $path_parts = pathinfo($barcodeoutput_url);
	  //printr($path_parts);
	?> <img src="_previewanddel.php?file=<?php  echo $path_parts[filename];?>.<?php  echo $path_parts[extension];?>&r=<?php  echo randid();?>" border=1 style="nofloat:left; max-width: 350px;";><?php 
	}
}
?></CENTER></td></tr></table>