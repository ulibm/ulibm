<?php 
include("../inc/config.inc.php");
	head();
	mn_root("tb_editor");

if ($addthis!="") {
	$addthis=stripcslashes ($addthis);
	tmq($addthis,false);
	echo "$addthis<BR><HR>done";
	echo "<A HREF=\"list.php\"><B>back</B></A>";
	die;
}
	
	if ($dsp!='yes' && $addthis=="") {
		tmq("delete from tb_editor where editorid='$editorid'",false);
		tmq("delete from  tb_editor_field where editorid='$editorid'",false);
	}
$maintbname="$editorid";
$result = tmq("SHOW COLUMNS FROM $maintbname");
if (!$result) {
   echo 'Could not run query: ' . tmq_error();
   exit;
}
$s="insert into tb_editor set editorid='$maintbname' ,note='$maintbname' ,
	   is_allowadd='yes' , is_allowdel='yes' , tbname='$maintbname';";
if ($dsp=="") {
	   tmq( $s );
} else {
	echo $s ."<BR>";
}
//echo tmq_num_rows($result);
if (tmq_num_rows($result) > 0) {
   while ($row = tfa($result)) {
    //printr($row);
	   if ($row[Field]=="id" || $row[Field]=="ordr" ) {
		continue;
	   }
	   $fieldtype='text';
	   if ($row[Type]=="longtext" ) {
		   $fieldtype='longtext';
	   }
	   if ($row[Type]=="double" ) {
		   $fieldtype='number';
	   }
       //print_r($row);
	   echo "<BR>";
	   $ordr=1000;
	   if ($row[Field]=='classid') {
			$ordr=50;
	   }
	   if ($row[Field]=='name') {
			$ordr=100;
	   }
	   if ($row[Field]=='type') {
			$ordr=150;
	   }
	   $tmptp=tmq("select * from tb_editor_tp where table1='$maintbname' and field1='$row[Field]' ");
	   $tmptp=tmq_fetch_array($tmptp);
	   if ($tmptp[type]!='') {
			$fieldtype=$tmptp[type];
	   }
	   $s=trim("insert into tb_editor_field set editorid='$maintbname',
		sourcedatatype='$tmptp[sourcedatatype]',
		sourcedata1='$tmptp[sourcedata1]',
		source1field='$tmptp[source1field]',
		linkout_editorid='$tmptp[linkout_editorid]',
		linkout_field='$tmptp[linkout_field]',

	   field ='$row[Field]', text ='$row[Field]' , type ='$fieldtype' ,ordr='$ordr' ",",");
	   if ($dsp=="") {
		   tmq($s,false);
	   } else {
		echo $s." -- <A HREF=\"import.php?addthis=$s\">add this</A><BR>";
	   }
   }
}
?><CENTER>..done.<BR><BR>
<A HREF="list.php">back</A> - <A HREF="menu.php?e=<?php  echo $editorid?>"><?php  echo getlang("ทำงานกับตารางนี้::l::Work with this table");?></A></CENTER>

<?php 
foot();
?>