<?php 
function str_censor($str) {
   //called from str_webpagereplacer();
	global $str_censordb;
	global $dcrURL;
	if (count($str_censordb)==0) {
		$str_censordb=tmq_dump2("bannedwords","id","word1,word2","order by priority1");
		//printr($str_censordb);
	}
	$str = ''.$str.'';
	@reset($str_censordb);
	$censor_p1="<!--";
	//$censor_p2="--><img src='$dcrURL"."neoimg/censored.gif' border=0 align=absmiddle>";
	$censor_p2="-->###";
	while (list($k,$v)=@each($str_censordb)) {
		$replacement=$str_censordb[$k][1];
		if ($replacement == '') {
			$replacement=$censor_p1.base64_encode($str_censordb[$k][0]).$censor_p2;
			//$replacement=str_repeat('#', strlen($str_censordb[$k][0]));
		}
		if (str_replace('[','',$str_censordb[$k][0])!=$str_censordb[$k][0]) { // ถ้ามี [
			$searchfora=explode('[',$str_censordb[$k][0]);
			$searchfor=$searchfora[0];
			$searchfora=explode(']',$searchfora[1]);
			$searchfor.=$censor_p1.base64_encode($searchfora[0]).$censor_p2;
			$searchfor.=$searchfora[1];
			/*
			$searchfor=substr($str_censordb[$k][0],0,strpos($str_censordb[$k][0],'['));
			$searchfor.=$censor_p1.base64_encode(substr($str_censordb[$k][0],strpos($str_censordb[$k][0],'[')+1,strstr($str_censordb[$k][0],']')-1)).$censor_p2;
			$searchfor.=substr($str_censordb[$k][0],strpos($str_censordb[$k][0],']')+1,strlen($str_censordb[$k][0]));
			//echo "[[[$searchfor-$replacement]]] ";
			echo "[*".$str_censordb[$k][0]."=<U>".
				substr($str_censordb[$k][0],strpos($str_censordb[$k][0],'[')+1,strstr($str_censordb[$k][0],']')-1).
			"</U>*]<I>";
			echo substr($str_censordb[$k][0],7,8);
			echo "</I>-";
			echo strpos($str_censordb[$k][0],']');
			*/
		} else {
			$searchfor=$str_censordb[$k][0];
		}
		//$searchfor=;
		//echo preg_quote($str_censordb[$k][0])."[$replacement]";
		//$str = preg_replace("/\b(".str_replace('\*', '\w*?', preg_quote($str_censordb[$k][0])).")\b/i", $replacement, $str);
		$str = str_replace($searchfor, $replacement, $str);
	}
	return ($str);
}
?>