<?php //พ
function removenewline($wh) { 

  $wh=str_replace("\n","",$wh); 
  $wh=str_replace(chr(13),"",$wh); 
  //$wh=str_replace(chr(32),"",$wh); 
  $wh=str_replace(chr(0),"",$wh); 
  $wh=str_replace("
","",$wh); 
	$reswh="";
		for($xi=0;$xi<=strlen($wh);$xi++ ) { 
			if (floor(ord($wh[$xi]))==0) { 
				//echo "skipped"; continue; 
			} else {
				//echo "$wh[$xi]=".ord($wh[$xi])."<BR>";
				$reswh.= $wh[$xi];
			}
		}
	//echo "<HR>";
   return $reswh; 
} 
?>