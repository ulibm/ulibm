<?php  
@header("Content-Type: text/html");

if(!function_exists("localimagettfstroketext")) {
   /**
    * Writes the given text with a border into the image using TrueType fonts.
    * @author John Ciacia 
    * @param image An image resource
    * @param size The font size
    * @param angle The angle in degrees to rotate the text
    * @param x Upper left corner of the text
    * @param y Lower left corner of the text
    * @param textcolor This is the color of the main text
    * @param strokecolor This is the color of the text border
    * @param fontfile The path to the TrueType font you wish to use
    * @param text The text string in UTF-8 encoding
    * @param px Number of pixels the text border will be
    * @see http://us.php.net/manual/en/function.imagettftext.php
    */
   function localimagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
    
       for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
           for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
               $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
    
      return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
   }
}

$outputfile=$dcrs."_tmp/_tmpbc-$bcgenmode-$barcodeBC.jpg";
$error="";
//colorbar
$colorbari=barcodeval_get("BARCODE-blockbc-color");
$colorbari=trim($colorbari);
if ($colorbari=="") {$colorbari="#809DEA";}
$colorbartmp=trim($colorbari,'#');
unset($colorbar);
$colorbar=Array();
$colorbar[1]=hexdec(substr($colorbartmp,0,2));
$colorbar[2]=hexdec(substr($colorbartmp,2,2));
$colorbar[3]=hexdec(substr($colorbartmp,4,2));
//printr($colorbar);


///////////


