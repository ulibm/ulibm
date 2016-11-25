<?php  //พ
$circulation_status=Array();
$circulation_status["other"]="01";
$circulation_status["lost"]="12";
$circulation_status["lostandpaid"]="12";
$circulation_status["onprocess"]="06";

$fixlen=Array();
$fixlen[93]=4;
$fixlen[63]=33;
$fixlen[17]=20;
$fixlen[11]=40;

$modname=Array();
$modname[93]="Login";
$modname[99]="SC status";
$modname[97]="Request ACS Resend";
$modname[63]="Patron status";
$modname[17]="Item Information";
$modname[35]="End patron session";
$modname["09"]="Checkin";
$modname["11"]="Checkout";

?>