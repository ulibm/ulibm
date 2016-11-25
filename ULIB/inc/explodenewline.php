<?php  //พ
function explodenewline($wh) { 
	$wh=str_replace("
",chr(13),$wh); 
	$wh=str_replace("\r\n",chr(13),$wh); 
	$wh=str_replace("\n",chr(13),$wh); 
	//$wh=str_replace("\t",chr(13),$wh); 
	$wh=str_replace("\r",chr(13),$wh); 
	//$wh=str_replace("\t",chr(13),$wh); 
	/*
	$wh=str_replace(chr(13),"
	",$wh); 
	$wh=str_replace(chr(10),"
	",$wh); 
	for ($i=1;$i<strlen($wh);$i++) {
		echo substr($wh,$i,1)."=".ord(substr($wh,$i,1))."<BR>";
	}
	*/
	$wh=explode(chr(13),$wh);
	//printr($wh);
	return $wh; 
} 
?>