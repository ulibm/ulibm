<?php 
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
        mn_root("upgrade_tocurrent");
			pagesection("Upgrade to Current");

?><BR>
<?php /*
if ($ui_dbname=="-localdb-") {
	die("could not use same dbname $ui_dbname;");
}

$link=tmq_connect($ui_host, $ui_user, $ui_passwd,true);
if (!$link) {
    echo 'Could not connect to mysql';
    exit;
}
if (!$link=tmq_select_db($ui_dbname,$link)) {
    echo 'Could not use db $ui_dbname';
    exit;
}
tmq("set names '$ui_collation';",false,$link);
*/
   $ui_collation=barcodeval_get("root_upgradetocurrent_coll");
   $ui_host=barcodeval_get("root_upgradetocurrent_host");
   $ui_user=barcodeval_get("root_upgradetocurrent_user");
   $ui_passwd=barcodeval_get("root_upgradetocurrent_passwd");
   $ui_dbname=barcodeval_get("root_upgradetocurrent_dbname");

$tmq_autoconnect_collation=$ui_collation;
$tmq_autoconnect_host=$ui_host;
$tmq_autoconnect_user=$ui_user;
$tmq_autoconnect_passwd=$ui_passwd;

$sql = "SHOW TABLES FROM $ui_dbname";
$result = tmq($sql,false,$ui_dbname);

if (!$result) {
    echo "DB Error, could not access dbs\n";
    echo 'MySQL Error: ' . tmq_error();
    exit;
}
include("tbtoupdate.php");
///$tbtoupdate=explode(",","media");

//$tbtoupdate=explode(',',"webpage_menu,webpage_sections");
//printr($tbtoupdate);
?><?php 

	if ($page=="") {
		$page=0;
	} else {
		$page=$page+1;
	}
@reset($tbtoupdate);
$currenttb=$tbtoupdate[$page];
//echo "[$currenttb]";
?><CENTER><?php 
$numset=count($tbtoupdate);
if ($page>=count($tbtoupdate)) {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("UPGRADE COMPLETED");
	//-->
	</SCRIPT><?php 
	redir("index.php",0);
	die;
} else {

	$startposition=floor(sessionval_get("upgradetocurrent_rowi"));

		 echo getlang("กำลังอัพเกรด [$currenttb] หลังจากเสร็จ จะทำการอัพเกรดรอบต่อไปโดยอัตโนมัติ::l::. Upgrading [$currenttb]  , After finish this file, system will continue automatically"); ?><BR><BR><BR>
	<FONT SIZE="" COLOR="#5D5D5D"><B><H1>[<?php  echo $page +1?>/<?php  echo $numset ?>]</H1></B></FONT><BR><CENTER><?php 
	echo html_graph("V",$numset+1,$page,20,800,"#952F2F");
	$redirpath="step2.php?page=".($page)."&rand=".randid();
	$redirpathback="step2.php?page=".($page-1)."&rand=".randid();
	echo "</CENTER><BR><BR><BR>Creating INFO.struct ..";
    ob_flush();
    flush();
	usleep(100);

$ui_table=$currenttb;


//tmq("set names '$ui_collation';",false,$ui_dbname);


/////////////////tables form our db
$sql = "SHOW columns FROM $ui_table";
//$result = tmq($sql);
echo "<!-- ";
$result = tmq($sql,false);
echo " -->";

$my_col=Array();
while ($r=tmq_fetch_array($result)) {
	$my_col[]=$r[0];
}
///////////////////
	///////////////////
$sql = "SHOW columns FROM $ui_table";
$result = tmq($sql,false,$ui_dbname);
$remote_col=Array();
while ($r=tmq_fetch_array($result)) {
	$remote_col[]=$r[0];
}



//tmq("set names '$ui_collation';",false,$ui_dbname);
$sql = "SELect * FROM $ui_table";
echo "<!-- ";
$result = tmq($sql,false,$ui_dbname);
echo " -->";
echo "[".floor(tnr($result))."]";
if (floor(tnr($result))>0) {
echo "delete";
	tmq("delete from $ui_table",true,"-localdb-");
} //else die("die");
$content="";
$i=0;
		while ($row=tfa($result)) {
            $insert = "INSERT INTO $ui_table set ";
			$usej=0;
            for ($j=0; $j < tmq_num_fields($result); $j++) {
				//echo $remote_col[$j]. " : j=$j/usej=$usej<br>";
				if (!in_array($remote_col[$j],$my_col)) {
					echo "not in array $remote_col[$j]<BR>";
					continue;
				}
				$usej++;
				$insert.=" $remote_col[$j]=";
                if (!isset($row[$j]))
                    $insert.="'',";
                else if ($row[$j] != "")
                    $insert.="'" . addslashes($row[$j]) . "',";
                else
                    $insert.="'',";
			}
			//$insert=preg_replace(",$", "", $insert);
			$insert=rtrim($insert,",");
			$insert.=";\n";
			$content.=$insert;
			//echo $insert; 
			if ($i<20) {
				tmq($insert,false,"-localdb-");
			} else { //die;
				tmq($insert,false,"-localdb-");
			}
			$i++;
		}

///die;
    ob_flush();
    flush();
	usleep(100);

?><CENTER>
<?php  echo getlang("เรียบร้อย ดำเนินการจำนวน $i รายการ::l::DONE,  ecexcuted  $i  times"); ?></CENTER><BR><BR>
<?php 
	redir($redirpath,0);

}

?></CENTER><?php 
foot();
?>