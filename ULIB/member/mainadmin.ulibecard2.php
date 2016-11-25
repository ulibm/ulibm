<table align=center cellpadding=0 cellspacing=0 border=0 width=<?php  echo $_TBWIDTH;?>>
<tr>
	<td><?php 
	pagesection(str_webpagereplacer(getlang(stripslashes(barcodeval_get("ulibecard-systemname")))));
	html_dialog("","กรุณาเลือกรูปแบบบัตรที่ท่านต้องการ");
	$s=tmq("select * from ulibecard_bg where lower(isuse)='yes' ");
	while ($r=tfa($s)) {
	  if (!file_exists($dcrs."_tmp/ecard/$r[id].jpg")) {
	     continue;
	  }
	  ?>
	  <a href="ulibecardgen.php?genid=<?php echo $r[id];?>" rel="gb_page_fs[]"><img src="<?php echo $dcrURL;?>_tmp/ecard/<?php echo $r[id];?>.jpg" border=0 width=240 height="120"></a>
	  <?php
	}
	?><br><br>
	<center></center>
	</td>
</tr>
</table>