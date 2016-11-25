<?php 
set_time_limit (600);

@include ("../../inc/config.inc.php");
//html_start();// พ
function local_url($wh) {
	global $dcrURL;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "$wh");
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_REFERER, $dcrURL); 
	
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: text/html')); 
      curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	$response = curl_exec($curl);
	$status = curl_getinfo($curl);
	curl_close($curl);
	$res=Array();
	$res[response]=$response;
	$res[status]=$status;
	return $res;
}
include("conf.php");
///
//tmq("delete from automatedsv_log");

echo "<pre>";
$datj=date("w");
$datW=date("W");
$daty=date("Y");
$s=tmq("select * from automatedsv ");
while ($r=tfa($s)) {
	echo "running for $r[refcode] - ".$thaidaystr[$datj]."$newline";
	$dat=$r[jobconf];
	$dat=unserialize($dat);
	//printr($dat);
	@reset($dat);
	while (list($k,$v)=@each($dat)) {
		$now=time();
		if (strtolower($v[$datj])=="yes") {
			//$s=tfa($s);
			$inf="$r[refcode]-$daty-$datW-$datj-$k";
			$chk=tmq("select * from automatedsv_log where inf='$inf' and result='200' ",false);
			if (tnr($chk)!=0) {
				$chk=tfa($chk);
				echo "   Executinged: $chk[inf] $newline";
			} else {
				$url=$r[refurl]."library.automated/cli/run.php?cmd=".$k;
				echo "   Executing: $inf$newline";// [$url]$newline";
				$res=local_url($url);
				//echo $res[response];
				//printr($res);
				//if ($res[status][http_code]=="200") { //success
					tmq("insert into automatedsv_log set refcode='$r[refcode]', job='$k', inf='$inf' , result='".$res[status][http_code]."' ,dt='$now',result_full='".addslashes($res[response])."' ");
					//tmq("insert into automatedsv_log set inf='$inf' , result='".$res[status][http_code]."' ,dt='$now',result_full='".addslashes($res[response])."' ");

				//}
			}
		}
	}
}
?>