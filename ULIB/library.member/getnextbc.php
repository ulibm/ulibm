<?php 
    include("../inc/config.inc.php"); 
html_start();

	$c=tmq("select * from member where 1 order by floor(UserAdminID) desc limit 1 ");
	$c=tmq_fetch_array($c);
	//printr($c);
	//$newcb=floor($c[bcode])+$num;
	$num=1;
	$newcb=($c[UserAdminID])+$num;
	$len=getval("config","def_membc_len");
	if ($len<strlen($c[bcode])) {
		$len=strlen($c[bcode]);
	}
	$newcb=str_fixw($newcb,$len);
	echo "<B style='color:darkgreen; font-size: 10px;' class=smaller>";
	echo getlang("ได้หมายเลขบาร์โค้ด [$newcb]::l::Got new barcode [$newcb]");
	echo "</B>";

?><SCRIPT LANGUAGE="JavaScript">
<!--
	parent.getobj("UserAdminID").value="<?php  echo $newcb; ?>";
	parent.getobj("UserAdminID").select();
	self.location="bccheck.php?bc=<?php  echo $newcb; ?>";
//-->
</SCRIPT>
<?php 

?>