<?php //พ
include("inc/config.inc.php");
$x=explode($q," ");
$all="";
foreach ($x as $v) {
	$all.="<B>$v</B> ";
	$v=trim($v);
	$tmpw=usoundex_get($v);
	$tmpl=strlen($tmpw);
	$v=tmq("select * from indexword where usoundex like '%$tmpw%' and LENGTH(usoundex) >".floor($tmpl-3)." and LENGTH(usoundex) <".floor($tmpl+3)." limit 10");
	while ($r=tmq_fetch_array($v)) {
		$all.=" $r[word]$r[usoundex] ,";
	}
	$all=trim($all,",");
	$all.="<BR>";
}
echo $all;
?>