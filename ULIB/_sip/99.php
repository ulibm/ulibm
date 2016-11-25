<?php 
	local_sput("98YYYYYY999999".$siptime."2.00".
	"AO".barcodeval_get("sipsetting-institutionID")."|AM".barcodeval_get("sipsetting-LibraryName")."|BXYYYNYYYNNNYNNNN|"
	,true,true);
	local_log("Login OK:$LOGIN@".$dat["CP"]);
// พ 
?>