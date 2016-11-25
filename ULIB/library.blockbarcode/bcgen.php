<?php  
@header("Content-Type: text/html");
if (!is_array($dbcallngenner)) {
	$dbcallngenner=tmq_dump2("keyhelp_callngenner","id","prefix");
}
if(!function_exists("getfirstgroupbhar")) {
   function getfirstgroupbhar($wh) {
      //echo "getfirstgroupbhar($wh)";
      $res="";
      for ($i=0;$i<=strlen($wh);$i++) {
         $thischar=substr($wh,$i,1);
         if ($thischar=="0" ||
         $thischar=="1" ||
         $thischar=="2" ||
         $thischar=="3" ||
         $thischar=="4" ||
         $thischar=="5" ||
         $thischar=="6" ||
         $thischar=="7" ||
         $thischar=="8" ||
         $thischar=="9" ) {
            break;
         }
         $res=$res.$thischar;
      }
      //echo "got $res";
      return $res;
   }
}
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

if(!function_exists("local_meltcalln")) {
	function local_meltcalln($c,$f,$yea,$localcalln,$inumber) {
		//echo "local_meltcalln($c,$f,$yea,$localcalln,$inumber)<BR>";
		global $dbcallngenner;
		//echo "[$f-$c]";
		$a=str_replace('  ',' ',$c);
		$a=trim($a);
		$a=str_replace(' ','^',$a);

		$inumber=str_replace('  ',' ',$inumber);
		$inumber=trim($inumber);
		$inumber=str_replace(' ','^',$inumber);
		$inumber=explode("^",$inumber);
		//echo $a;
if ($f=="by_subfield") {
//echo $f;

$result=$localcalln;;
$result=str_replace('.','^.',$result);
$result=str_replace('&','^',$result);
//echo $result;
$result=str_replace(' ^','^',$result);
//$result="$result^$yea^$localcalln";
$result=str_replace("^a","",$result);
$result=explode("^b",$result);
$result[1]=str_replace(" ","^",$result[1]);
$result=$result[0]."^".$result[1];
$result=str_replace('^^','^',$result);

//echo "[$result]";
//echo $result;
$result=explode('^',$result);
$result=array_merge($result,$inumber);
//printr($result);
}
		if ($f=="DC") {

			$a=str_replace('.','^.',$a);
			$a=str_replace('^c^.','^c.',$a);
			$a=str_replace('^v^.','^v.',$a);
			$a=str_replace('^ฉ^.','^ฉ.',$a);
			$a=str_replace('^ล^.','^ล.',$a);
			$a=explode('^',$a);//printr($a);
			@reset($a);
			$result=Array();
			$i=0;
			while (list($k,$v)=each($a)) {
				$i=$i+100;
				$result[$i]=$v;
			}
			$yea=marc_getsubfields($yea,"no");
			$yea=trim($yea[c]);
			$yea=trim($yea,'. []?');
			if ($yea!="") {
				$i=$i+100;
				$result[$i]=$yea;
			}
			//$i=$i+100;
			//$result[$i]=$inumber;
			$result=array_merge($result,$inumber);
		}

		if ($f=="1_line") {

			//$a=str_replace('.','^.',$a);
			$a=str_replace('^c^.','^c.',$a);
			$a=str_replace('^v^.','^v.',$a);
			$a=str_replace('^ฉ^.','^ฉ.',$a);
			$a=str_replace('^ล^.','^ล.',$a);
			$a=explode('^',$a);//printr($a);
			@reset($a);
			$result=Array();
			$i=0;
			while (list($k,$v)=each($a)) {
				$i=$i+100;
				$result[$i]=$v;
			}
			$yea=marc_getsubfields($yea,"no");
			$yea=trim($yea[c]);
			$yea=trim($yea,'. []?');
			if ($yea!="") {
				$i=$i+100;
				$result[$i]=$yea;
			}
			//$i=$i+100;
			//$result[$i]=$inumber;
			$result=array_merge($result,$inumber);
		}

		if ($f=="LC") {
			//echo $a;
			$a=str_replace('.','^.',$a);
			$a=explode('^',$a); 	//printr($a);
			@reset($a);
			$result=Array();
			$i=0;
			while (list($k,$v)=each($a)) {
				$i=$i+100;
				$result[$i]=$v;
			}
			//printr($result);
			$yea=marc_getsubfields($yea,"no");
			$yea=trim($yea[c]);
			$yea=trim($yea,' []?');
			if ($yea!="") {
				$i=$i+100;
				$result[$i]=$yea;
			}
			//$i=$i+100;
			//$result[$i]=$inumber;
			$result=array_merge($result,$inumber);
				//printr($result);
	
			//collection
			if (in_array("$a[0]",$dbcallngenner)) {
				$calclassificationcalln=200;
			} else {
				$calclassificationcalln=100;
			}
			//calclassificationcalln
			//echo $calclassificationcalln."=".$result[$calclassificationcalln];
			$tmp=rtrim($result[$calclassificationcalln],".123456789");
			if ("$tmp"!="$result[$calclassificationcalln]") {
				$fisrtrow=""; 
				$secondrow="";
				$notfirst=false;
				for ($ci=0;$ci<=strlen($result[$calclassificationcalln]);$ci++) {
					//echo substr($result[$calclassificationcalln],$ci,1);
					if (!is_numeric(substr($result[$calclassificationcalln],$ci,1)) && substr($result[$calclassificationcalln],$ci,1)!='.' &&$notfirst==false) {
						$fisrtrow.=mb_substr($result[$calclassificationcalln],$ci,1);
					} else {
						$notfirst=true;
						$secondrow.=mb_substr($result[$calclassificationcalln],$ci,1);
					}
				}
				$result[$calclassificationcalln]=$fisrtrow;
				$result[$calclassificationcalln+50]=$secondrow;
				//echo "[$fisrtrow/$secondrow]";
			}
		}

		@ksort($result);
		$result=arr_filter_remnull($result);
		//printr($result);
		@reset($result);
		return $result;
	}
}

