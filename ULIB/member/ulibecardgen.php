<?php
include("../inc/config.inc.php");

html_start();

head();
mn_web("member");
$genid=floor($genid);
if ($genid==0) {
   html_dialog("","genid not found");
   die;
}
$s=tmq("select * from ulibecard_bg where id=$genid");
if (tnr($s)==0) {
   html_dialog("","genid not found (in db)");
   die;
}
$s=tfa($s);
$mem=tmq("select * from member where UserAdminID='$_memid' ");
$mem=tfa($mem);
$memtype=tmq("select * from member_type where type='$mem[type]' ");
$memtype=tfa($memtype);
//printr($mem);
//printr($s);
include_once($dcrs."inc/phpqrcode/qrlib.php");

	$imw=floor(1024);
	$imh=floor(512);
	$im = imagecreatetruecolor($imw, $imh);
	
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);
	$darkgrey = imagecolorallocate($im, 64, 64, 64);
	$black = imagecolorallocate($im, 1, 1, 1);
	$darkred = imagecolorallocate($im, 128, 1, 1);
	if ($font=="") { $font="THSarabunNew";}
	$fontb=$dcrs."library.blockbarcode/$font"."b.ttf";
	$font=$dcrs."library.blockbarcode/$font.ttf";
	//printr($_SESSION);
	$outputfile=$dcrs."_tmp/ecard/_cache/$_memid.jpg";
	$bgfile=$dcrs."_tmp/ecard/$genid.jpg";
	
	$iwidth=600;
	$iheight=120;
	
	//add bg
   //imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
   $tmpimgbc_file = imagecreatefromjpeg($bgfile);
   //imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
   imagecopyresampled($im, $tmpimgbc_file, 0, 0, 0, 0, 1024, 512, 1024, 512);

   //imagettftext ( resource $image , $size , $angle , $x , int $y , int $color , string $fontfile , string $text )
   imagettftext($im, 28, 0, 570, 200, $black, $fontb, strip_tags("ชื่อ-สกุล: ".get_member_name($_memid)));
   imagettftext($im, 22, 0, 570, 240, $black, $font, strip_tags("รหัส: ".($_memid)));
   imagettftext($im, 22, 0, 570, 280, $black, $font, strip_tags(getlang($_ROOMWORD).": ".get_room_name($mem[room])));
   imagettftext($im, 22, 0, 570, 320, $black, $font, strip_tags("ประเภทสมาชิก: ".getlang($memtype[descr])));
   imagettftext($im, 22, 0, 570, 390, $black, $fontb, strip_tags($_memid));
   imagettftext($im, 12, 0, 5, 507, $black, $fontb, strip_tags(date("d/m/Y")));
   //imagettftext($im, 17*$sizefac, 0, $spinew+(10*$sizefac), 44*$sizefac, $black, $font, $calln);
   $tmpimgbc_file="$dcrs/_tmp/_bctemp/bc_$_tmid.JPG";
   //echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
   
   //barcode
   $tmp= Barcode39($_memid, $iwidth, $iheight, 100, "JPEG", 0 ,$tmpimgbc_file);
   list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
   $new_width = $origwidth ;
   $new_height = $origheight ;
   //imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
   $tmpimgbc_file = imagecreatefromjpeg($tmpimgbc_file);
   //imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
   imagecopyresampled($im, $tmpimgbc_file, 570, 400, 0, 0, 390, 80, $origwidth, $origheight);
   imagedestroy($tmpimgbc_file);
   
   //qr code
	if ($savethis=="yes") {
	  tmq("delete from ulibecard where memid='$_memid' ");
	  $now=time();
	  tmq("insert into ulibecard set memid='$_memid',dt=$now");
	  $newid=tmq_insert_id();
	  echo "[ecard".$newid."]";
	}
   $tmpimgbc_file="$dcrs/_tmp/_bctemp/bcqr_$_memid.JPG";
   
	QRcode::png("ecard".$newid,$tmpimgbc_file, 'L', 4, 2);

	//echo "Barcode39($barcodeBC, $iwidth, $iheight, 100, JPEG, $BCisshowtext ,$tmpimgbc_file);";
	//$tmp= Barcode39($barcodeBC, $iwidth, $iheight, 100, "JPEG", $BCisshowtext ,$tmpimgbc_file);
	list($origwidth, $origheight) = getimagesize($tmpimgbc_file);
	$new_width = $origwidth ;
	$new_height = $origheight ;
	//imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	$tmpimgbc_file = imagecreatefrompng($tmpimgbc_file);
	//imagecopyresampled( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
	imagecopyresampled($im, $tmpimgbc_file, 20, 20, 0, 0, 465, 465, $origwidth, $origheight);
	imagedestroy($tmpimgbc_file);
		
   
   	// Save the image as 
	imagejpeg($im, $outputfile,100);
	
	if ($savethis=="yes") {
	  copy($outputfile,$dcrs."_tmp/ecard/save/$_memid.jpg");
	  ?>
	  <script>
	  alert("บันทึกเรียบร้อย");
	  top.location="<?php echo $dcrURL?>member/mainadmin.php?mempagemode=ulibecard";
	  </script>
	  
	  <?php
	  die;
	}
	html_dialog("","ด้านล่าง<u>เป็นภาพตัวอย่างเท่านั้น</u> <BR><BR>หากต้องการบันทึก ให้คลิกที่ปุ่ม [บันทึก QR โค้ดนี้เป็นบัตรประจำตัว] ที่ด้านล่าง");
?> <center><BR>
<img width=500 src="<?php echo $dcrURL;?>_tmp/ecard/_cache/<?php echo $_memid?>.jpg?rand=<?php echo randid(); ?>" border=0><BR><BR>
<a class=a_btn href="<?php echo $PHP_SELF?>?genid=<?php echo $genid;?>&savethis=yes">บันทึก QR โค้ดนี้เป็นบัตรประจำตัว</a><?php

?>
</center>