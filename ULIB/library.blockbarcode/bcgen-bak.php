<?php //พ
@header("Content-Type: text/html");
if (!is_array($dbcallngenner)) {
	$dbcallngenner=tmq_dump2("keyhelp_callngenner","id","prefix");
}
if(!function_exists("local_meltcalln")) {
	function local_meltcalln($c,$f,$yea,$localcalln,$inumber) {
		//echo "local_meltcalln($c,$f,$yea,$localcalln,$inumber)<BR>";
		global $dbcallngenner;
		//echo "[$f-$c]";
		$a=str_replace('  ',' ',$c);
		$a=trim($a);
		$a=str_replace(' ','%',$a);
		if ($f=="DC") {

			$a=str_replace('.','%.',$a);
			$a=explode('%',$a);//printr($a);
			@reset($a);
			$result=Array();
			$i=0;
			while (list($k,$v)=each($a)) {
				$i=$i+100;
				$result[$i]=$v;
			}
			/*
			$yea=marc_getsubfields($yea,"no");
			$yea=trim($yea[c]);
			$yea=trim($yea,'. []?');

			if ($yea!="") {
				$i=$i+100;
				$result[$i]=$yea;
			}
			*/
			$i=$i+100;
			$result[$i]=$inumber;
		}

		if ($f=="LC") {

			$tmpfirstdigita=Array();
			for ($tmpfirstdigiti=0;$tmpfirstdigiti<=10;$tmpfirstdigiti++) {
				$tmpfirstdigita[]=strpos($a,"$tmpfirstdigiti");
			}
			//printr($tmpfirstdigita);
			$tmpfirstdigita=arr_filter_remnull($tmpfirstdigita);
			$tmpfirstdigitres=@min($tmpfirstdigita);
			$i=$i+100;
			$result[$i]=trim(substr($a,0,floor($tmpfirstdigitres)));
			$i=$i+50;
			$result[$i]=trim(substr($a,floor($tmpfirstdigitres)));
			//printr($tmpfirstdigita);
			//echo "[$tmpfirstdigitres]";

			//$a=str_replace('.','%.',$a);
			//$a=explode('%',$a);// 	printr($a);
			$x=explode('%',$result[$i]);
			//printr($x);
			@reset($x);
			//$result=Array();
			while (list($k,$v)=each($x)) {
				$result[$i]=$v;
				$i=$i+100;
			}
			/*
			$yea=marc_getsubfields($yea,"no");
			$yea=trim($yea[c]);
			$yea=trim($yea,'. []?');
			if ($yea!="") {
				$i=$i+100;
				$result[$i]=$yea;
			}
			*/
			$i=$i+100;
			$result[$i]=$inumber;
			//collection
			if (in_array("$a[0]",$dbcallngenner)) {
				$calclassificationcalln=200;
			} else {
				$calclassificationcalln=100;
			}
			//calclassificationcalln
			//echo $calclassificationcalln."=".$result[$calclassificationcalln];
			/*
			$tmp=rtrim($result[$calclassificationcalln],".123456789");
			if ("$tmp"!="$result[$calclassificationcalln]") {
				$fisrtrow=""; 
				$secondrow="";
				for ($ci=0;$ci<=strlen($result[$calclassificationcalln]);$ci++) {
					//echo substr($result[$calclassificationcalln],$ci,1);
					if (!is_numeric(substr($result[$calclassificationcalln],$ci,1))) {
						$fisrtrow.=substr($result[$calclassificationcalln],$ci,1);
					} else {
						$secondrow.=substr($result[$calclassificationcalln],$ci,1);
					}
				}
				$result[$calclassificationcalln]=$fisrtrow;
				$result[$calclassificationcalln+50]=$secondrow;
				//echo "[$fisrtrow/$secondrow]";
			}
			*/
		}

		ksort($result);
		$result=arr_filter_remnull($result);
		@reset($result);
		return $result;
	}
}

