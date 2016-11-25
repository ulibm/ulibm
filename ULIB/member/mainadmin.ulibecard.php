<table align=center cellpadding=0 cellspacing=0 border=0 width=<?php  echo $_TBWIDTH;?>>
<tr>
	<td><?php 
	pagesection(str_webpagereplacer(getlang(stripslashes(barcodeval_get("ulibecard-systemname")))));
	echo str_webpagereplacer(getlang(stripslashes(barcodeval_get("ulibecard-agreement"))));
	
	if ($deletecard=="yes") {
	  @unlink($dcrs."_tmp/ecard/save/$_memid.jpg");
	  tmq("delete from ulibecard where memid='$_memid' ");
	}
	
	$s=tmq("select * from ulibecard where memid='$_memid' ");
	echo "<BR>";
	if (tnr($s)==0) {
	  html_dialog("","ขณะนี้คุณยังไม่มีบัตรอิเล็กทรอนิกส์ส่วนตัว คุณสามารถคลิกที่ลิงค์ด้านล่างเพื่อสร้าง");
	} else {
	  $s=tfa($s);
	  html_dialog("","คุณมีบัตรอิเล็กทรอนิกส์ส่วนตัวดังภาพด้านล่าง <BR> <BR> 
	  หากคุณต้องการลบบัตรอิเล็กทรอนิกส์นี้ คุณสามารถคลิกที่ลิงค์ [ลบบัตรนี้] เพื่อเลิกใช้งาน หลังจากนั้น ถึงแม้คุณยังเซฟภาพบัตรนี้ไว้ ก็จะไม่สามารถใช้งานได้<BR><BR> 
	  หรือคุณสามารถสร้างบัตรใหม่ได้ โดยคลิกลิงค์ด้านล่าง โดยบัตรที่เคยเซฟไว้ก่อนหน้า ก็จะถูกยกเลิกเช่นกัน");
	  ?><br><center>
<a href="<?php echo $dcrURL;?>_tmp/ecard/save/<?php echo $_memid?>.jpg?rand=<?php echo randid(); ?>"><img width=1000 src="<?php echo $dcrURL;?>_tmp/ecard/save/<?php echo $_memid?>.jpg?rand=<?php echo randid(); ?>" border=0></a><BR>
<font class=smaller2 style="color:darkgray">สร้างเมื่อ <?php echo ymd_datestr($s[dt])?></font>
<BR>
<a class=a_btn style='color:darkred' href="<?php echo $dcrURL?>member/mainadmin.php?mempagemode=ulibecard&deletecard=yes"
onclick="return confirm('Delete?');"
>ลบบัตรนี้</a>
</center><?php
	}
	?>
	<center><a href="mainadmin.php?mempagemode=ulibecard2" class="bigger a_btn"><?php  echo getlang("สร้างบัตรอิเล็กทรอนิกส์::l::Create Electronic Card");?></a></center>
	</td>
</tr>
</table>