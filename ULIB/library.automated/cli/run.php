<?php  //พ
set_time_limit (600);

switch ($_GET["cmd"]) {
    case "backup":
		///die;
        break;
    case "due_3dbefore":
        break;
    case "due_2dbefore":
        break;
    case "due_1dbefore":
        break;
    case "due":
        break;
    case "overdue":
        break;
    case "unpaidfine":
        break;
    case "memexpiredate":
        break;
    case "subscribedsearch":
        break;
    case "memexpiredate7days":
        break;
    case "memexpiredate30daysafter":
        break;
    case "memexpiredate30days":
        break;
    default:
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Wrong Command', true, 500);
		echo "Wrong Command [".$_GET["cmd"]."]";
		die;
}
	include ("../../inc/config.inc.php");
	/*
	// can't run in command line
	if (trim($_SERVER['HTTP_REFERER'],"/")!=trim(barcodeval_get("automated-url"),"/")) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Wrong Request', true, 500);
		die("wrong request - ref=".$_SERVER['HTTP_REFERER']);
	}*/
	$automatedtaskname="automated_task";
	$umail_mail_libid=$automatedtaskname;
switch ($_GET["cmd"]) {
    case "backup":
		include("inc.backup.php");
        break;
    case "due_3dbefore":
		$setid="automated".randid();
		$dayback=3;
		$dayback2=2;
		$revers="no";
		include("inc.emaildue.php");
        break;
    case "due_2dbefore":
		$setid="automated".randid();
		$dayback=2;
		$dayback2=1;
		$revers="no";
		include("inc.emaildue.php");
        break;
    case "due_1dbefore":
		$setid="automated".randid();
		$dayback=1;
		$dayback2=0;
		$revers="no";
		include("inc.emaildue.php");
        break;
    case "due":
		$setid="automated".randid();
		$dayback=0;
		$dayback2=1;
		$revers="yes";
		include("inc.emaildue.php");
        break;
    case "overdue":
		$setid="automated".randid();
		$dayback=1;
		$dayback2=200000;
		$revers="yes";
		include("inc.emaildue.php");
        break;
    case "unpaidfine":
		$setid="automated".randid();
		include("inc.emailfine.php");
        break;
    case "memexpiredate7days":
		$setid="automated".randid();
		include("inc.emailexpire.php");
		$dayback=7;
		$dayback2=0;
		$revers="no";
        break;
    case "memexpiredate30days":
		$setid="automated".randid();
		include("inc.emailexpire.php");
  		$dayback=31;
		$dayback2=7;
		$revers="no";
      break;
	 case "memexpiredate30daysafter":
		$setid="automated".randid();
		include("inc.emailexpire.php");
  		$dayback=30;
		$dayback2=0;
		$revers="yes";
      break;
   case "memexpiredate":
        break;
    case "subscribedsearch":
        break;
}
	//printr($_GET);
?>