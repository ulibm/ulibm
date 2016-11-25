<?php 
	; 
		
        include ("../../inc/config.inc.php");
        include ("ip_in_range.php");
		if (strtolower(barcodeval_get("ulibapi_encoderesult"))=="th") {
			header('Content-Type: text/html; charset=tis620');
		}
		if (strtolower(barcodeval_get("ulibapi_encoderesult"))=="utf") {
			header('Content-Type: text/html; charset=utf-8');
		}

function local_loopenc($a) {
  global $forceencode;
  if ($forceencode=="") {
   if (!is_array($a)) {
   	if (strtolower(barcodeval_get("ulibapi_encoderesult"))=="th") {
   		return iconvth($a);;
   	}
   	if (strtolower(barcodeval_get("ulibapi_encoderesult"))=="utf") {
   		return iconvutf($a);;
   	}
   }
  } else {
   if (!is_array($a)) {
   	if (strtolower($forceencode)=="th") {
   		return iconvth($a);;
   	}
   	if (strtolower($forceencode)=="utf") {
   		return iconvutf($a);;
   	}
   }
  }
  @reset($v);
$vtmp=Array();
  while (list($k,$v)=each($a)) {
	  if ($k=="title") {
		//echo "<HR>$k=$v;";
	  }
    $vtmp[$k] =local_loopenc($v);
  }
  return $vtmp;
}
		//int// พ 
		$er_sec="security error";
		$er_dat="data error";
		$er_sys="system error";
		$res=Array();
		$res[error]=0;
		$res[error_description]="";
      $useradminid="api";

function bresp($k,$v) {
	global $res;
	$res=local_loopenc($res);
	if ($k=="error") {
		respflush();
	}
	if (is_array($v)) {
		$res[$k]=Array();
	}
	$res[$k]=$v;
}

function resp() {
	global $res;
	global $output;
	if ($output=="serialize") {
		echo serialize($res);
	} elseif ($output=="json") {
		echo json_encode($res);
	} elseif ($output=="printr") {
		printr($res);
	} elseif ($output=="print_r") {
		print_r($res);
	} else {
		echo serialize($res);
		echo "<HR>"; printr($res);
	}

	//echo "<HR>"; printr($res);
	die;

}
function respflush() {
	global $res;
	unset($res);
	$res=Array();
	//die;
}
  if ($LIBSITE=="") {
		$LIBSITE="main";
  }
  $_coengine="api";
	$ulibapi_enable=trim(barcodeval_get("ulibapi_enable"));
	if (strtolower($ulibapi_enable)!="yes") {
		bresp("error","1");
		bresp("error_name",$er_sec);
		bresp("error_description","API disabled by administrator");
		resp();
	}
	
			
	$pass=false;
	$iprange=trim(barcodeval_get("ulibapi_iprange"));
	$iprangea=explodenewline($iprange);
	@reset($iprangea);
	while (list($k,$v)=each($iprangea)) {
		if (ip_in_range($IPADDR,$v)==true) {
			$pass=true;
			break;
		}
	}

if ($pass==false) {
	bresp("error","1");
	bresp("error_name",$er_sec);
	bresp("error_description","client's IP not in range : $iprange / your IP=[$IPADDR]");
	resp();
}

//var
$command=str_remspecialsign($command);
$command=trim($command);
$command=strtolower($command);
if (strtolower(trim(getval("_SETTING","memberbarcodehasspecialsign")))!="yes") {
   $PatronID=trim(str_remspecialsign($PatronID));
}
if ($command=="checkpatron") {
	include("cmd.checkpatron.php");
}
if ($command=="checkout") {
	include("cmd.checkout.php");
}
if ($command=="checkin") {
	include("cmd.checkin.php");
}
if ($command=="checkstatus") {
	include("cmd.checkstatus.php");
}
if ($command=="fine_pay") {
	include("cmd.fine_pay.php");
}
if ($command=="finestatus") {
	include("cmd.fine_status.php");
}
if ($command=="creditadd") {
	include("cmd.credit_add.php");
}
if ($command=="creditwithdrawn") {
	include("cmd.credit_withdrawn.php");
}
if ($command=="finepay") {
	include("cmd.fine_pay.php");
}
if ($command=="search") {
	include("cmd.search.php");
}
if ($command=="getbib") {
	include("cmd.getbib.php");
}


bresp("error","1");
bresp("error_name",$er_dat);
bresp("error_description","Unrecognized command [$command] ");
resp();

?>