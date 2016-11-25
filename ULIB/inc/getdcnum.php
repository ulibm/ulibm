<?php  //พ
function getdcnum($a,$len=1) {
	//ereg ("([0-9]{3})", $a, $regs);	
	//echo "--$regs[1]--";
	//printr($regs);
	$inf=trim(dspmarc(substr($a,2)));
	$inf=substr($inf,0,$len);
	//echo "[$inf/$a]";
	//die;
	return trim($inf);
	
}
?>