if ($barcodeBC=="getexample") {
	$barcodeBC=trim(barcodeval_get("BARCODE-blockbc-allbc"));
	$barcodeBC=explodenewline($barcodeBC);
	$barcodeBC=$barcodeBC[0];
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
	$imw=floor(7*$imsize);
	$imh=floor(3.73*$imsize);
	$im = imagecreatetruecolor($imw, $imh);
	//$im = imagecreate($imw, $imh);
	// Create some colors
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);
	$black = imagecolorallocate($im, 1, 1, 1);
	$iwidth=floor(strlen($barcodeBC)*30);
	$iheight=floor(strlen($barcodeBC)*10);
	//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
	imagefilledrectangle($im,  0,0, $imw, $imh, $white);

	$colorbar = imagecolorallocate($im, $colorbar[1], $colorbar[2], $colorbar[3]);
	$font = barcodeval_get("BARCODE-blockbc-font");
	if ($font=="") { $font="Browalia";}
	$fontb=$dcrs."library.blockbarcode/$font"."b.ttf";
	$font=$dcrs."library.blockbarcode/$font.ttf";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($bcgenmode=="titlebc") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-titlebc-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-titlebc-addtext");
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
			$mtitle=substr($mtitle,0,30);
			$mtitle=iconvutf(trim($mtitle));
			$calln=trim($mid[calln]);
			if ($calln=="") {
				$calln=marc_getcalln($mid[pid],", ");
			}
			$calln=str_replace(',,',',',$calln);
			$calln=iconvutf($calln,',');
			$calln=trim($calln,' ,');
			
			//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			imagettftext($im, 18, 0, 10, 22, $black, $font, $mtitle);
			imagettftext($im, 17, 0, 10, 40, $black, $font, $calln);
			$tmpimgbc_file="$dcrs/_tmp/bc_$barcodeBC.JPG";
			//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
			$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", $BCisshowtext ,$tmpimgbc_file);
			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
			$new_width = $origwidth ;
			$new_height = $origheight ;
			//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
			imagecopyresampled($im, $tmpimgbc_file, 5, 50, 0, 0, $imw-10, $imh-95, $origwidth, $origheight);
			imagettftext($im, 17, 0, 10, $imh-25, $black, $font, $addtext);

			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
			imagefilledrectangle($im, 0, $imh-15, $imw, $imh, $colorbar);
		}
		
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="logobc") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-logobc-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-logobc-addtext");
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
			$mtitle=substr($mtitle,0,30);
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
			imagettftext($im, 18, 0, $spinew+10, 22, $black, $font, $mtitle);
			imagettftext($im, 17, 0, $spinew+10, 44, $black, $font, $calln);
			$tmpimgbc_file="$dcrs/_tmp/bc_$barcodeBC.JPG";
			//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
			$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", $BCisshowtext ,$tmpimgbc_file);
			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
			$new_width = $origwidth ;
			$new_height = $origheight ;
			//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
			imagecopyresampled($im, $tmpimgbc_file, $spinew+5, 50, 0, 0, $bcalai-10, $imh-90, $origwidth, $origheight);
			imagedestroy($tmpimgbc_file);
			//logo
			$tmpimg_file="$dcrs/_tmp/_barcode-logobc.jpg";
			//echo "[$tmpimg_file]";
			$tmpimglogo_file = imagecreatefromjpeg($tmpimg_file);
			list($origwidth, $origheight) = getimagesize($tmpimg_file);
			imagecopyresampled($im, $tmpimglogo_file , 5, 5, 0, 0, $spinew-10, $imh-(10+15), $origwidth, $origheight);
			imagedestroy($tmpimglogo_file );

			
			imagettftext($im, 17, 0, $spinew+10, $imh-20, $black, $font, $addtext);

			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
			imagefilledrectangle($im, 0, $imh-15, $imw, $imh, $colorbar);

		}
		
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="plain") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-plain-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-plain-addtext");
		$addtext=iconvutf($addtext);
		if ($BCisshowtext=="yes") { 
			$BCisshowtext=1; 
		} else {
			$BCisshowtext=0; 
		}

		$tmpimgbc_file="$dcrs/_tmp/bc_$barcodeBC.JPG";
		//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
		$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", $BCisshowtext ,$tmpimgbc_file);
		list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
		$new_width = $origwidth ;
		$new_height = $origheight ;
		//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
		//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
		imagecopyresampled($im, $tmpimgbc_file, 5, 30, 0, 0, $imw-8, $imh-50, $origwidth, $origheight);
		imagedestroy($tmpimgbc_file);
		imagettftext($im, 19, 0, 5, 22, $black, $font, $addtext);

		//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
		imagefilledrectangle($im, 0, $imh-15, $imw, $imh, $colorbar);

	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="standard") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-standard-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-standard-addtext");
		$spinewidth=barcodeval_get("BARCODE-blockbc-standard-spinewidth");
		$callntag=barcodeval_get("BARCODE-blockbc-standard-callntag");
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
			$mtitle=substr($mtitle,0,30);
			$mtitle=iconvutf(trim($mtitle));
			$calln=trim($mid[calln]);
			if ($calln=="") {
				$calln=substr(rtrim($m["$callntag"]),2);
				//echo $calln;
				$calln=dspmarc($calln,"%");
			}
			//printr($m);
			//echo $calln;
			//echo("$callntag-".$calln);
			$calln=trim($calln,'%');
			$calln=trim($calln);
			$calln=str_replace(',,',',',$calln);
			$calln=trim($calln,' ,');
			$tmpyeartag=getval("search","yearfield_tagname");
			$tmplcallntag=getval("MARC","def_local_callnum");
			
			$calln=local_meltcalln($calln,$callnformat,substr($m[$tmpyeartag],2),substr($m[$tmplcallntag],2),$mid[inumber]);
			//printr($calln);
			@reset($calln);
			$cki=0;
			while (list($ck,$cv)=each($calln)) {
				$cki++;
				if (strlen($cv)>6) {
					$cv=substr($cv,0,6)."..";
				}
				if ($cki==1) {
					imagettftext($im, 22, 0, 5, 2+($cki*22), $black, $fontb, iconvutf($cv));
				} else {
					imagettftext($im, 22, 0, 10, 2+($cki*22), $black, $font, iconvutf($cv));
				}
				//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			}
			//$calln=iconvutf($calln);
			
			$spinew=floor($imw*($spinewidth/100));
			$bcalai=$imw-$spinew;
			//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
			imagettftext($im, 18, 0, $spinew+10, 25, $black, $font, $mtitle);
			$tmpimgbc_file="$dcrs/_tmp/bc_$barcodeBC.JPG";
			//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
			$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", $BCisshowtext ,$tmpimgbc_file);
			list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
			$new_width = $origwidth ;
			$new_height = $origheight ;
			//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			$tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
			//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
			imagecopyresampled($im, $tmpimgbc_file, $spinew+5, 33, 0, 0, $bcalai-10, $imh-50-24, $origwidth, $origheight);
			imagedestroy($tmpimgbc_file);

			//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
			imagefilledrectangle($im, 0, $imh-15, $imw, $imh, $colorbar);
			imagettftext($im, 17, 0, $spinew+10, $imh-24, $black, $font, $addtext);

		}
		
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($bcgenmode=="ribbon") {
		@unlink($outputfile);
		$BCisshowtext=trim(barcodeval_get("BARCODE-blockbc-ribbon-isshownum"));
		$addtext=barcodeval_get("BARCODE-blockbc-ribbon-addtext");
		$callntag=barcodeval_get("BARCODE-blockbc-ribbon-callntag");
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
			$mtitle=substr($mtitle,0,30);
			$mtitle=iconvutf(trim($mtitle));
			$calln=trim($mid[calln]);
			if ($calln=="") {
				$calln=trim(substr($m[$callntag],2));
				$calln=dspmarc($calln);
			}
			$calln=str_replace('  ',' ',$calln);
			$calln=trim($calln);
			$callna=explode(' ',$calln);
			$collectioncode="";
			$tmpfirstdigita=Array();
			for ($tmpfirstdigiti=0;$tmpfirstdigiti<=10;$tmpfirstdigiti++) {
				$tmpfirstdigita[]=strpos($calln,"$tmpfirstdigiti");
			}
			$tmpfirstdigita=arr_filter_remnull($tmpfirstdigita);
			//printr($tmpfirstdigita);
			$tmpfirstdigitres=min($tmpfirstdigita);
			//echo "[$calln]first digit =$tmpfirstdigitres; ";
			//echo substr($calln,0,floor($tmpfirstdigitres));
			if (in_array("$callna[0]",$dbcallngenner)) {

				$collectioncode="$callna[0]";
				$callna=explode(' ',$calln,2);
				$callnause=str_split($callna[1]);
				$callnause=implode('|',$callnause);
				//rem | after dot
				$tmppos = strpos($callnause, '.');
				if ($tmppos === false) {} else {
					$tmpcallnappend=substr($callnause,strpos($callnause,'.'));
					$callnause=substr($callnause,0,(strrpos($callnause,'.'))).str_replace('|','',$tmpcallnappend);
				}
				//echo "[$callnause]";
				$callnause=explode('|',$callnause,5);
				//printr($callnause);
				$callnause[4]=str_replace('|','',$callnause[4]);
			} elseif (trim(substr($calln,0,floor($tmpfirstdigitres)))!="" && $tmpfirstdigitres>1) {
				$collectioncode=trim(substr($calln,0,floor($tmpfirstdigitres)));
				$callnause=str_split(trim(substr($calln,floor($tmpfirstdigitres))));
				$callnause=implode('|',$callnause);
				//rem | after dot
				$tmppos = strpos($callnause, '.');
				if ($tmppos === false) {} else {
					$tmpcallnappend=substr($callnause,strpos($callnause,'.'));
					$callnause=substr($callnause,0,(strrpos($callnause,'.'))).str_replace('|','',$tmpcallnappend);
				}
				//echo "[$callnause]";
				$callnause=explode('|',$callnause,5);
				//printr($callnause);
				$callnause[4]=str_replace('|','',$callnause[4]);
			} else {
				$collectioncode="";
				$callnause=str_split($calln);
				$callnause=implode('|',$callnause);
				//rem | after dot
				$tmppos = strpos($callnause, '.');
				if ($tmppos === false) {} else {
					$tmpcallnappend=substr($callnause,strpos($callnause,'.'));
					$callnause=substr($callnause,0,(strrpos($callnause,'.'))).str_replace('|','',$tmpcallnappend);
				}
				//rem | after space
				$tmppos = strpos($callnause, ' ');
				if ($tmppos === false) {} else {
					$tmpcallnappend=substr($callnause,strpos($callnause,' '));
					$callnause=substr($callnause,0,($tmppos)).str_replace('|','',$tmpcallnappend);
				}
				$callnause=explode('|',$callnause,6);
				$callnause[5]=str_replace('|','',$callnause[5]);
			}
			//printr($callnause);
			$callnause=@arr_filter_remnull($callnause);
			@reset($callnause);
			$callnause=@implode($callnause,"|");
			$callnause=str_replace("  "," ",$callnause);
			$callnause=str_replace(" ","|",$callnause);
			$callnause=explode("|",$callnause);
			
			//printr($callnause);
			@reset($callnause);
			$cki=0;
			$rowscale=40;
			if ($collectioncode!="") {
				$cki++;
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
				imagefilledrectangle($im,  (($cki-1)*$rowscale),0, ($cki*$rowscale), $imh, $tmpcolor);
				//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
				imagettftext($im, $rowscale, 90,  ($cki*$rowscale)-30, floor($imh/2)+20,$usefontcolor, $fontb, iconvutf($collectioncode));
				//add star ico
				/*$tmpimgico_file="./star-icon.jpg";
				list($origwidth, $origheight) = getimagesize($tmpimgico_file);
				$tmpimgico_file = imagecreatefromjpeg($tmpimgico_file);
				//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
				imagecopyresampled($im, $tmpimgico_file, floor(($rowscale/2)-($origwidth/2)), $imh-$origheight, 0, 0, $origwidth, $origheight, $origwidth, $origheight);*/
			}
			while (list($ck,$cv)=each($callnause)) {
				//echo "$ck,$cv;<BR>";
				$localrowscale=$rowscale;

				$cki++;
				if (strlen($cv)>9) {
					$cv=substr($cv,0,8)."..";
				} 
				$colorbari=strtolower(barcodeval_get("BARCODE-blockbc-ribbon-colorofchar[$cv]"));
				if ($colorbari=="") {
					//1st charac color (.9565); is 9
					if (substr($cv,0,1)=='.') {
						$colorbari=substr($cv,1,1);
						$colorbari=strtolower(barcodeval_get("BARCODE-blockbc-ribbon-colorofchar[$colorbari]"));
					}
				}
				if ($colorbari=="") {$colorbari="ffffff";}
				//echo "<FONT  COLOR='$colorbari'>BARCODE-blockbc-ribbon-colorofchar[$cv]=$colorbari;</FONT><BR>";
				$colorbari=trim($colorbari,'#');
				$usefontcolor=$white;
				if ($colorbari=="ffffff") {$usefontcolor=$black;}
				if (strlen($cv)>1) {$localrowscale=22;}
				//echo $colorbari;
				$colorbguse=Array();
				$colorbguse[1]=hexdec(substr($colorbari,0,2));
				$colorbguse[2]=hexdec(substr($colorbari,2,2));
				$colorbguse[3]=hexdec(substr($colorbari,4,2));
				//printr($colorbguse);
				$tmpcolor = imagecolorallocate($im, $colorbguse[1], $colorbguse[2], $colorbguse[3]);
				//printr($tmpcolor);
				//echo gettype( $tmpcolor);
				//imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
				imagefilledrectangle($im,  (($cki-1)*$rowscale),0, ($cki*$rowscale), $imh, $tmpcolor);
				//echo "imagefilledrectangle($im,  (($cki-1)*$rowscale),0, ($cki*$rowscale), $imh, $tmpcolor)<BR>";
				//imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
				/*
				imagettftext($im, $localrowscale, 90, 
					(($cki-1)*$rowscale)+(10),
					($imh/2)+10,
					
				$usefontcolor, $fontb, iconvutf(trim($cv)));*/
				
				imagettftext($im, $localrowscale, 90,  ($cki*$rowscale)-(2+$cki),floor($imh/2)+10, $usefontcolor, $fontb, iconvutf($cv));

				//echo "[ $cki*$rowscale )-(2+$cki) =".($cki*$rowscale)-(2+$cki)."]<BR>";
			}
			$cki++;
			imagettftext($im, 20, 90,  ($cki*$rowscale)-(2+$cki),floor($imh/2)+10, $black, $fontb, iconvutf($mid[inumber]));

			//imagettftext($im, 17, 90, $imw-50, floor($imh/2)+10, $black, $fontb, iconvutf($mid[inumber]));
			imagettftext($im, 17, 90, $imw-30, $imh-10, $black, $fontb, ($mtitle));
			imagettftext($im, 17, 90, $imw-10, $imh-10, $black, $font, iconvutf($addtext));

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
	$barcodeoutput_url=$dcrURL."library.blockbarcode/medianotfound.jpg";
	$barcodeoutput_dcrs=$dcrs."library.blockbarcode/medianotfound.jpg";
} else {
	
}
?>