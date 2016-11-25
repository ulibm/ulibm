<?php  //พ
        include ("../inc/config.inc.php");
		include($dcrs."library.createwebbanner/funcs.php");
function local_color_inverse($color){
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
    for ($x=0;$x<3;$x++){
        $c = 255 - hexdec(substr($color,(2*$x),2));
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
    return '#'.$rgb;
}
		barcodeval_set("createwebbanner-choosebg",$choosebg);
		barcodeval_set("createwebbanner-toptext",$toptext);
		barcodeval_set("createwebbanner-imgh",$imgh);
		barcodeval_set("createwebbanner-imgw",$imgw);
		barcodeval_set("createwebbanner-font",$font);
		barcodeval_set("createwebbanner-toptextsize",$toptextsize);
		barcodeval_set("createwebbanner-toptextcolor",$toptextcolor);
		barcodeval_set("createwebbanner-toptextbg",$toptextbg);
		barcodeval_set("createwebbanner-middletext",$middletext);
		barcodeval_set("createwebbanner-middletextsize",$middletextsize);
		barcodeval_set("createwebbanner-middletextcolor",$middletextcolor);
		barcodeval_set("createwebbanner-middletextbg",$middletextbg);

	$im = imagecreatetruecolor($imgw, $imgh);
	if ($font=="") { $font="Browalia";}
	$font=$dcrs."library.createwebbanner/$font"."b.ttf";
	//$font=$dcrs."library.createwebbanner/$font.ttf";
//bg
$tmpimgbc_file="$dcrs"."_tmp/createwebbanner/$choosebg.jpg";
list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
//echo $tmpimgbc_file;
$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
imagecopyresampled( $im ,  $tmpimgbc_file , 0,0 , 0 , 0 , $imgw , $imgh , $origwidth,$origheight );
//bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )

//text
$toptext=iconvutf($toptext);
if ($toptextcolor=="") {$toptextcolor="#809DEA";}
$colorbartmp=trim($toptextcolor,'#');
unset($toptextcolor);
$toptextcolor=Array();
$toptextcolor[1]=hexdec(substr($colorbartmp,0,2));
$toptextcolor[2]=hexdec(substr($colorbartmp,2,2));
$toptextcolor[3]=hexdec(substr($colorbartmp,4,2));
//printr($toptextcolor);
$toptextcolor = imagecolorallocate($im, $toptextcolor[1], $toptextcolor[2], $toptextcolor[3]);

$toptextbg=trim($toptextbg,'#');
unset($toptextbg2);
$toptextbg2=Array();
$toptextbg2[1]=hexdec(substr($toptextbg,0,2));
$toptextbg2[2]=hexdec(substr($toptextbg,2,2));
$toptextbg2[3]=hexdec(substr($toptextbg,4,2));
//printr($toptextcolor);
$toptextbg2 = imagecolorallocate($im, $toptextbg2[1], $toptextbg2[2], $toptextbg2[3]);
//$toptextcolor = imagecolorallocate($im, 0xD6, 0xD6, 0xD6);


	$x=0;$y=floor($toptextsize/2)+5;
	$stra=explodenewline($toptext);
	@reset($stra);
	while (list($k,$v)=each($stra)) {
		$y=$y+floor($toptextsize/2);
		imagettftextblur($im,$toptextsize,0,$x+2,$y+2,$toptextbg2,$font,$v,3);
		imagettfstroketext($im, $toptextsize, 0, $x, $y, $toptextcolor, $toptextbg2, $font, $v, 1);
	}
		//imagettftextblur($im,$toptextsize,0,$x+2,$y+2,$toptextbg2,$font,$toptext,3);
		//imagettfstroketext($im, $toptextsize, 0, $x, $y, $toptextcolor, $toptextbg2, $font, $toptext, 1);

$middletext=iconvutf($middletext);
if ($middletextcolor=="") {$middletextcolor="#809DEA";}
$colorbartmp=trim($middletextcolor,'#');
unset($middletextcolor);
$middletextcolor=Array();
$middletextcolor[1]=hexdec(substr($colorbartmp,0,2));
$middletextcolor[2]=hexdec(substr($colorbartmp,2,2));
$middletextcolor[3]=hexdec(substr($colorbartmp,4,2));
//printr($middletextcolor);
$middletextcolor = imagecolorallocate($im, $middletextcolor[1], $middletextcolor[2], $middletextcolor[3]);

$middletextbg=trim($middletextbg,'#');
unset($middletextbg2);
$middletextbg2=Array();
$middletextbg2[1]=hexdec(substr($middletextbg,0,2));
$middletextbg2[2]=hexdec(substr($middletextbg,2,2));
$middletextbg2[3]=hexdec(substr($middletextbg,4,2));
//printr($middletextcolor);
$middletextbg2 = imagecolorallocate($im, $middletextbg2[1], $middletextbg2[2], $middletextbg2[3]);
//$middletextcolor = imagecolorallocate($im, 0xD6, 0xD6, 0xD6);

	$x=0;$y=0+floor($imgh/2)+floor($middletextsize/2);
	$stra=explodenewline($middletext);
	@reset($stra);
	while (list($k,$v)=each($stra)) {
		$y=$y+floor($middletextsize/2);
		imagettftextblur($im,$middletextsize,0,$x+2,$y+2,$middletextbg2,$font,$v,3);
		imagettfstroketext($im, $middletextsize, 0, $x, $y, $middletextcolor, $middletextbg2, $font, $v, 1);
	}
//	imagettftextblur($im,$middletextsize,0,$x+2,$y+2,$middletextbg2,$font,$middletext,3);
//	imagettfstroketext($im, $middletextsize, 0, $x, $y, $middletextcolor, $middletextbg2, $font, $middletext, 1);
	//imagettftextblur($im,$toptextsize,0,$x,$y,$toptextcolor,$font,$toptext,0);
	//imagettftextblur(&$image,$size,$angle,$x,$y,$color,$fontfile,$text,$blur_intensity = null)




header('Content-type: image/png');
@imagepng($im);
/* empty the buffer */
@imagedestroy($im);

?>