if ($barcodeBC!="") {
/*
	$imsize=50;
	$imw=floor(7*$imsize)*2;
	$imh=floor(3.73*$imsize);
	$imh=floor(6*$imsize)*2;*/

   $parents=tmq("select * from memcard where code='$bcgenmode' ");
   $parent=tfa($parents); //printr($parent); die;
	$sizefac=floor(barcodeval_get("BARCODE-memcardbc-sizefac"));
	$imw=floor($_MMTOPX*$parent[w])*$sizefac;
	$imh=floor($_MMTOPX*$parent[h])*$sizefac;
   //die("[sizefac=$sizefac]w/h= [$imw/$imh]");
	$im = imagecreatetruecolor($imw, $imh);
	//$im = imagecreate($imw, $imh);
	// Create some colors
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);
	$darkgrey = imagecolorallocate($im, 64, 64, 64);
	$black = imagecolorallocate($im, 1, 1, 1);
	$darkred = imagecolorallocate($im, 128, 1, 1);
	$iwidth=floor(strlen($barcodeBC)*40);
	$iheight=floor(strlen($barcodeBC)*15);
	if ($iwidth<100) {
		$iwidth=100;
	}
	if ($iheight<30) {
		$iheight=30;
	}
	//echo $iwidth;
	//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
	imagefilledrectangle($im,  0,0, $imw, $imh, $white);

	$colorbar = imagecolorallocate($im, $colorbar[1], $colorbar[2], $colorbar[3]);
	$font = barcodeval_get("BARCODE-blockbc-font");
	if ($font=="") { $font="Browalia";}
	$fontb=$dcrs."library.memcard/$font"."b.ttf";
	$font=$dcrs."library.memcard/$font.ttf";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-titlebc-isshownum"));
		$isshowinum=trim(barcodeval_get("BARCODE-blockbc-titlebc-isshowinum"));
		$bcline=strtolower(barcodeval_get("BARCODE-blockbc-titlebc-bcline"));
		$addtext=barcodeval_get("BARCODE-blockbc-titlebc-addtext");
		$addtext=iconvutf($addtext);
		if ($BCisshowtext=="yes") { 
			$BCisshowtext=1; 
		} else {
			$BCisshowtext=0; 
		}

		$m=tmq("select * from member where UserAdminID='$barcodeBC' limit 1 ");
		if (tmq_num_rows($m)==0) {
			$error="medianotfound";
         //die($error.$barcodeBC);
		} else {
			$m=tmq_fetch_array($m);
         $items=tmq("select * from memcard_sub_i where pid='$parent[code]' order by ordr");
         while ($itemr=tfa($items)) {
            $pos=explode(";",$itemr[pos]);
            $tx=$pos[0]*$sizefac;
            $ty=$pos[1]*$sizefac;
            $tw=($pos[2]*$sizefac);
            $th=($pos[3]*$sizefac);
            if ($itemr[type1]=="string") {
            
               if ($itemr[font]=="") {
                  $fontuse=$font;
               } else {
                  $fontuse=$dcrs."library.memcard/$itemr[font].ttf";
               }
               
               if (strtolower($itemr[fontisbold])=="yes") {
                  $fontuse=str_replace(".ttf","b.ttf",$fontuse);
                  //die($fontuse);
               }
               imagettftext($im, floor($itemr[string_fontsize])*$sizefac, 0, $tx, $ty, $black, $fontuse, stripslashes($itemr[data]));
            }
            //printr($itemr); die;
            if ($itemr[type1]=="var") {
               $var="";
               if ($itemr[varid]=="misc_datetime") {
                  $var=strip_tags(stripslashes(ymd_datestr(time(),"shortd")));
               }
               if ($itemr[varid]=="member_fullname") {
                  $var=trim($m[prefi]." ".$m[UserAdminName]);
               }
               if ($itemr[varid]=="member_name") {
                  $var=trim($m[UserAdminName]);
               }
               if ($itemr[varid]=="member_prefix") {
                  $var=trim($m[prefi]);
               }
               if ($itemr[varid]=="member_bc") {
                  $var=$barcodeBC;
               }
               if ($itemr[varid]=="member_room") {
                  $var=strip_tags(stripslashes(get_room_name($m[room])));
               }
               if ($itemr[varid]=="member_major") {
                  $dd=tmq("select * from major where id='$m[major]' ");
                  $ddr=tfa($dd);
                  
                  $var=strip_tags(stripslashes(getlang($ddr[name])));
               }
               if ($itemr[varid]=="member_type") {
                  $dd=tmq("select * from member_type where type='$m[type]' ");
                  $ddr=tfa($dd);
                  
                  $var=strip_tags(stripslashes(getlang($ddr[descr])));
               }
               if ($itemr[varid]=="member_expire") {
                  $var=trim(strip_tags(($m[dat]." ".$thaimonstrbrief[$m[mon]]." ".$m[yea])));
                  //die("$var");
                  
                  $var=strip_tags(stripslashes(getlang($var)));
               }
               
               if ($itemr[font]=="") {
                  $fontuse=$font;
               } else {
                  $fontuse=$dcrs."library.memcard/$itemr[font].ttf";
               }
               
               if (strtolower($itemr[fontisbold])=="yes") {
                  $fontuse=str_replace(".ttf","b.ttf",$fontuse);
                  //die($fontuse);
               }
               
               //printr($itemr);echo strtolower($itemr[fontisbold]);die($fontuse);
               imagettftext($im, floor($itemr[string_fontsize])*$sizefac, 0, $tx, ($ty+($sizefac*floor($itemr[string_fontsize]))), $black, $fontuse, $var);
            }
            if ($itemr[type1]=="image") {
               $tmpimgbc_file=$dcrs."_tmp/memcard_img/$itemr[id].jpg";
      			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
      			$new_width = $origwidth ;
      			$new_height = $origheight ;
      			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
      			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
      			imagecopyresampled($im, $tmpimgbc_file, $tx, $ty, 0, 0, $tw, $th, $origwidth, $origheight);
            }
            if ($itemr[type1]=="membarcodeimage") {
			      $tmpimgbc_file="$dcrs"."_tmp/_bctemp/bc_$barcodeBC.JPG";
               //echo $tmpimgbc_file;
               //echo "[$tw/$th];";
               $tmp= Barcode39($barcodeBC, $tw*3, $th*3, 100, "JPEG", 0 ,$tmpimgbc_file);
      			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
      			$new_width = $origwidth ;
      			$new_height = $origheight ;
      			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
      			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
      			imagecopyresampled($im, $tmpimgbc_file, $tx, $ty, 0, 0, $tw, $th, $origwidth, $origheight);
            }            
            if ($itemr[type1]=="memimage") {
               $tmpimg_file=member_pic_spath($barcodeBC);
         	  if ($tmpimg_file=="" || !file_exists($tmpimg_file)) {
         		$tmpimg_file=$dcrs."pic/no.jpg";
         	  }

      			list($origwidth, $origheight) = getimagesize($tmpimg_file);
      			$new_width = $origwidth ;
      			$new_height = $origheight ;
      			$tmpimgbc_file = imagecreatefromjpeg($tmpimg_file);
      			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
      			imagecopyresampled($im, $tmpimgbc_file, $tx, $ty, 0, 0, $tw, $th, $origwidth, $origheight);
            }            
         }
         /*
			$mtitle=dspmarc(substr($m[tag245],2). substr($m[tag246],2));
			$mtitle=mb_substr($mtitle,0,100);
			$mtitle=iconvutf(trim($mtitle));
			$calln=trim($mid[calln]);
			if ($calln=="") {
				$calln=marc_getcalln($mid[pid],", ");
			}
			if (strtolower($isshowinum)=="yes") {
			   $calln.=" ".$mid[inumber];
			}
			$calln=str_replace(',,',',',$calln);
			$calln=iconvutf($calln,',');
			$calln=trim($calln,' ,');
			
			//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			imagettftext($im, 18*$sizefac, 0, 10*$sizefac, 22*$sizefac, $black, $font, $mtitle);
			imagettftext($im, 17*$sizefac, 0, 10*$sizefac, 40*$sizefac, $black, $font, $calln);
			$tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$barcodeBC.JPG";
			//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
			$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", 0 ,$tmpimgbc_file);
			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
			$new_width = $origwidth ;
			$new_height = $origheight ;
			//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
			imagecopyresampled($im, $tmpimgbc_file, 5*$sizefac, 50*$sizefac, 0, 0, $imw-10, $imh-(90*$sizefac), $origwidth, $origheight);
			imagettftext($im, 18*$sizefac, 0, 10, $imh-(20*$sizefac), $black, $font, $addtext);
      if ($BCisshowtext==1) {
         if ($bcline=="") {
            $bcline=$barcodeBC;
         } else {
            $bcline=str_replace("[bc]",$barcodeBC,$bcline);
         }
			imagettftext($im, 18*$sizefac, 0, 10, $imh-(43*$sizefac), $black, $font, $bcline);
      }
      */
			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
			//imagefilledrectangle($im, 0, $imh-(10*$sizefac), $imw, $imh, $colorbar);
			@unlink($tmpimgbc_file);
		}
		
	

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Save the image as 
	imagejpeg($im, $outputfile,100);
	// Free up memory
	imagedestroy($im);
}

