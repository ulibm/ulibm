<?php 
;
     include("../inc/config.inc.php"); 
	 head();

	 //include("_REQPERM.php");
	 $_REQPERM="dbfulltext-dspcon";
	 mn_lib();
	 
	 $tbname="dbfulltext_subext";


$c[2][text]="Parent::l::Parent";
$c[2][field]="parent";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$pid;

$c[3][text]="นามสกุลของไฟล์::l::File's Extension";
$c[3][field]="ext";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

//dsp


$dsp[2][text]="Parent::l::Parent";
$dsp[2][field]="parent";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_dsp";

$dsp[3][text]="นามสกุลของไฟล์::l::File's Extension";
$dsp[3][field]="ext";
$dsp[3][width]="30%";

function local_dsp($wh) {
				 $s="";
				 global $pid;
				 $c=tmq("select * from dbfulltext_cate where code='$pid'");
				 $c=tmq_fetch_array($c);
				 $c=getlang($c[name]);
				 return $c;
}

$o[addlink][]="dspcon.php::Back";

fixform_tablelister($tbname," parent='$pid' ",$dsp,"yes","yes","yes","pid=$pid",$c,"",$o);

foot();

?>