if ($barcodeBC=="getexample1") {
	$barcodeBC=trim(barcodeval_get("BARCODE-blockbc-allbc"));
	$barcodeBC=explodenewline($barcodeBC);
	$barcodeBC=$barcodeBC[0];
}
if ($barcodeBC=="getexample2") {
	$barcodeBC=trim(barcodeval_get("BARCODE-blockbc-allbc"));
	$barcodeBC=explodenewline($barcodeBC);
	$barcodeBC=$barcodeBC[1];
}
if ($barcodeBC=="getexample3") {
	$barcodeBC=trim(barcodeval_get("BARCODE-blockbc-allbc"));
	$barcodeBC=explodenewline($barcodeBC);
	$barcodeBC=$barcodeBC[2];
}
if ($barcodeBC=="getexample4") {
	$barcodeBC=trim(barcodeval_get("BARCODE-blockbc-allbc"));
	$barcodeBC=explodenewline($barcodeBC);
	$barcodeBC=$barcodeBC[4];
}
if ($barcodeBC=="getexample5") {
	$barcodeBC=trim(barcodeval_get("BARCODE-blockbc-allbc"));
	$barcodeBC=explodenewline($barcodeBC);
	$barcodeBC=$barcodeBC[5];
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
	$imsize=50;
	$imw=floor(7*$imsize)*2;
	$imh=floor(3.73*$imsize);
	$imh=floor(6*$imsize)*2;

	$sizefac=floor(barcodeval_get("BARCODE-blockbc-sizefac"));
	$imw=floor(7*$imsize)*$sizefac;
	$imh=floor(3.73*$imsize)*$sizefac;
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
	$fontb=$dcrs."library.blockbarcode/$font"."b.ttf";
	$font=$dcrs."library.blockbarcode/$font".".ttf";
   //$font=$fontb;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($bcgenmode=="titlebc") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-titlebc-isshownum"));
		$isshowinum=trim(barcodeval_get("BARCODE-blockbc-titlebc-isshowinum"));
		$bcline=(barcodeval_get("BARCODE-blockbc-titlebc-bcline"));
		$bclinesize=floor(barcodeval_get("BARCODE-blockbc-titlebc-bclinesize"));
		$titlesize=floor(barcodeval_get("BARCODE-blockbc-titlebc-titlesize"));
		$callnsize=floor(barcodeval_get("BARCODE-blockbc-titlebc-callnsize"));
		$addtext=barcodeval_get("BARCODE-blockbc-titlebc-addtext");
		$addtextsize=floor(barcodeval_get("BARCODE-blockbc-titlebc-addtextsize"));
		$addtext=iconvutf($addtext);
		if ($BCisshowtext=="yes") { 
			$BCisshowtext=1; 
         $addh=0;
		} else {
         $addh=25*$sizefac;
			$BCisshowtext=0; 
		}
		$mid=tmq("select * from media_mid where bcode='$barcodeBC' limit 1 ",false);
		$mid=tmq_fetch_array($mid);
		$m=tmq("select * from media where ID='$mid[pid]' limit 1 ");
		if (tmq_num_rows($m)==0) {
			$error="medianotfound";
		} else {
			$m=tmq_fetch_array($m);
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
			imagettftext($im, (18+$titlesize)*$sizefac, 0, 10*$sizefac, 22*$sizefac, $black, $font, $mtitle);
			imagettftext($im, (17+$callnsize)*$sizefac, 0, 10*$sizefac, 40*$sizefac, $black, $font, $calln);
			$tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$barcodeBC.JPG";
			//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
			$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", 0 ,$tmpimgbc_file);
			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
			$new_width = $origwidth ;
			$new_height = $origheight ;
			//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
			imagecopyresampled($im, $tmpimgbc_file, 5*$sizefac, 50*$sizefac, 0, 0, $imw-10, $addh+($imh-(110*$sizefac)), $origwidth, $origheight);
         $addtext=str_replace("[bc]",$barcodeBC,$addtext);
         $addtext=str_replace("[bib]",$mid[pid],$addtext);

			imagettftext($im, (18+$addtextsize)*$sizefac, 0, 10, $imh-(20*$sizefac), $black, $font, $addtext);
      if ($BCisshowtext==1) {
         if ($bcline=="") {
            $bcline=$barcodeBC;
         } else {
            $bcline=str_replace("[bc]",$barcodeBC,$bcline);
            $bcline=str_replace("[bib]",$mid[pid],$bcline);
         }
			imagettftext($im, (18+$bclinesize)*$sizefac, 0, 10, $imh-(43*$sizefac), $black, $font, $bcline);
      }
      
			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
			imagefilledrectangle($im, 0, $imh-(10*$sizefac), $imw, $imh, $colorbar);
			@unlink($tmpimgbc_file);
		}
		
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="logobc") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-logobc-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-logobc-addtext");
		$addtextsize=floor(barcodeval_get("BARCODE-blockbc-logobc-addtextsize"));
		$bclinesize=floor(barcodeval_get("BARCODE-blockbc-logobc-bclinesize"));
		$titlesize=floor(barcodeval_get("BARCODE-blockbc-logobc-titlesize"));
		$callnsize=floor(barcodeval_get("BARCODE-blockbc-logobc-callnsize"));
		$spinewidth=barcodeval_get("BARCODE-blockbc-logobc-spinewidth");
		$spinewidth=floor($spinewidth);
		$addtext=iconvutf($addtext);
		if ($BCisshowtext=="yes") { 
			$BCisshowtext=1; 
		} else {
			$BCisshowtext=0; 
		}
		$mid=tmq("select * from media_mid where bcode='$barcodeBC' limit 1 ",false);
		$mid=tmq_fetch_array($mid);
		$m=tmq("select * from media where ID='$mid[pid]' limit 1 ");
		if (tmq_num_rows($m)==0) {
			$error="medianotfound";
		} else {
			$m=tmq_fetch_array($m);
			$mtitle=dspmarc(substr($m[tag245],2). substr($m[tag246],2));
			$mtitle=mb_substr($mtitle,0,100);
			$mtitle=iconvutf(trim($mtitle));
			$calln=trim($mid[calln]);
			if ($calln=="") {
				$calln=marc_getcalln($mid[pid],", ");
			}
			$calln=str_replace(',,',',',$calln);
			$calln=iconvutf($calln,',');
			$calln=trim($calln,' ,');
			
			$spinew=floor($imw*($spinewidth/100));
			$bcalai=$imw-$spinew;
			//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			imagettftext($im, (18+$titlesize)*$sizefac, 0, $spinew+(10*$sizefac), 22*$sizefac, $black, $font, $mtitle);
			imagettftext($im, (17+$callnsize)*$sizefac, 0, $spinew+(10*$sizefac), 44*$sizefac, $black, $font, $calln);
			$tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$barcodeBC.JPG";
			//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
			$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", 0 ,$tmpimgbc_file);
			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
			$new_width = $origwidth ;
			$new_height = $origheight ;
			//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
			imagecopyresampled($im, $tmpimgbc_file, $spinew+(5*$sizefac), 50*$sizefac, 0, 0, $bcalai-10, $imh-(90*$sizefac), $origwidth, $origheight);
			imagedestroy($tmpimgbc_file);
			//logo
			$tmpimg_file="$dcrs/_tmp/_barcode-logobc.jpg";
			//echo "[$tmpimg_file]";
			$tmpimglogo_file = imagecreatefromjpeg($tmpimg_file);
			list($origwidth, $origheight) = getimagesize($tmpimg_file);
			imagecopyresampled($im, $tmpimglogo_file , 5, 5, 0, 0, $spinew-10, $imh-(10+15), $origwidth, $origheight);
			imagedestroy($tmpimglogo_file );

      if ($BCisshowtext==1) {
         if ($bcline=="") {
            $bcline=$barcodeBC;
         } else {
            $bcline=str_replace("[bc]",$barcodeBC,$bcline);
         }
			imagettftext($im, (17+$bclinesize)*$sizefac, 0, $spinew+(10*$sizefac), $imh-(43*$sizefac), $black, $font, $bcline);
      }
      
			imagettftext($im, (17+$addtextsize)*$sizefac, 0, $spinew+(10*$sizefac), $imh-(20*$sizefac), $black, $font, $addtext);

			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
			imagefilledrectangle($im, 0, $imh-(10*$sizefac), $imw, $imh, $colorbar);
         @unlink($tmpimgbc_file);
		}
		
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="plainlogo") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-plainlogo-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-plainlogo-addtext");
		$addtextsize=floor(barcodeval_get("BARCODE-blockbc-plainlogo-addtextsize"));
		$spinewidth=barcodeval_get("BARCODE-blockbc-plainlogo-spinewidth");
		$bcline=barcodeval_get("BARCODE-blockbc-plainlogo-bcline");
		$bclinesize=floor(barcodeval_get("BARCODE-blockbc-plainlogo-bclinesize"));
		$spinewidth=floor($spinewidth);
		$addtext=iconvutf($addtext);
		if ($BCisshowtext=="yes") { 
			$BCisshowtext=1; 
         $addh=0;
		} else {
         $addh=40*$sizefac;
			$BCisshowtext=0; 
		}
		
			$spinew=floor($imw*($spinewidth/100));
			$bcalai=$imw-$spinew;
			//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			imagettftext($im, 18*$sizefac, 0, $spinew+(10*$sizefac), 22*$sizefac, $black, $font, $mtitle);
			///imagettftext($im, 17*$sizefac, 0, $spinew+(10*$sizefac), 44*$sizefac, $black, $font, $calln);
			$tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$barcodeBC.JPG";
			//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
			$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", 0 ,$tmpimgbc_file);
			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
			$new_width = $origwidth ;
			$new_height = $origheight ;
			//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
			imagecopyresampled($im, $tmpimgbc_file, $spinew+(5*$sizefac), 10*$sizefac, 0, 0, $bcalai-10, $addh+($imh-(80*$sizefac)), $origwidth, $origheight);
			imagedestroy($tmpimgbc_file);
			//logo
			$tmpimg_file="$dcrs/_tmp/_barcode-plainlogo.jpg";
			//echo "[$tmpimg_file]";
			$tmpimglogo_file = imagecreatefromjpeg($tmpimg_file);
			list($origwidth, $origheight) = getimagesize($tmpimg_file);
			imagecopyresampled($im, $tmpimglogo_file , 5, 5, 0, 0, $spinew-10, $imh-(20*$sizefac), $origwidth, $origheight);
			imagedestroy($tmpimglogo_file );

      if ($BCisshowtext==1) {
         if ($bcline=="") {
            $bcline=$barcodeBC;
         } else {
            $bcline=str_replace("[bc]",$barcodeBC,$bcline);
         }
		    imagettftext($im, (17+$bclinesize)*$sizefac, 0,$spinew+( 10*$sizefac), $imh-(43*$sizefac), $black, $font, $bcline);
      }
      
			imagettftext($im, (17+$addtextsize)*$sizefac, 0, $spinew+(10*$sizefac), $imh-(20*$sizefac), $black, $font, $addtext);

			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
			imagefilledrectangle($im, 0, $imh-(10*$sizefac), $imw, $imh, $colorbar);
         @unlink($tmpimgbc_file);
		
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="plain") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-plain-isshownum"));
		$bcline=(barcodeval_get("BARCODE-blockbc-plain-bcline"));
		$bclinesize=floor(barcodeval_get("BARCODE-blockbc-plain-bclinesize"));
		$addtextsize=floor(barcodeval_get("BARCODE-blockbc-plain-addtextsize"));
		$addtext=barcodeval_get("BARCODE-blockbc-plain-addtext");
		$addtext=iconvutf($addtext);
		if ($BCisshowtext=="yes") { 
			$BCisshowtext=1; 
         $addh=0;
		} else {
			$BCisshowtext=0; 
         $addh=40*$sizefac;
		}

		$tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$barcodeBC.JPG";
		//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
		$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", 0 ,$tmpimgbc_file);
		list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
		$new_width = $origwidth ;
		$new_height = $origheight ;
		//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
		//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
		imagecopyresampled($im, $tmpimgbc_file, 5*$sizefac, 30*$sizefac, 0, 0, $imw-(8*$sizefac),$addh+( $imh-(80*$sizefac) ), $origwidth, $origheight);
		imagedestroy($tmpimgbc_file);
		imagettftext($im, (19+$addtextsize)*$sizefac, 0, 5*$sizefac, 22*$sizefac, $black, $font, $addtext);
      if ($BCisshowtext==1) {
         if ($bcline=="") {
            $bcline=$barcodeBC;
         } else {
            $bcline=str_replace("[bc]",$barcodeBC,$bcline);
         }
		    imagettftext($im, (19+$bclinesize)*$sizefac, 0, 5*$sizefac, $imh-(22*$sizefac), $black, $font, $bcline);
      }

		//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
		imagefilledrectangle($im, 0, $imh-(10*$sizefac), $imw, $imh, $colorbar);
      @unlink($tmpimgbc_file);
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="standard") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-standard-isshownum"));
		$BCisshowtitle=trim(barcodeval_get("BARCODE-blockbc-standard-isshowtitle"));
		$BCisshowtitlesize=floor(barcodeval_get("BARCODE-blockbc-standard-isshowtitlesize"));
		$bcline=(barcodeval_get("BARCODE-blockbc-standard-bcline"));
		$bclinesize=floor(barcodeval_get("BARCODE-blockbc-standard-bclinesize"));
		$groupchar=strtolower(barcodeval_get("BARCODE-blockbc-standard-groupchar"));
		$addtext=barcodeval_get("BARCODE-blockbc-standard-addtext");
		$addtextsize=barcodeval_get("BARCODE-blockbc-standard-addtextsize");
		$addyear=trim(strtolower(barcodeval_get("BARCODE-blockbc-standard-addyear")));
		$spinewidth=barcodeval_get("BARCODE-blockbc-standard-spinewidth");
		$callntag=barcodeval_get("BARCODE-blockbc-standard-callntag");
		$callntagsize=floor(barcodeval_get("BARCODE-blockbc-standard-callntagsize"));
		$callnformat=barcodeval_get("BARCODE-blockbc-standard-callnformat");
		$spinewidth=floor($spinewidth);
		$addtext=iconvutf($addtext);
		if ($BCisshowtext=="yes") { 
			$BCisshowtext=1; 
		} else {
			$BCisshowtext=0; 
		}
		$mid=tmq("select * from media_mid where bcode='$barcodeBC' limit 1 ",false);
		$mid=tmq_fetch_array($mid);
		$m=tmq("select * from media where ID='$mid[pid]' limit 1 ");
		if (tmq_num_rows($m)==0) {
			$error="medianotfound";
		} else {
			$m=tmq_fetch_array($m);
			$mtitle=dspmarc(substr($m[tag245],2). substr($m[tag246],2));
			$mtitle=mb_substr($mtitle,0,100);
			$mtitle=iconvutf(trim($mtitle));
			$calln=trim($mid[calln]);
			if ($calln=="") {
				$calln=mb_substr($m["$callntag"],2);
				//echo "$calln<BR>";
				$calln=dspmarc($calln,"_");
				$calln=str_replace("_","^",$calln);
				//echo "$calln<BR>";
			}

			if ($callntag=="auto") {
				$calln=(marc_getmidcalln($barcodeBC));
				//echo "$calln<BR>";
				$calln=dspmarc($calln,"_");
				$calln=str_replace("_","^",$calln);
				//echo "$calln<BR>";
            //echo "[$calln]";
			}
			//printr($mid);
			//echo "$calln";
			$calln=trim($calln,'^');
			$calln=trim($calln);
			$calln=str_replace(',,',',',$calln);
			$calln=trim($calln,' ,');
         //echo "[$calln]";
         if ($groupchar=="yes") {
            $getfirstgroupchar=trim(getfirstgroupbhar($calln));
            if ($getfirstgroupchar!="") {
               $calln=substr($calln,0,strlen($getfirstgroupchar))." ".substr($calln,strlen($getfirstgroupchar));
               //echo "[$calln]";
            }
         }
			$tmpyeartag=getval("search","yearfield_tagname");
			$tmplcallntag=getval("MARC","def_local_callnum");
         $tmp_useyear=trim(substr($m[$tmpyeartag],2),"./()[]? \n\t$newline");
         $tmp_callnusex11=rtrim(substr($m[$tmplcallntag],2),"./()[]? \n\t$newline");
         if ($addyear!="yes") {
            $tmp_useyear="";
         }
         //echo "[$tmp_useyear]";
         //echo "[$calln]";
         $calln=rtrim($calln,"./()[]? \n\t$newline");;
         //echo "[$calln]";
			$calln=local_meltcalln($calln,$callnformat,$tmp_useyear,$tmp_callnusex11,$mid[inumber]);
			//printr($calln);
			@reset($calln);
			$cki=0;
			while (list($ck,$cv)=each($calln)) {
				$cki++;
				if (strlen($cv)>100) {
					$cv=mb_substr($cv,0,100)."..";
				}
				if ($cki==1) {
					imagettftext($im, (22+$callntagsize)*$sizefac, 0, 5*$sizefac, 2+($cki*22)*$sizefac, $black, $fontb, iconvutf($cv));
				} else {
					imagettftext($im, (22+$callntagsize)*$sizefac, 0, 10*$sizefac, 2+($cki*22)*$sizefac, $black, $font, iconvutf($cv));
				}
				//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			}
			//$calln=iconvutf($calln);
			
			$spinew=floor($imw*($spinewidth/100));
			$bcalai=$imw-$spinew;
			//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			//imagettftext($im, 18*$sizefac, 0, $spinew+(10*$sizefac), 25*$sizefac, $black, $font, $mtitle);
			$tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$barcodeBC.JPG";
			//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
			$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", 0 ,$tmpimgbc_file);
			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
			$new_width = $origwidth ;
			$new_height = $origheight ;
			//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
			imagecopyresampled($im, $tmpimgbc_file, $spinew+(5*$sizefac), 33*$sizefac, 0, 0, $bcalai-(10*$sizefac), $imh-((85)*$sizefac), $origwidth, $origheight);
			imagedestroy($tmpimgbc_file);

      if ($BCisshowtext==1) {
         if ($bcline=="") {
            $bcline=$barcodeBC;
         } else {
            $bcline=str_replace("[bc]",$barcodeBC,$bcline);
            $bcline=str_replace("[bib]",$mid[pid],$bcline);
         }
   			imagettftext($im, (18+$bclinesize)*$sizefac, 0, $spinew+(10*$sizefac), $imh-(43*$sizefac), $black, $font, $bcline);
      }
      
			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
         $addtext=str_replace("[bc]",$barcodeBC,$addtext);
         $addtext=str_replace("[bib]",$mid[pid],$addtext);
        
			imagefilledrectangle($im, 0, $imh-(10*$sizefac), $imw, $imh, $colorbar);
			imagettftext($im, (17+$addtextsize)*$sizefac, 0, $spinew+(10*$sizefac), $imh-(20*$sizefac), $black, $font, $addtext);
         if (strtolower($BCisshowtitle)=="yes") { //echo "yes";
   			//imagettftext($im, 17*$sizefac, 0, $spinew+(10*$sizefac), (20*$sizefac), $black, $font, iconvutf(trim(marc_gettitle($mid[pid]))));
   			imagettftext($im, (18+$BCisshowtitlesize)*$sizefac, 0, $spinew+(10*$sizefac), 25*$sizefac, $black, $font, $mtitle);
         }
         @unlink($tmpimgbc_file);
		}
		
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="calln") {
		@unlink($outputfile);
		$isshowyear=trim(barcodeval_get("BARCODE-blockbc-calln-isshowyear"));
		$groupchar=strtolower(barcodeval_get("BARCODE-blockbc-calln-groupchar"));
		$addtextsize=floor(barcodeval_get("BARCODE-blockbc-calln-addtextsize"));
		$isshowtitlesize=floor(barcodeval_get("BARCODE-blockbc-calln-isshowtitlesize"));
		$addtext=barcodeval_get("BARCODE-blockbc-calln-addtext");
		$addtext1=barcodeval_get("BARCODE-blockbc-calln-addtext1");
		$addtext1size=floor(barcodeval_get("BARCODE-blockbc-calln-addtext1size"));
		$callntag=barcodeval_get("BARCODE-blockbc-calln-callntag");
		$callntagsize=floor(barcodeval_get("BARCODE-blockbc-calln-callntagsize"));
		$callnformat=barcodeval_get("BARCODE-blockbc-calln-callnformat");
		$addtext=iconvutf($addtext);
		$mid=tmq("select * from media_mid where bcode='$barcodeBC' limit 1 ",false);
		$mid=tmq_fetch_array($mid);
		$m=tmq("select * from media where ID='$mid[pid]' limit 1 ");
		if (tmq_num_rows($m)==0) {
			$error="medianotfound";
		} else {
			$m=tmq_fetch_array($m);
			$mtitle=dspmarc(substr($m[tag245],2). substr($m[tag246],2));
			$mtitle=mb_substr($mtitle,0,100);
			$mtitle=iconvutf(trim($mtitle));
			$calln=trim($mid[calln]);
			if ($calln=="") {
				$calln=mb_substr($m["$callntag"],2);
				//echo "$calln<BR>";
				$calln=dspmarc($calln,"_");
				$calln=str_replace("_","^",$calln);
				//echo "$calln<BR>";
			}
			if ($callntag=="auto") {
				$calln=(marc_getmidcalln($barcodeBC));
				//echo "$calln<BR>";
				$calln=dspmarc($calln,"_");
				$calln=str_replace("_","^",$calln);
				//echo "$calln<BR>";
			}
			//printr($mid);
			//echo "$calln";
			$calln=trim($calln,'^');
			$calln=trim($calln);
			$calln=str_replace(',,',',',$calln);
			$calln=trim($calln,' ,');
         if ($groupchar=="yes") {
            $getfirstgroupchar=trim(getfirstgroupbhar($calln));
            if ($getfirstgroupchar!="") {
               $calln=substr($calln,0,strlen($getfirstgroupchar))." ".substr($calln,strlen($getfirstgroupchar));
               //echo "[$calln]";
            }
         }
			$calln=trim($calln,'^');
			$calln=trim($calln);
			$calln=str_replace(',,',',',$calln);
			$calln=trim($calln,' ,');
			$tmpyeartag=getval("search","yearfield_tagname");
			$tmplcallntag=getval("MARC","def_local_callnum");
			$tmpyeardata="";
			if ($isshowyear=="yes") {
				$tmpyeardata=mb_substr($m[$tmpyeartag],2);
			}
			$calln=local_meltcalln($calln,$callnformat,$tmpyeardata,substr($m[$tmplcallntag],2),$mid[inumber]);
			//printr($calln);
			@reset($calln);
			$cki=0;
			while (list($ck,$cv)=each($calln)) {
				$cki++;
				if (strlen($cv)>40) {
					$cv=mb_substr($cv,0,40)."..";
				}
				if ($cki==1) {
					imagettftext($im, (45+$callntagsize)*$sizefac, 90,2+($cki*42)*$sizefac, $imh-(5*$sizefac),  $black, $fontb, iconvutf($cv));
				} else {
					imagettftext($im, (40+$callntagsize)*$sizefac, 90,2+($cki*42)*$sizefac, $imh-(10*$sizefac),  $black, $font, iconvutf($cv));
				}
				//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			}
			//$calln=iconvutf($calln);
			
			$spinew=floor($imw*($spinewidth/100));
			$bcalai=$imw-$spinew;

         $dspbc="";
			if (strtolower(barcodeval_get("BARCODE-blockbc-calln-isshowbc"))=="yes") {
            $dspbc="$barcodeBC";
			}
         $dspmtitle="";
         //echo strtolower(barcodeval_get("BARCODE-blockbc-ribbon-showtitle"));
			if (strtolower(barcodeval_get("BARCODE-blockbc-calln-isshowtitle"))=="yes") {
            $dspmtitle="$mtitle";
			}
         $dspinfo="$dspbc-$dspmtitle";
         $dspinfo=trim($dspinfo," -");
         
			//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			imagettftext($im, (15+$isshowtitlesize)*$sizefac, 90, $imw-(25*$sizefac), $imh-(3*$sizefac), $black, $font, $dspinfo);
			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
			//imagefilledrectangle($im, 0, $imh-15, $imw, $imh, $colorbar);
         $addtext1=str_replace("[bc]",$barcodeBC,$addtext1);
         $addtext1=str_replace("[bib]",$mid[pid],$addtext1);
			imagettftext($im, (17+$addtext1size)*$sizefac, 90, $imw-(45*$sizefac), $imh-(3*$sizefac), $black, $font, $addtext1);
         $addtext=str_replace("[bc]",$barcodeBC,$addtext);
         $addtext=str_replace("[bib]",$mid[pid],$addtext);
			imagettftext($im, (17+$addtextsize)*$sizefac, 90, $imw-(5*$sizefac), $imh-(3*$sizefac), $black, $font, $addtext);

		}
		
	}	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="ribbon") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-ribbon-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-ribbon-addtext");
		$addtextsize=floor(barcodeval_get("BARCODE-blockbc-ribbon-addtextsize"));
		$yearedition=strtolower(barcodeval_get("BARCODE-blockbc-ribbon-yearedition"));
		$groupchar=strtolower(barcodeval_get("BARCODE-blockbc-ribbon-groupchar"));
		$callntag=barcodeval_get("BARCODE-blockbc-ribbon-callntag");
		$showtible=barcodeval_get("BARCODE-blockbc-ribbon-showtible");
		$showtiblesize=floor(barcodeval_get("BARCODE-blockbc-ribbon-showtiblesize"));
		$addstrokeline=barcodeval_get("BARCODE-blockbc-ribbon-addstrokeline");
		$callnformat=barcodeval_get("BARCODE-blockbc-ribbon-callnformat");
		if ($BCisshowtext=="yes") { 
			$BCisshowtext=1; 
		} else {
			$BCisshowtext=0; 
		}
		$mid=tmq("select * from media_mid where bcode='$barcodeBC' limit 1 ",false);
		$mid=tmq_fetch_array($mid);
		$m=tmq("select * from media where ID='$mid[pid]' limit 1 ");
		if (tmq_num_rows($m)==0) {
			$error="medianotfound";
		} else {
			$m=tmq_fetch_array($m);
			$mtitle=dspmarc(substr($m[tag245],2). substr($m[tag246],2));
			$mtitle=mb_substr($mtitle,0,100);
			$mtitle=iconvutf(trim($mtitle));
			$calln=trim($mid[calln]);
			if ($calln=="") {
				$calln=trim(substr($m[$callntag],2));
				$calln=dspmarc($calln);
			}
        	if ($callntag=="auto") {
				$calln=(marc_getmidcalln($barcodeBC));
				//echo "$calln<BR>";
				$calln=dspmarc($calln,"_");
				$calln=str_replace("_","^",$calln);
				//echo "$calln<BR>";
            //echo "[$calln]";
			}
			$calln=str_replace('  ',' ',$calln);
			$calln=str_replace('  ',' ',$calln);
			$calln=trim($calln);
         //echo "[$calln]";
         if ($groupchar=="yes") {
            $getfirstgroupchar=trim(getfirstgroupbhar($calln));
            if ($getfirstgroupchar!="") {
               $calln=substr($calln,0,strlen($getfirstgroupchar))." ".substr($calln,strlen($getfirstgroupchar));
               //echo "[$calln]";
            }
         }
			$calln=str_replace('  ',' ',$calln);
			$calln=str_replace('  ',' ',$calln);
			$callna=explode(' ',$calln);
         //printr($callna);
			$collectioncode="";
         //
         if (!function_exists("local_utf8Split")) {
            
            function local_utf8Split($str, $len = 1)
            {
              $arr = array();
              $strLen = mb_strlen($str, 'UTF-8');
              for ($i = 0; $i < $strLen; $i++)
              {
                $arr[] = mb_substr($str, $i, $len, 'UTF-8');
              }
              return $arr;
            }
         }
			if (in_array("$callna[0]",$dbcallngenner) || ($getfirstgroupchar!="")) {
				$collectioncode="$callna[0]";
				$callna=explode(' ',$calln,2);
            $callna[1]=rtrim($callna[1],"./%^#");
				$callnause=local_utf8Split($callna[1]);
            //echo ":";printr(local_utf8Split($callna[1]));echo ":";
            //printr(explode("",$callna[1]));
				$callnause=implode('|',$callnause);
				//rem | after dot
				$tmppos = mb_strpos($callnause, '.');
				if ($tmppos === false) {} else {
					$tmpcallnappend=mb_substr($callnause,mb_strpos($callnause,'.'));
               //echo "[[-$callnause--$tmpcallnappend]]";
					$callnause=mb_substr($callnause,0,(mb_strrpos($callnause,'.'))).str_replace('|','',$tmpcallnappend);
				}
				//echo "[$callnause]";
				$callnause=explode('|',$callnause,5);
				//printr($callnause); echo "here'";
				$callnause[4]=str_replace('|','',$callnause[4]);
			} else {
				$collectioncode="";
            $calln=rtrim($calln,"./%^#");
				$callnause=local_utf8Split($calln);
				$callnause=implode('|',$callnause);
				//rem | after dot
            //echo "[$callnause]";
				$tmppos = mb_strpos($callnause, '.');
				if ($tmppos === false) {} else {
					$tmpcallnappend=mb_substr($callnause,mb_strpos($callnause,'.'));
					$callnause=mb_substr($callnause,0,(mb_strrpos($callnause,'.'))).str_replace('|','',$tmpcallnappend);
				}
				//rem | after space
				$tmppos = mb_strpos($callnause, ' ');
				if ($tmppos === false) {} else {
					$tmpcallnappend=mb_substr($callnause,mb_strpos($callnause,' '));
					$callnause=mb_substr($callnause,0,($tmppos)).str_replace('|','',$tmpcallnappend);
				}
				$callnause=explode('|',$callnause,6);
				$callnause[5]=str_replace('|','',$callnause[5]);
			}
			$callnause=arr_filter_remnull($callnause);

			//printr($callnause);
			@reset($callnause);
			$callnausetemp=implode("^",$callnause);
			//echo "[$callnausetemp]";
			$callnausetemp=str_replace(" ","^",$callnausetemp);
			$callnausetemp=str_replace("^.^","^.",$callnausetemp);
			//echo "[$callnausetemp]";
			$callnause=explode("^",$callnausetemp);
			//printr($callnause);
         $callnause=arr_filter_remnull($callnause);
         //printr($callnause); echo "collectioncode=$collectioncode;";
			@reset($callnause);
			$cki=0;
			$rowscale=40;
         $localrowscale=$rowscale;
         $starty=0;
         //echo "starty=$starty;<BR>";
			if ($collectioncode!="") {
				$cki=$cki+1;
             $thisrowh=($rowscale*$sizefac);//+(5*$sizefac));
             //echo "thisrowh=$thisrowh;";
             //$starty =$starty+($rowscale*$sizefac);
				$colorbari=strtolower(barcodeval_get("BARCODE-blockbc-ribbon-colorof[$collectioncode]"));
				if ($colorbari=="") {$colorbari="#ffffff";}
				$colorbari=trim($colorbari,'#');
				//echo $colorbari;
				$usefontcolor=$white;
				if ($colorbari=="ffffff") {$usefontcolor=$black;;}
				$colorbguse=Array();
				$colorbguse[1]=hexdec(substr($colorbari,0,2));
				$colorbguse[2]=hexdec(substr($colorbari,2,2));
				$colorbguse[3]=hexdec(substr($colorbari,4,2));
				$tmpcolor = imagecolorallocate($im, $colorbguse[1], $colorbguse[2], $colorbguse[3]);
				//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
				imagefilledrectangle($im,  $starty,0, ($starty)+($thisrowh)+(7*$sizefac), $imh, $tmpcolor);
				if (strtolower($addstrokeline)=="no") {
   				//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
   				imagettftext($im, $rowscale*$sizefac, 90, ( ($cki*$rowscale)-(5))*$sizefac, floor($imh/2)+(20*$sizefac),$usefontcolor, $fontb, iconvutf($collectioncode));
               
   				//localimagettfstroketext($im, $size, $angle, $x, $y,                                                       &$textcolor, &$strokecolor, $fontfile, $text, $px)
				} else {
              
   				localimagettfstroketext($im,   $rowscale*$sizefac,     90,    ( ($cki*$rowscale)-(5))*$sizefac, floor($imh/2)+(20*$sizefac), $usefontcolor, $darkgrey, $fontb, iconvutf($collectioncode), $sizefac);
				}
            $starty=$starty+$thisrowh;
				//add star ico
				$tmpimgico_file="./star-icon.jpg";
				list($origwidth, $origheight) = getimagesize($tmpimgico_file);
				$tmpimgico_file = imagecreatefromjpeg($tmpimgico_file);
				//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
				///imagecopyresampled($im, $tmpimgico_file, floor(($rowscale/2)-($origwidth/2)), $imh-$origheight, 0, 0, $origwidth, $origheight, $origwidth, $origheight);
			} else {
            $starty=0-(7*$sizefac);
			}
         $starty=$starty+($rowscale*$sizefac);//-(7*$sizefac);
         //printr($callnause);
			while (list($ck,$cv)=each($callnause)) {
				//echo "$ck,$cv;rowscale=$rowscale;starty=$starty;localrowscale=$localrowscale<BR>";
				$localrowscale=$rowscale;
				//$localrowscale=30;
            //echo "[$localrowscale];";
				$cki++;
				if (strlen($cv)>100) {
					$cv=mb_substr($cv,0,100)."..";
				} 
				$colorbari=strtolower(barcodeval_get("BARCODE-blockbc-ribbon-colorofchar[$cv]"));
				if ($colorbari=="") {$colorbari="ffffff";}
				//echo "<FONT  COLOR='$colorbari'>BARCODE-blockbc-ribbon-colorofchar[$cv]=$colorbari;</FONT><BR>";
				$colorbari=trim($colorbari,'#');
				$usefontcolor=$white;
				if ($colorbari=="ffffff") {$usefontcolor=$black;}
				if (strlen($cv)>1) {$localrowscale=22;}
            if (strtolower(trim($colorbari," #"))=="ffffff" && $ck>2) {
               $rowscale=25;
            } else {
               $rowscale=40;
            }
				//echo $colorbari;
				$colorbguse=Array();
				$colorbguse[1]=hexdec(substr($colorbari,0,2));
				$colorbguse[2]=hexdec(substr($colorbari,2,2));
				$colorbguse[3]=hexdec(substr($colorbari,4,2));
				//printr($colorbguse);
				$tmpcolor = imagecolorallocate($im, $colorbguse[1], $colorbguse[2], $colorbguse[3]);
				//printr($tmpcolor);
           // printr($colorbguse);
				//echo gettype( $tmpcolor);
				//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2             , int $y2 , int $color )
            $tmpthisrowh=($rowscale*$sizefac);
            if (strtolower(trim($colorbari," #"))!="ffffff") {
               //echo "   $starty         ,    0    , ($tmpthisrowh)+$starty, $imh, $tmpcolor);<BR>";
   				imagefilledrectangle($im,      ($starty-$tmpthisrowh)+(7*$sizefac)         ,    0    , $starty+(7*$sizefac), $imh, $tmpcolor);
            }
            
               
				//echo "imagefilledrectangle($im,  (($cki-1)*$rowscale),0, ($cki*$rowscale), $imh, $tmpcolor)<BR>";
				//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
				//imagettftext($im, $localrowscale*$sizefac, 90,  (($cki*$rowscale)-(2+$cki))*$sizefac,floor($imh/2)+10, $usefontcolor, $fontb, iconvutf($cv));
				if (($colorbguse[1]=="255" && $colorbguse[2] =="255" && $colorbguse[3]=="255") || strtolower($addstrokeline)=="no") {
   				//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
   				imagettftext($im, $localrowscale*$sizefac, 90,  $starty,floor($imh/2)+10, $usefontcolor, $fontb, iconvutf($cv));
   				//localimagettfstroketext($im, $size, $angle, $x, $y,                                                       &$textcolor, &$strokecolor, $fontfile, $text, $px)
               //$starty=$starty+((($rowscale)-(2+$cki))*$sizefac);
				} else {
   				localimagettfstroketext($im,   $localrowscale*$sizefac,     90, $starty,floor($imh/2)+10, $usefontcolor, $darkgrey, $fontb, iconvutf($cv), $sizefac);
               //$starty=$starty+((($rowscale)-(2+$cki))*$sizefac);
				}
            $starty=$starty+$tmpthisrowh;
			}
			$cki++;
         //echo "[$rowscale-]".$mid[inumber];
			imagettftext($im, 20*$sizefac, 90,  (($starty)-(2+$cki)),floor($imh/2)+(10*$sizefac), $black, $fontb, iconvutf($mid[inumber]));

			//imagettftext($im, 17, 90, $imw-50, floor($imh/2)+10, $black, $fontb, iconvutf($mid[inumber]));
         $dspbc="";
			if (strtolower(barcodeval_get("BARCODE-blockbc-ribbon-includebarcode"))=="yes") {
            $dspbc="$barcodeBC";
			}
         $dspmtitle="";
         //echo strtolower(barcodeval_get("BARCODE-blockbc-ribbon-showtitle"));
			if (strtolower(barcodeval_get("BARCODE-blockbc-ribbon-showtitle"))=="yes") {
            $dspmtitle="$mtitle";
			}
         $dspinfo="$dspbc-$dspmtitle";
         $dspinfo=trim($dspinfo," -");
         $addtext=str_replace("[bc]",$barcodeBC,$addtext);
         $addtext=str_replace("[bib]",$mid[pid],$addtext);
			imagettftext($im, (17+$showtitlesize)*$sizefac, 90, $imw-(30*$sizefac), $imh-(10*$sizefac), $black, $font, ($dspinfo));
			imagettftext($im, (17+$addtextsize)*$sizefac, 90, $imw-(10*$sizefac), $imh-(10*$sizefac), $black, $font, iconvutf($addtext));

		}
		
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="singlecolor") {
		@unlink($outputfile);
		$isshowyear=trim(barcodeval_get("BARCODE-blockbc-singlecolor-isshowyear"));
		$addtext=barcodeval_get("BARCODE-blockbc-singlecolor-addtext");
		$callntag=barcodeval_get("BARCODE-blockbc-singlecolor-callntag");
		$callnformat=barcodeval_get("BARCODE-blockbc-singlecolor-callnformat");
		$fontsize1=floor(barcodeval_get("BARCODE-blockbc-singlecolor-fontsize1"))*$sizefac;
		$fontsize2=floor(barcodeval_get("BARCODE-blockbc-singlecolor-fontsize2"))*$sizefac;
		$fontsizebc=floor(barcodeval_get("BARCODE-blockbc-singlecolor-fontsizebc"));
		$fontsize1isb=trim(barcodeval_get("BARCODE-blockbc-singlecolor-fontsize1isb"));
		$fontsize2isb=trim(barcodeval_get("BARCODE-blockbc-singlecolor-fontsize2isb"));
		$fontsizebcisb=trim(barcodeval_get("BARCODE-blockbc-singlecolor-fontsizebcisb"));
		$isshowtitle=strtolower(barcodeval_get("BARCODE-blockbc-singlecolor-isshowtitle"));
		$linespace=strtolower(barcodeval_get("BARCODE-blockbc-singlecolor-linespace"))*$sizefac;
		$addtext=iconvutf($addtext);

		$mid=tmq("select * from media_mid where bcode='$barcodeBC' limit 1 ",false);
		$mid=tmq_fetch_array($mid);
		$m=tmq("select * from media where ID='$mid[pid]' limit 1 ");
		if (tmq_num_rows($m)==0) {
			$error="medianotfound";
		} else {
			$m=tmq_fetch_array($m);
			$mtitle=dspmarc(substr($m[tag245],2). substr($m[tag246],2));
			//echo $mtitle;
			//$mtitles($mtitle,0,30);
			$mtitle=iconvutf(trim($mtitle));
			$calln=trim($mid[calln]);
			//$calln=dspmarc($calln);
			//echo "[$calln]";
			if ($calln=="") {
				$calln=mb_substr($m["$callntag"],2);
				//echo "$calln<BR>";
				$calln=dspmarc($calln,"_");
				$calln=str_replace("_","^",$calln);
				//echo "$calln<BR>";
			}
			if ($callntag=="auto") {
				$calln=(marc_getmidcalln($barcodeBC));
				echo "$calln<BR>";
				$calln=dspmarc($calln,"_");
				$calln=str_replace("_","^",$calln);
				//echo "$calln<BR>";
            //echo "[$calln]";
			}
			//printr($mid);
			//echo "$calln";
			$calln=trim($calln,'^');
			$calln=trim($calln);
			$calln=str_replace(',,',',',$calln);
			$calln=trim($calln,' ,');
			$tmpyeartag=getval("search","yearfield_tagname");
			$tmplcallntag=getval("MARC","def_local_callnum");
			$tmpyeardata="";
			if ($isshowyear=="yes") {
				$tmpyeardata=mb_substr($m[$tmpyeartag],2);
			}
			$calln=local_meltcalln($calln,$callnformat,$tmpyeardata,substr($m[$tmplcallntag],2),$mid[inumber]);
			//printr($calln);
			@reset($calln);
			$cki=0;
			$beginl=floor(barcodeval_get("BARCODE-blockbc-singlecolor-ctrlleft"))*$sizefac;
			$beginr=floor(barcodeval_get("BARCODE-blockbc-singlecolor-ctrltop"))*$sizefac;
			//echo "[$sizefac-$beginl/$beginr]";
			while (list($ck,$cv)=each($calln)) {
				//printr($cv);
				$cki++;
				$cv=trim($cv);
				$cvorig=($cv);
				if (strlen($cv)>200) {
					$cv=mb_substr($cv,0,200)."..";
				}
				if ($cki==1) {
					//bg
					$bgs=tmq("select * from blockbarcode_singlecolor where (prefix)='".(addslashes(trim($cvorig)))."' ");
					$bgs=tmq_fetch_array($bgs);
					if ($bgs[name]!="" && file_exists($dcrs."_tmp/bcsinglecolor/$bgs[id].jpg")) {
						$sourcebg = imagecreatefromjpeg($dcrs."_tmp/bcsinglecolor/$bgs[id].jpg");
						list($bgwidth, $bgheight) = getimagesize($dcrs."_tmp/bcsinglecolor/$bgs[id].jpg");
						imagecopyresized($im, $sourcebg, 0, 0, 0, 0, $imw, $imh, $bgwidth, $bgheight);

					}
					//echo ($imw/2);
					if (strtolower($fontsize1isb)=="yes") {
						$singlecusefont=$fontb;
					} else {
						$singlecusefont=$font;
					}
					if ($bgs[name]!="") {
					 $cv=$bgs[name];
					}
					imagettftext($im, $fontsize1, 0,$beginl, $beginr,  $black, $singlecusefont, iconvutf($cv)."");
				} else {
					if (strtolower($fontsize2isb)=="yes") {
						$singlecusefont=$fontb;
					} else {
						$singlecusefont=$font;
					}
					//echo singlecusefont;
			$beginl=floor(barcodeval_get("BARCODE-blockbc-singlecolor-ctrlleft2"))*$sizefac;
			$beginr=floor(barcodeval_get("BARCODE-blockbc-singlecolor-ctrltop2"))*$sizefac;
					imagettftext($im, $fontsize2, 90,$beginl+($cki*$linespace)-$fontsize2+3, $beginr+$fontsize1-10,  $black, $singlecusefont, iconvutf($cv.""));
				}
				//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			}
			//$calln=iconvutf($calln);
			
			$spinew=floor($imw*($spinewidth/100));
			$bcalai=$imw-$spinew;
			//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			$barcodeBCdsp=$barcodeBC;
			if ($isshowtitle=="yes") {
			   //echo "HERE";
			   $barcodeBCdsp=$barcodeBC."-".$mtitle;
				//imagettftext($im, 15, 90, $imw-25-15, $imh-3, $black, $font, $mtitle);
			}
			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
			//imagefilledrectangle($im, 0, $imh-15, $imw, $imh, $colorbar);
			imagettftext($im, 17*$sizefac, 90, $imw-((5+15)*$sizefac), $imh-(3*$sizefac), $black, $font, $addtext);
			if (strtolower($fontsizebcisb)=="yes") {
				$singlecusefont=$fontb;
			} else {
				$singlecusefont=$font;
			}
			//imagefilledrectangle($im, $imw-15, $imh, $imw-15, $imh, $black);
			imagettftext($im, $fontsizebc*$sizefac, 90, $imw-(3*$sizefac), $imh-(3*$sizefac), $black, $singlecusefont, $barcodeBCdsp);

		}
		
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="qrcode") {
	include_once($dcrs."inc/phpqrcode/qrlib.php");
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-qrcode-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-qrcode-addtext");
		$callntag=barcodeval_get("BARCODE-blockbc-qrcode-callntag");
		$callnformat=barcodeval_get("BARCODE-blockbc-qrcode-callnformat");
		$isshowttcalln=barcodeval_get("BARCODE-blockbc-qrcode-isshowttcalln");
		$spinewidth=floor($spinewidth);
		$addtext=iconvutf($addtext);
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-qrcode-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-qrcode-addtext");
		$addtext=iconvutf($addtext);
		$longtexti=0;
		if ($BCisshowtext=="yes") { 
			//$BCisshowtext=1; 
			$longtexti=$longtexti+1;
			imagettftext($im, 20*$sizefac, 0, floor($imw/2)+(12*$sizefac), 25*$sizefac, $black, $fontb, "$barcodeBC");
		} else {
			//$BCisshowtext=0; 
		}

		$tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$barcodeBC.JPG";
		QRcode::png($barcodeBC,$tmpimgbc_file, 'L', 4, 2);

	    $mediainfo=tmq("select * from media_mid where bcode='$barcodeBC'");
	    if (strtolower($isshowttcalln)=="yes" && tmq_num_rows($mediainfo)==0) {
			$error="medianotfound";
		} else {
   		//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
         $mediainfor=tfa($mediainfo);
   		//$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", $BCisshowtext ,$tmpimgbc_file);
   		list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
   		$new_width = $origwidth ;
   		$new_height = $origheight ;
   		//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
   		$tmpimgbc_file = imagecreatefrompng($tmpimgbc_file);
   		//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
   		imagecopyresampled($im, $tmpimgbc_file, 0*$sizefac, 0*$sizefac, 0, 0, $imh, $imh, $origwidth, $origheight);
   		imagedestroy($tmpimgbc_file);
   		//title calln
   		if (strtolower($isshowttcalln)=="yes") {
   		    $longtexti=2;
   			imagettftext($im, 19*$sizefac, 0, floor($imw/2)+(12*$sizefac), ((22*$sizefac)*$longtexti)+(5*$sizefac), $black, $font, trim(marc_gettitle($mediainfor[pid])));
   		    $longtexti=3;
   			imagettftext($im, 19*$sizefac, 0, floor($imw/2)+(12*$sizefac), ((22*$sizefac)*$longtexti)+(5*$sizefac), $black, $font, trim(marc_getcalln($mediainfor[pid])));
   		}
         $addtext=str_replace("[bc]",$barcodeBC,$addtext);
         $addtext=str_replace("[bib]",$mediainfor[pid],$addtext);

   		$longtext=explodenewline($addtext);
   		@reset($longtext);
   		while (list($longtextk,$longtextv)=each($longtext)) {
   			$longtexti++;
   			imagettftext($im, 19*$sizefac, 0, floor($imw/2)+(12*$sizefac), ((22*$sizefac)*$longtexti)+(5*$sizefac), $black, $font, $longtextv);
   		}
   		//imagettftext($im, 19*$sizefac, 0, floor($imw/2)+(5*$sizefac), (22+22)*$sizefac, $black, $font, $addtext);

   		//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
   		imagefilledrectangle($im, floor($imw/2), $imh-(10*$sizefac), $imw, $imh, $colorbar);
   		@unlink($tmpimgbc_file);
   	}
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
	$tmpimg_file=$dcrs."library.blockbarcode/medianotfound.jpg";
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

	imagettftext($im, 12*$sizefac, 0,  (2*$sizefac), (12*$sizefac), $darkred, $font, "Barcode not found");
	imagettftext($im, 10*$sizefac, 0,  (2*$sizefac), (10*$sizefac)+(12*$sizefac), $black, $font, "[$barcodeBC]");
	// Save the image as 
	//echo "[$barcodeoutput_dcrs]";
	imagejpeg($im, $barcodeoutput_dcrs,100);
	// Free up memory
	imagedestroy($im);
} else {
	
}
?>