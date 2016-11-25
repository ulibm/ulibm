<?php // พ
function ordr() {
	////func("ordr");
	global $a; 
	global $tbl; 
	global $condition; 
	global $conditionval; 
	global $field; 
	global $primary; 
	global $id; 
	global $direct;

$s="select * from $tbl where 1 ";
if ($condition!="") {
   $s = "$s and $condition='$conditionval'";
}
$s= "$s order by $field";
$r=tmq($s,false);

echo tmq_error();
//echo "<B>$s</b><br>";
$i=50;
while($r2=tmq_fetch_array($r)) {
	$i=$i+10;
	$s="update $tbl set $field = $i where $primary = '$r2[$primary]' ";
	//echo $s . " " . tmq_error() . ";<BR>";
	tmq($s);
}

if ($direct=="up") {
  $s="update $tbl set $field=$field-11 where $primary='$id' ";
} else {
  $s="update $tbl set $field=$field+11 where $primary='$id' ";
}
//echo "<BR>";
tmq($s);
redir($a,0);
}
?>