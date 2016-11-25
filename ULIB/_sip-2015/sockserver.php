<?php  //พ
@error_reporting( E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);

include("ini.php");
include("inc.php");
$pinc= $_SERVER["SCRIPT_FILENAME"];
if ($pinc=="") {
	die("ERROR:\$SCRIPT_FILENAME not defined");
}
$pinc=substr($pinc,0,strrpos($pinc,'/'));
$pinc=substr($pinc,0,strrpos($pinc,'/'));
//echo $pinc;
include ("$pinc/inc/config.inc.php");
//error_reporting(E_ALL);



if ($SETPORT=="") {
	echo "Please call sockserver.php through _serverport-PORT.php";
	die;
} else {
	echo "ULibM SIP: Socket Server for port $SETPORT initializing\n";
	echo "========================================================\n";
}
local_log( "READY!");

///////////////////////////////////////////////////ready, initial variable
set_time_limit(0);/* Allow the script to hang around waiting for connections. */
ob_implicit_flush();/* Turn on implicit output flushing so we see what we're getting * as it comes in. */

$address = barcodeval_get("sipsetting-hostIP");
$LOGIN = trim(barcodeval_get("sipsetting-logininid"));
$PASSWORD = trim(barcodeval_get("sipsetting-passwordid"));

$port = $SETPORT;
$seq=0;
$limiter=chr(barcodeval_get("sipsetting-limiter"));
$CR="\r\n";//chr(13);
$siptime=date('Ymd    His');
$last_response="";

///////////////////////////start socket
$client_id = 0;
if (strtolower(barcodeval_get("sipsetting-skippwd"))=="yes") {
$clientlogedin=true;
} else {
$clientlogedin=false;
}
$LIBSITE="";
$PATRON="";//current patron
$sipuserid="SIP-server-$SETPORT";
local_sockstart();

do {
    if (($msgsock = socket_accept($sock)) === false) {
        local_log( "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n");
        break;
    } else {
		$client_id += 1;
		local_log( "socket_accept() : Client #" .$client_id .": Connected.\n");
		echo( "Client #" .$client_id .": Connected.\n");
		///////////////////////////////////////////client login
		while ($clientlogedin==false && strtolower(barcodeval_get("sipsetting-skippwd"))!="yes") {
			echo " -- Not Login --\n";
			$dat=local_get();
			$dat=local_melt($dat);
			print_r($dat);		
			if ($dat["mode"]=="93") {
				include("$dcrs"."_sip/93.php");
			}
		} //while ($clientlogedin==false) 
		///////////////////////////////////// end client login
		while ($clientlogedin==true || strtolower(barcodeval_get("sipsetting-skippwd"))=="yes") {
			$SIPSENTthisround=false;
			$forcebke=false;
			$dat=local_get();
			if ($forcebke==true) {
			  echo " -- brke mstr loop --\n starting new\n";
                          local_sockstart();
			  break;
			}

			$dat=local_melt($dat);
			print_r($dat);		
			print_r($_SESSION);		
			if ($modname["$dat[mode]"]!="") {
				echo "Doing:".$modname["$dat[mode]"]."\n";
				local_log( "Doing:".$modname["$dat[mode]"]);
				include("$dcrs"."_sip/".$dat["mode"].".php");
				echo "Current Patron:$PATRON\n";
			}

		}




    }
      
    /* Send instructions. */

} while (true);

socket_close($msgsock);
socket_close($sock);
?>
