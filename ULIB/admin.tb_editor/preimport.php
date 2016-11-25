<?php  //พ
include("../inc/config.inc.php");
	head();
	mn_root("tb_editor");
if ( $tblister!="") {
	?><TABLE width=600 class=table_border align=center>
	<TR>
		<TD><PRE>&lt;?
include("../inc/config.inc.php");
head();
mn_root("yyy");

$tbname="<?php  echo $tblister?>";
<?php 
$result = tmq("SHOW COLUMNS FROM $tblister");
if (!$result) {
   echo 'Could not run query l18: ' . tmq_error();
   exit;
}

$c=0;
   while ($r = tfa($result)) {
	   $c++;
	   if ($r[Field]=="id" || $r[Field]=="ordr" ) {
		continue;
	   }
	   //printr($r);
	   $fieldtype='text';
	   if ($row[Type]=="longtext" ) {
		   $fieldtype='longtext';
	   }
	   if ($row[Type]=="double" ) {
		   $fieldtype='number';
	   }
       //print_r($row);
	   $ordr=1000;
	   if ($r[Field]=='classid') {
			$ordr=50;
	   }
	   if ($r[Field]=='name') {
			$ordr=100;
	   }
	   if ($r[Field]=='type') {
			$ordr=150;
	   }
?>


$c[<?php  echo $c;?>][text]="<?php  echo ucfirst($r[Field]);?>::l::<?php  echo ucfirst($r[Field]);?>";
$c[<?php  echo $c;?>][field]="<?php  echo $r[Field];?>";
$c[<?php  echo $c;?>][fieldtype]="<?php  echo $fieldtype;?>";
$c[<?php  echo $c;?>][descr]="";
$c[<?php  echo $c;?>][defval]="<?php  echo $r["Default"];?>";<?php 
   }
   
   ?>


//dsp
<?php 
$result = tmq("SHOW COLUMNS FROM $tblister");
if (!$result) {
   echo 'Could not run query: ' . tmq_error();
   exit;
}

$c=0;
   while ($r = tfa($result)) {
	   $c++;
	   if ($r[Field]=="id" || $r[Field]=="ordr" ) {
		continue;
	   }
	   //printr($r);
	   $fieldtype='text';
	   if ($row[Type]=="longtext" ) {
		   $fieldtype='longtext';
	   }
	   if ($row[Type]=="double" ) {
		   $fieldtype='number';
	   }
       //print_r($row);
	   $ordr=1000;
	   if ($r[Field]=='classid') {
			$ordr=50;
	   }
	   if ($r[Field]=='name') {
			$ordr=100;
	   }
	   if ($r[Field]=='type') {
			$ordr=150;
	   }
?>


$dsp[<?php  echo $c;?>][text]="<?php  echo ucfirst($r[Field]);?>::l::<?php  echo ucfirst($r[Field]);?>";
$dsp[<?php  echo $c;?>][field]="<?php  echo $r[Field];?>";
$dsp[<?php  echo $c;?>][width]="30%";<?php 
   }
   
   ?>



fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?&gt;</PRE></TD>
	</TR>
	</TABLE><?php 
}

?>
<center><a href=list.php>Back to list</a><BR></center>

<TABLE width=780 align=center>
<TR>
	<TD><?php 
$result = tmq_list_tables($dbname);
while (list($k,$row)=each($result)) { //printr($row);
    echo "Table:<A HREF=\"import.php?editorid=$row\" onclick=\"return confirm('sure?');\"> $row</A>";
	echo " -- <A HREF=\"import.php?editorid=$row&dsp=yes\">display only</A>";
	echo " -- <A HREF=\"preimport.php?tblister=$row\">display as tblister</A><BR>";
}
?>

</TD>
</TR>
</TABLE><?php 

foot();
?>