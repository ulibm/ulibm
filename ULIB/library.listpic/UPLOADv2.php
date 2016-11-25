<?php 
	
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="listmempic";
        mn_lib();
		pagesection(getlang("อัพโหลดภาพสมาชิก::l::Upload member's photo"));

uploadengine("pic/","jpgonly","origname");
			?>

<CENTER>
<BR>
<?php echo getlang("ค่าปกติคือ กว้าง 128 สูง 144 , เป็นไฟล์ Jpg เท่านั้น::l::Default is width 128 height 144, Jpg file only");?>
<BR>
<A HREF="index.php"><B><?php  echo getlang("กลับ::l::Back"); ?></B></A></CENTER>
					  <?php 
foot();
?>