if ($error=="") {
	$barcodeoutput_url=$dcrURL."_tmp/_tmpbc-$bcgenmode-$barcodeBC.jpg";
	$barcodeoutput_dcrs=$outputfile;
} elseif ($error=="medianotfound") {
   @unlink($outputfile);
   //echo "[$outputfile]";
	$barcodeoutput_url=$dcrURL."_tmp/_tmpbc-medianotfound-$barcodeBC.jpg";
	$barcodeoutput_dcrs=$dcrs."_tmp/_tmpbc-medianotfound-$barcodeBC.jpg";
	//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
	$tmpimg_file=$dcrs."library.memcard/medianotfound.jpg";
   //die($tmpimg_file);
	list($origwidth, $origheight) = getimagesize($tmpimg_file);
	$new_width = $origwidth ;
	$new_height = $origheight ;
	$im = imagecreatetruecolor($origwidth, $origheight);
	//echo "$tmpimg_file ($origwidth, $origheight)";
	//echo "[$imw, $imh]";
	//echo "[$tmpimg_file]";
	$tmpimglogo_file = imagecreatefromjpeg($tmpimg_file);
	list($origwidth, $origheight) = getimagesize($tmpimg_file);
	imagecopyresampled($im, $tmpimglogo_file ,0, 0, 0, 0,$imw, $imh, $origwidth, $origheight);
	imagedestroy($tmpimglogo_file);

	imagettftext($im, 12*$sizefac, 0,  (2*$sizefac), (12*$sizefac), $darkred, $font, "Member not found");
	imagettftext($im, 10*$sizefac, 0,  (2*$sizefac), (10*$sizefac)+(12*$sizefac), $black, $font, "[$barcodeBC]");
	// Save the image as 
	//echo "[$barcodeoutput_dcrs]";
	imagejpeg($im, $barcodeoutput_dcrs,100);
	// Free up memory
	imagedestroy($im);
} else {
	
}
?>