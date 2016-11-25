<?php 

$statusdb["new"]="New";
$statusdb["waitpayment"]="Wait Payment";
$statusdb["waitpickup"]="Wait Pickup";
$statusdb["matnotfound"]="Mat.Not found";
$statusdb["processing"]="Processing";
$statusdb["cancelbylib"]="Cancel by librarian";
$statusdb["matsent"]="Material Sent";
$statusdb["done"]="Done";
// พ
$statusstep[]="new";;
$statusstep["new"]="processing";;
$statusstep[processing]="waitpayment";;
$statusstep[waitpayment]="waitpickup";;
$statusstep[waitpickup]="done";;
//$statusstep[matsent]="done";;

?>