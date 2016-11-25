<?php 
// พ 
$oo = shell_exec('ps -C php -n +pid');
$oo=explode("\n",$oo);
//print_r($oo);
@reset($oo);
$mypid=getmypid();
echo " my pid is $mypid
";

while (list($k,$v)=each($oo)) {
$pid=explode(" ",$v);
if (floor($pid[0])!=0 && $pid[0]!=$mypid) {
$kcmd="kill $pid[0]";
echo $kcmd."\n";
echo shell_exec($kcmd);;
} else {
echo "SKIP $pid[0]\n";
}
}
?>