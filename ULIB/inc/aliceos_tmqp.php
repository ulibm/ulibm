<?php 
function aliceos_tmqp($sql,$startrow,$url,$dbname="") {
	////func("aliceos_tmqp($sql,$startrow,$url)");// พ

	return tmqp($sql,$startrow,$url,"true",0,0,$dbname);
}
?>