<?php 
header('Content-type: application/x-javascript');
include("../../../inc/config.inc.php");// พ
?>

collection = [
<?php 
$s=tmq("select * from indexword where length(word1)< 20 order by rand() limit 2000");
while ($r=tfa($s)) {
	echo "'".addslashes($r[word1])."',
";
}
?>
'data'
];
