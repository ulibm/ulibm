<?php // พ
function fso_image_fixsize($wh,$type,$max=80) {
   
   if (!file_exists($wh)) {
      //echo "<!--file not exists in fso_image_fixsize($wh,$type,$max) -->";
      return;
   }
	$currentimagesize = getimagesize($wh);
	$image_width = $currentimagesize[0];
	$image_height= $currentimagesize[1];

$type=strtolower($type);
	if (($image_height > $max) || ($image_width > $max))
	  {
		if ($image_height > $image_width)
		{
		  $sizefactor = (double) ($max / $image_height);
		}
		else 
		{
		  $sizefactor = (double) ($max / $image_width) ;
		}
	  } else {
		$sizefactor = 1;
	  }


		if ($sizefactor!=1) {
			  $newwidth = (int) ($image_width * $sizefactor);
			  $newheight = (int) ($image_height * $sizefactor);
			//echo $newwidth."x";
			//echo $newheight;

			// Load
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			if ($type=="jpg" || $type == "jpeg") {
				$source = imagecreatefromjpeg($wh);
			}
			if ($type=="gif" ) {
				$source = imagecreatefromgif($wh);
			}
			if ($type=="png" || $type == "pong") {
				$source = imagecreatefrompng($wh);
			}
			if ($type=="bmp" ) {
				$source = imagecreatefromwbmp($wh);
			}

			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $image_width, $image_height);

			// Output
			imagejpeg($thumb,$wh);
		}
}
?>