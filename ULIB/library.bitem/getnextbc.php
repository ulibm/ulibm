<?php 
include("../inc/config.inc.php"); 
html_start();

$isrefresh=sessionval_get($parentid);
if ($isrefresh!="") {
	?><!-- is refresh -->
<SCRIPT LANGUAGE="JavaScript">
<!--
	//self.location="bccheck.php?bc=<?php  echo $isrefresh; ?>";
//-->
</SCRIPT>
<?php 
	die;
}

$num=sessionval_get("getnextbc_bitem");
$num=floor($num)+1;
	$c=tmq("select * from media_mid where 1 order by floor(bcode) desc limit 1 ");
	$c=tmq_fetch_array($c);
	//printr($c);
	//$newbc=floor($c[bcode])+$num;
	//echo "($c[bcode])+$num;";
	$newbc=floatval("$c[bcode]");
	//echo "$newbc=floatval($c[bcode]);	";
	$newbc=$newbc+floatval($num);
	echo "	$newbc=$newbc+$num;	";
	$len=getval("config","def_bc_len");
	if ($len<strlen($c[bcode])) {
		$len=strlen($c[bcode]);
	}
	$newbc=str_fixw($newbc,$len);
	echo "<B style='color:darkgreen; font-size: 10px;' class=smaller>";
	echo getlang("ได้หมายเลขบาร์โค้ด [$newbc]::l::Got new barcode [$newbc]");
	echo "</B>";
//var_dump($c[bcode]);
//var_dump((double) $c[bcode]);
//var_dump($num);
?><SCRIPT LANGUAGE="JavaScript">
<!--
	//alert('got <?php  echo number_format($c[bcode]);?>+<?php  echo $num?>=<?php  echo (round($c[bcode])+$num)?> with len <?php  echo $len?>');
	parent.getobj("<?php echo $parentid ?>").value="<?php  echo $newbc; ?>";
	parent.getobj("<?php echo $parentid ?>").focus();
	self.location="bccheck.php?bc=<?php  echo $newbc; ?>";
//-->
</SCRIPT>
<?php 
sessionval_set("getnextbc_bitem",$num);
sessionval_set($parentid, $newbc);
?>