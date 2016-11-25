<?php             include ("../../inc/config.inc.php");
				include("../_REQPERM.php");
					loginchk_lib();

function localfso_image_fixsize($wh,$type,$max=80) {

	$currentimagesize = getimagesize($wh);
	$image_width = $currentimagesize[0];
	$image_height= $currentimagesize[1];

$type=strtolower($type);
	if (($image_height > $max)) {
		$sizefactor = (double) ($max / $image_height);
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

			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $image_width, $image_height);

			// Output
			imagejpeg($thumb,$wh,100);
		}
}

    $data = explode(",", $_POST['pixels']);
	//print_r($_POST);
    $width = floor($_POST['width']);
    $height = floor($_POST['height']);

//if ($width==0) {$width=100;}
//if ($height==0) {$height=100;}
    $image=imagecreatetruecolor( $width ,$height );
    $background = imagecolorallocate( $image ,0 , 0 , 0 );
    //Copy pixels
    $i = 0;
    for($x=0; $x<=$width; $x++){
        for($y=0; $y<=$height; $y++){
            $int = hexdec($data[$i++]);
            $color = ImageColorAllocate ($image, 0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int);
            imagesetpixel ( $image , $x , $y , $color );
        }
    }

	$targetsave="./file/temp$useradminid.jpg";
    ImageJPEG( $image ,$targetsave,100);
    imagedestroy( $image );    

$sizefac=1;

///
///die("fakedone=yes");
localfso_image_fixsize($targetsave,"jpg",144*$sizefac);

$w=128*$sizefac;
$h=144*$sizefac;   
$x=32*$sizefac; //ตั้งกรอบซ้ายขวา 
$y=0*$sizefac;   

$filename=$targetsave;

$image = imagecreatefromjpeg($filename); 
$crop = imagecreatetruecolor($w,$h);
imagecopy ( $crop, $image, 0, 0, $x, $y, $w, $h );
ImageJPEG( $crop ,$filename ,100);
imagedestroy( $image );    
imagedestroy( $crop );   

/*
$filename = 'status.txt';
$somecontent="
".print_r($_POST,true);

    if (!$handle = fopen($filename, 'a+')) {
         //echo "Cannot open file ($filename)";
         exit;
    }
    if (fwrite($handle, $somecontent) === FALSE) {
       // echo "Cannot write to file ($filename)";
        exit;
    }
    fclose($handle);
	*/
?>done=yes