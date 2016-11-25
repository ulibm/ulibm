<?php //พ
function str_html2rgb($color,$returnstring=false){
  if ($color[0] == '#') {
  	 $color = substr($color, 1);
	}
  if (strlen($color) == 6) {
    list($r, $g, $b) = array($color[0].$color[1],
    $color[2].$color[3],
    $color[4].$color[5]);
	}  elseif (strlen($color) == 3) {
  	 list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
	}
  else {
  		 return false;
	} 
  //$key = 1/255; 
  // use this to get a range from 0 to 1 eg: (0.5, 1, 0.1) 
  $key = 1; // use this for normal range 0 to 255 eg: (0, 255, 50) 
  $r = hexdec($r)*$key;
  $g = hexdec($g)*$key;
  $b = hexdec($b)*$key;
  if($returnstring){
  			return "{rgb $r $g $b}";
  }else{
  			return array($r, $g, $b);
  }
}
?>