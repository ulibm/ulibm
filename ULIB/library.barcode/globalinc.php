<?php 
if ($barcode_manage!="") {
	if ($bccmd!="") {
		if ($bccmd=="nodup") {
			$bc_source=barcodeval_get($barcode_manage);
			$bc_sourcea=explodenewline($bc_source);
			$bc_sourcea=array_unique($bc_sourcea);
			$bc_sourcea=implode($bc_sourcea,$newline);
			barcodeval_set($barcode_manage,$bc_sourcea);
		}
		if ($bccmd=="dup2") {
			$bc_source=barcodeval_get($barcode_manage);
			$bc_sourcea=explodenewline($bc_source);
			$bc_sourcea=array_unique($bc_sourcea);
			$bc_sourcea=array_merge($bc_sourcea,$bc_sourcea);
			$bc_sourcea=arr_filter_remnull($bc_sourcea);
			sort($bc_sourcea);
			$bc_sourcea=implode($bc_sourcea,$newline);
			barcodeval_set($barcode_manage,$bc_sourcea);
		}
		if ($bccmd=="dup3") {
			$bc_source=barcodeval_get($barcode_manage);
			$bc_sourcea=explodenewline($bc_source);
			$bc_sourcea_uniq=array_unique($bc_sourcea);
			$bc_sourcea=array_merge($bc_sourcea_uniq,$bc_sourcea_uniq);
			$bc_sourcea=array_merge($bc_sourcea,$bc_sourcea_uniq);
			$bc_sourcea=arr_filter_remnull($bc_sourcea);
			sort($bc_sourcea);
			$bc_sourcea=implode($bc_sourcea,$newline);
			barcodeval_set($barcode_manage,$bc_sourcea);
		}
	}
	$bc_source=barcodeval_get($barcode_manage);
	$bc_sourcea=explodenewline($bc_source);
	$bc_sourcea_uniq=array_unique($bc_sourcea);
	if ($bc_sourcea!=$bc_sourcea_uniq) {
		?><A HREF="<?php  echo $PHP_SELF?>?barcode_manage=<?php  echo $barcode_manage;?>&bccmd=nodup" class=a_btn style="font-size: 13"><?php echo getlang("ไม่ซ้ำ::l::No Duplicate");?></A>
<?php 
	}
	$chk
?>
<A HREF="<?php  echo $PHP_SELF?>?barcode_manage=<?php  echo $barcode_manage;?>&bccmd=dup2" class=a_btn style="font-size: 13"><?php echo getlang("ซ้ำ 2::l::Duplicate 2");?></A>
<A HREF="<?php  echo $PHP_SELF?>?barcode_manage=<?php  echo $barcode_manage;?>&bccmd=dup3" class=a_btn style="font-size: 13"><?php echo getlang("ซ้ำ 3::l::Duplicate 3");?></A>

<BR>
<?php 
}	
?>