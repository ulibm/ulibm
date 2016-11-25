<?php 
	; 
		
        include ("../inc/config.inc.php");
		$ui_passwd=stripslashes($ui_passwd);
		head();
        mn_root("upgrade_table");
			pagesection("Upgrade Table");
if ($ui_collation!="") {
	barcodeval_set("root_upgradetable_coll",$ui_collation);
}

?><BR>
<TABLE align=center width=<?php  echo $_TBWIDTH?> class=table_border>
<FORM METHOD=POST ACTION="step2.php">
<TR class=table_head>
	<TD colspan=5><?php  echo getlang("กรุณาเลือกตาราง::l::Please choose table.");?></TD>
</TR>
<TR class=table_head>
	<TD ><?php  echo getlang("ชื่อตาราง::l::Table name.");?></TD>
	<TD ><?php  echo getlang("จำนวนคอลัมน์::l::Columns.");?></TD>
	<TD ><?php  echo getlang("จำนวนข้อมูล::l::Records.");?></TD>
	<TD ><?php  echo getlang("คอลัมน์ปัจจุบัน::l::Current.Col");?></TD>
	<TD ><?php  echo getlang("ข้อมูลปัจจุบัน::l::Current.Rec.");?></TD>
</TR>
<?php 
if ($ui_dbname==$dbname) {
	die("could not use same dbname $ui_dbname;");
}

$link=tmq_connect($ui_host, $ui_user, $ui_passwd,true);
//echo $conn;
//echo $link;
if (!$link) {
    echo 'Could not connect to mysql';
    exit;
}
if (!$link=tmq_select_db($ui_dbname,$link)) {
    echo 'Could not use db $ui_dbname';
    exit;
}

/////////////////tables form our db
        $tables=tmq("show tables");
        $num_tables=@tmq_num_rows($tables);
        //$i=0;
		//$tbdb=Array();
        //while ($i < $num_tables) {
			$tbdb=  tmq_list_tables($tables, $i);
		//	$i++;
		//}
/////////////////
//print_r($tbdb);

$sql = "SHOW TABLES FROM $ui_dbname";
$result = tmq($sql,false,$link);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . tmq_error();
    exit;
}

while ($row = tfa($result)) {
?>
<TR>
	<TD class=table_td><INPUT TYPE="radio" NAME="ui_table" value="<?php  echo $row[0]?>" style="border: 0px;"> <A name="<?php  echo $row[0]?>"><?php  echo $row[0]?></A></TD>
	<TD class=table_td align=right><?php 
	$sql="show columns from  $row[0]";
	$info = tmq($sql,false,$link);
	echo tmq_error();
	echo number_format(tmq_num_rows($info));
?></TD>
	<TD class=table_td align=right><?php 
	$sql="select count(*) from $row[0]";
	$info = tmq($sql,false,$link);
	echo tmq_error();
	$info=tmq_fetch_array($info);
	echo number_format($info[0]);
?></TD>
	<TD class=table_td align=right><?php 
if (in_array("$row[0]", $tbdb)) {
	$sql="show columns from  $row[0]";
	$info = tmq($sql);
	echo tmq_error();
	echo number_format(tmq_num_rows($info));
} else {
	echo " - ";
}
?></TD>
	<TD class=table_td align=right><?php 
if (in_array("$row[0]", $tbdb)) {
	$info = tmq("select count(*) from $row[0]");
	$info=tmq_fetch_array($info);
	echo number_format($info[0]);
} else {
	echo " - ";
}
?></TD>
</TR>
<?php 
}


?>
<INPUT TYPE="hidden" name="ui_host" value="<?php echo $ui_host?>">
<INPUT TYPE="hidden" name="ui_user" value="<?php echo $ui_user?>">
<INPUT TYPE="hidden" name="ui_passwd" value="<?php echo $ui_passwd?>">
<INPUT TYPE="hidden" name="ui_dbname" value="<?php echo $ui_dbname?>">
<INPUT TYPE="hidden" name="ui_collation" value="<?php echo $ui_collation?>">
<TR>
	<TD class=table_td colspan=5 align=center><?php  echo getlang("ล้างข้อมูลในตารางเดิม::l::Clear data in table");?> <INPUT TYPE="checkbox" NAME="isclearold" value="yes"  style="border: 0px"></TD>
</TR>
<TR>
	<TD class=table_td colspan=5 align=center><INPUT TYPE="submit" value="     Connect     "></TD>
</TR>
</FORM></TABLE>
<BR><?php 
foot();
?>