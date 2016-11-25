<?php // พ 
function local_log($str,$file="") {
	global $SETPORT;
	global $dcrs;
	if ($file=="") {
		$file=$dcrs."_sip/log-$SETPORT.txt";
	}
	$fp = fopen($file, 'a+');
	fwrite($fp,"\n".date("Y m d H:i:s").iconvth(" : $str"));
	fclose($fp);
}
function local_sput($str,$rule=true,$addcr=true) {
	global $last_response;
	global $SIPSENTthisround;
	$last_response=$str;
	global $msgsock;
	global $limiter;
	global $CR;
	if ($rule==true) {
		$str.="AY".local_seq();
		$str.="AZ";
		$str.=local_crc($str);
	}
	if ($addcr==true) {
		$str.=$CR;
	}
	socket_write($msgsock,$str, strlen($str));
	local_log("SEND>:$str:<END-SEND","");
	$SIPSENTthisround=true;
}
function local_seq() {
	global $seq;
	$seq++;
	if ($seq > 9 ) {
		$seq = 0;
	}
	return $seq;
}
function local_crc($buf) {
	$sum=0;

	$len = strlen($buf);
	for ($n = 0; $n < $len; $n++) {
		$sum = $sum + ord(substr($buf,$n,1));
	} 

	$crc = -($sum & 0xFFFF);

	return substr(sprintf ("%4X", $crc),4);
}
function local_melt($raw) {
	global $fixlen;
		$result = array();
		$result['Raw'] = explode("|", substr($raw,$start,-7));
		$result["mode"]=substr($raw,0,2);
		$firstk=substr($raw,$fixlen[$result["mode"]],2);
		if ($firstk!="") {
			$tmp=explode("|",$raw);
			$tmp=$tmp[0];
			$result[$firstk]=substr($tmp,$fixlen[$result["mode"]]+2);
		}
		foreach ($result['Raw'] as $item) {
			$field = substr($item,0,2);
			$value = substr($item,2);
			$clean = trim($value, "\x00..\x1F");
			if (trim($clean) <> '') {
				$result[$field] = $clean;
			}
		}		
		$result['AZ'] = substr($raw,-5);
		return $result;
}
function local_get () {
global $forcebke;
		global $msgsock;
		global $clientlogedin;
		global $sock;

		/* sends the current message, and gets the response */
		/*Need to add in error checking (CRC) and retransmission ability */
		$result ="";
		$terminator = "";
		local_log( "local_get() Reading response");
		$forceoff=false;
		$edetect=false;

		while ($terminator != "\x0D" && $forceoff!=true) {
			if (false !== ($nr = socket_recv($msgsock,$terminator,1,0)) ) {;
                           if ( strlen($terminator) < 1 ) {
				$edetect=true;
				echo "edetect = emptyresult\n";
			   }
				$result = $result . $terminator;
			} else {
				local_log( "socket_recv() failed; reason: " . socket_strerror(socket_last_error($msgsock)) );
				//echo "socket_recv() failed; reason: " . socket_strerror(socket_last_error($socket)) . "\n";
				$forceoff=true;
				///client may be disconnected+ set disconnect
				$clientlogedin=false;
				echo "Client Disconnected\n";
				$edetect=true;
				echo "edetect = sockfail\n";
			}

                        if ( $edetect==true) {
				$edetect=false;
				echo "edetect -- shuttingdown socket \n";
                                $clientlogedin=false;
                                socket_shutdown($sock);
                                socket_shutdown($msgsock);
                                sleep(2);
                                socket_close($sock);
                                socket_close($msgsock);
                                sleep(2);
                                //break;
                                sleep(2);
				$forcebke=true;
				return "";
                        }

			if ($forceoff==true) {
				//echo ".";
			} else {
				//echo "-";
			}
		}
		local_log("GOT: {$result}");

		/* test message for CRC validity */
		if (local_check_crc($result)) {
			/* reset the retry counter on success send */
			local_log("SIP2: Message from SC passed CRC check");
		} else {
			local_log("SIP2: Failed to get valid CRC.");
			local_sput("96",false,true);//request SC resend
			return false;
		}
		$result=trim($result);
		return $result;
	}
	function local_check_crc($message) {
		/* test the recieved message's CRC by generating our own CRC from the message */
		$test = preg_split('/(.{4})$/',trim($message),2,PREG_SPLIT_DELIM_CAPTURE);

		if (local_crc($test[0]) == $test[1]) {
			return true;
		} else {
			return false;
		}
	}
function local_sockstart() {
echo "SOCKSTART();\n";
global $forcebke;
	global $sock;
	global $address;
	global $port;
	global $client_id;
/*
@socket_shutdown($sock, 2);
@sleep(2);
@socket_close($sock);
@sleep(2);
*/
@socket_close ( $sock );
	if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
	//if (($sock = socket_create(AF_UNIX, SOCK_STREAM, SOL_TCP)) === false) {

		local_log( "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
		die;
	}

	if (socket_bind($sock, $address, $port) === false) {
		local_log( "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n");
	} else 
	  local_log( 'Socket ' . $address . ':' . $port . " has been opened\n");

	if (socket_listen($sock, 5) === false) {
		local_log( "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n");
	} else {
		$client_id = 0;
	}
}
function local_formattitle($title) {
	$title=str_remspecialsign($title);
	$title=trim($title);
	if (strlen($title)>70) {
		$title=substr($title,0,68)."..";
	}
	$title=iconvutf($title);
	//echo "marc_gettitle [$title]";
	return $title;
}
?>