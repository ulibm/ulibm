<?php // พ 
$LOGIN = trim(barcodeval_get("sipsetting-logininid"));
$PASSWORD = trim(barcodeval_get("sipsetting-passwordid"));
printr($dat);
if ($dat["CN"]=="$LOGIN" && $dat["CO"]="$PASSWORD") {
	$LIBSITE=$dat["CP"];
	$clientlogedin=true;
	local_sput("941",true,true);
	echo "Login OK:$LOGIN@".$dat["CP"]."\n";
	local_log("Login OK:$LOGIN@".$dat["CP"]);
} else {
	local_sput("940",true,true);
	echo "Login Failed:$LOGIN@".$dat["CP"]."\n";
	echo "    entered:".$dat["CN"]."/".$dat["CO"]."\n";
	echo "    needed: $LOGIN/$PASSWORD\n";
	local_log("Login Failed:$LOGIN@".$dat["CP"]);
}
?>