<?php 
include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

?><BR>
<TABLE width=780 align=center class=table_border>
<TR>
	<TD class=table_head width=200><?php  echo getlang("จุดให้บริการของ::l::Service for ");?></TD>
	<TD class=table_td><?php  
	$s=tmq("select * from servicespot_room where id='$PARENT' ");
	$s=tmq_fetch_array($s);
	echo getlang($s[name]);?></TD>
</TR>
</TABLE>
<?php 
$tbname="servicespot_client";


$c[2][text]="Pid::l::Pid";
$c[2][field]="pid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$PARENT;

$c[3][text]="Name::l::Name";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";



//dsp

$dsp[3][text]="Name::l::Name";
$dsp[3][field]="name";
$dsp[3][width]="30%";


fixform_tablelister($tbname," pid='$PARENT' ",$dsp,"yes","yes","yes","PARENT=$PARENT",$c);

foot();
?>