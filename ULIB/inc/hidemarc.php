<?php // พ

function hidemarc($a,$b = "",$l="") {
	global $dcrURL;
$a=trim($a);
$a=trim($a,"\n");
$a=trim($a);
$pos = strpos($a, '^');
if ($pos === false) {
	return $a;
}
$pos = strpos($a, '^a');
if ($pos === false) {
	$a="^a".$a;
}
//echo "[[ $a,$b,$c ]]";
//if ($b!="") {
  $b = trim($b,",");
  $b = explode(",",$b);
  $res="";
    $s=explode("^",$a);
      foreach ($s as $j) {
        if ($s!="") {
          if (!in_array(substr($j,0,1),$b)) {
             $res="$res" . "^" . $j;
          }
        }
      }
//$res=trim($res,"^");
  //echo "[[$c / $res]]";

  $l = trim($l,",");
  if ($l!="") {
    $s=explode("^",$res);
    $res="";
      foreach ($s as $j) {
        if ($s!="") {
			$linkquery=substr($j,1);
			$linkquery=trim($linkquery,".");
			$linkquery=trim($linkquery,":");
			$linkquery=trim($linkquery);
			if ($linkquery!="") {
				$res="$res" . "<a href='$l" . $linkquery ."'>^" . $j . "</a>";
				$res=str_replace("[dcr]","$dcrURL",$res);
			}
        }
      }
  }


$res=str_replace("^^","^",$res);
//echo "--res=$res--";
  return $res;
}

?>