<?php 
	; 
				$ui_passwd=@stripslashes($ui_passwd);

        include ("../inc/config.inc.php");
		head();
        mn_root("upgrade_variable");
			pagesection("Upgrade Variable to Current");
if ($ui_collation!="") {
	barcodeval_set("root_upgradevariable_coll",$ui_collation);
}

if ($ui_dbname==$dbname) {
	die("could not use same dbname $ui_dbname;");
}
//echo $ui_dbname;
$link=tmq_connect($ui_host, $ui_user, $ui_passwd,true);
if (!$link) {
    echo 'Could not connect to mysql';
    exit;
}
if (!$link=tmq_select_db($ui_dbname,$link)) {
    echo 'Could not use db $ui_dbname';
    exit;
}
if ($ui_dbname==$dbname) {
	die("<font  color=red>could not use same dbname $ui_dbname;</font>");
}
$sql = "SHOW TABLES FROM $ui_dbname";
$result = tmq($sql,false,$link);


if (!$result) {
    echo "DB Error, could not access dbs\n";
    echo 'MySQL Error: ' . tmq_error();
    exit;
} 

?><BR>
<TABLE align=center width=650 class=table_border>
<FORM METHOD=POST ACTION="step2.php">
<TR class=table_head>
	<TD colspan=5><?php  echo getlang("กรุณากดยืนยัน::l::Please Confirm operation.");?></TD>
</TR>
<INPUT TYPE="hidden" name="ui_host" value="<?php echo $ui_host?>">
<INPUT TYPE="hidden" name="ui_user" value="<?php echo $ui_user?>">
<INPUT TYPE="hidden" name="ui_passwd" value="<?php echo $ui_passwd?>">
<INPUT TYPE="hidden" name="ui_dbname" value="<?php echo $ui_dbname?>">
<INPUT TYPE="hidden" name="ui_collation" value="<?php echo $ui_collation?>">

<TR>
	<TD class=table_td colspan=5 align=center><INPUT TYPE="submit" value="     Start     "></TD>
</TR>
</FORM></TABLE>
<BR><BR><BR><BR><?php 


if (!$result) {
    
} else {
   echo "<center>";
   echo "connection ok<BR>";
   if ($ui_collation!="") {
      $tmq_autoconnect_collation=$ui_collation;
      $tmq_autoconnect_host=$ui_host;
      $tmq_autoconnect_user=$ui_user;
      $tmq_autoconnect_passwd=$ui_passwd;
  
      echo "set collation [$ui_collation]<BR>";
   	tmq("set names '$ui_collation';",false,$ui_dbname);
   	echo "test select<BR>result:";
   	$result = tmq("select * from val where main='SYSCONFIG' and sub='credits' ",false,$ui_dbname);
   	$resr=tfa($result);
   	echo stripslashes(strip_tags($resr[val]));
   	echo "<BR>";
   	$result = tmq("SELECT default_character_set_name FROM information_schema.SCHEMATA S WHERE schema_name = \"$ui_dbname\";",false,$ui_dbname);
   	
   	/*
   	SELECT default_character_set_name FROM information_schema.SCHEMATA S WHERE schema_name = "ulib";
   	
   	
   	ALTER DATABASE databasename CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE tablename CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
*/


   	$resr=tfa($result);
   	echo "<b>[".$resr[default_character_set_name]."]</b>";
   	//print_r($resr);
   	
   }

   
/**/
}


foot();
?>