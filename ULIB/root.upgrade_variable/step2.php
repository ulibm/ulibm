<?php 
	; 
			$ui_passwd=@stripslashes($ui_passwd);
			$ui_passwd=@stripslashes($ui_passwd);
			$ui_passwd=@stripslashes($ui_passwd);
			$ui_passwd=@stripslashes($ui_passwd);

	ob_start();
		set_time_limit(600);
        include ("../inc/config.inc.php");
			$ui_passwd=@stripslashes($ui_passwd);
			$ui_passwd=@stripslashes($ui_passwd);
			$ui_passwd=@stripslashes($ui_passwd);
			$ui_passwd=@stripslashes($ui_passwd);
		head();
        mn_root("upgrade_variable");
			pagesection("Upgrade Variable to Current");

tmq("delete from barcode_valmem");
tmq("delete from  valmem");
?><BR>
<?php 
if ($ui_dbname==$dbname) {
	die("<font  color=red>could not use same dbname $ui_dbname;</font>");
}
$tmq_autoconnect_collation=$ui_collation;
$tmq_autoconnect_host=$ui_host;
$tmq_autoconnect_user=$ui_user;
$tmq_autoconnect_passwd=$ui_passwd;
/*
$link=tmq_connect($ui_host, $ui_user, $ui_passwd,true);
if (!$link) {
    echo 'Could not connect to mysql';
    exit;
}
if (!$link=tmq_select_db($ui_dbname,$link)) {
    echo "Could not use db $ui_dbname";
    exit;
}*/
if ($ui_collation!="") {
	tmq("set names '$ui_collation';",false,$ui_dbname);
}
$sql = "SHOW TABLES FROM $ui_dbname";
$result = tmq($sql,false,$ui_dbname);

if (!$result) {
    echo "DB Error, could not access dbs\n";
    echo 'MySQL Error: ' . tmq_error();
    exit;
}

//$tbtoupdate=explode(',',"webpage_menu,webpage_sections");
//printr($tbtoupdate);
?><?php 

	if ($page=="") {
		$page=0;
	} else {
		$page=$page+1;
	}
@reset($tbtoupdate);
//echo "[$currenttb]";
?><CENTER><?php 
//$dbmode="mysql";
$sql = "select * FROM val";
//echo "[$ui_dbname]";
$result = tmq($sql,false,$ui_dbname);
echo tmq_error();
$content="";
$i=0;
while ($row=tfa($result)) {
	//printr($row);
	/*echo "[".($row[descr])."]"; 
	echo "[".iconvutf($row[descr])."]"; 
	echo "[".iconvth($row[descr])."]"; die;*/
	$s=tmq("select * from val where main='$row[main]' and sub='$row[sub]' ",false);
	if (tmq_num_rows($s)==1) {
		$rval=stripslashes($row[val]);
		$rval=stripslashes($rval);
		$rval=stripslashes($rval);
		$rval=addslashes($rval);
		//$rval=iconvth($rval);
		$s="update val set val='$rval' where main='$row[main]' and sub='$row[sub]' ";
		//echo $s."<BR>";
		tmq($s);
	}
}

$sql = "select * FROM barcode_val";
$tmq_autoconnect_collation=$ui_collation;
$result = tmq($sql,false,$ui_dbname);
echo tmq_error();
$content="";
$i=0;
while ($row=tfa($result)) {
	//printr($row);
	$s=tmq("select * from barcode_val where classid='$row[classid]'  ",false);
	if (tmq_num_rows($s)==1) {
		$rval=stripslashes($row[val]);
		$rval=stripslashes($rval);
		$rval=stripslashes($rval);
		$rval=addslashes($rval);
		//$rval=iconvutf($rval);
		$s="update barcode_val set val='$rval' where  classid='$row[classid]' ";
		//echo $s."<BR>";
		tmq($s);
	}
}
tmq("delete from valmem");
tmq("delete from barcode_valmem");
html_dialog("",getlang("เรียบร้อย::l::Done"));
?></CENTER><?php 
foot();
?>