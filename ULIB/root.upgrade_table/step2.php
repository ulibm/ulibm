<?php 
	; 
			set_time_limit(600);
        include ("../inc/config.inc.php");
		$ui_passwd=stripslashes($ui_passwd);
		$ui_passwd=stripslashes($ui_passwd);
		$ui_passwd=stripslashes($ui_passwd);
		$ui_passwd=stripslashes($ui_passwd);
		head();
        mn_root("upgrade_table");
			pagesection("Upgrade Table");

?><BR>
<?php /*
$link=tmq_connect($ui_host, $ui_user, $ui_passwd,true);
if (!$link) {
    echo 'Could not connect to mysql';
    exit;
}
if ($ui_dbname==$dbname) {
	die("could not use same dbname $ui_dbname;");
}

if (!$link=tmq_select_db($ui_dbname,$link)) {
    echo 'Could not use db $ui_dbname';
    exit;
}*/
$tmq_autoconnect_collation=$ui_collation;
$tmq_autoconnect_host=$ui_host;
$tmq_autoconnect_user=$ui_user;
$tmq_autoconnect_passwd=$ui_passwd;

/////////////////tables form our db
$sql = "SHOW columns FROM $ui_table";
$result = tmq($sql);
$my_col=Array();
while ($r=tfa($result)) {
	$my_col[]=$r[0];
}
///////////////////
$sql = "SHOW columns FROM $ui_table";
$result = tmq($sql,false,$ui_dbname);
$remote_col=Array();
while ($r=tmq_fetch_array($result)) {
	$remote_col[]=$r[0];
}


//print_r($my_col); echo "<br>";
//print_r($remote_col);
$sql = "select * FROM $ui_table;";
$result = tmq($sql,false,$ui_dbname);
//var_dump($link);
//echo tmq_error();
if ($isclearold=="yes" && tnr($result)>0) {
	tmq("delete from $ui_table");
}

$content="";
$i=0;
		//echo tnr($result);
		while ($row=tfa($result)) {
			//printr($row);
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
			//$insert=str_replace(",\n", "", $insert);
			$insert=rtrim($insert,",");
			$insert.=";\n";
			$content.=$insert;
	
			if ($i<20) {
				tmq($insert,false,$dbname);
			} else { //die;
				tmq($insert,false);
			}
			$i++;
		}
			
?><CENTER><?php  echo getlang("เรียบร้อย นำเข้าจำนวน $i รายการ::l::DONE,  ecexcuted  $i  records"); ?>.<BR><BR>
<A HREF="<?php  echo "step1.php?ui_host=$ui_host&ui_user=$ui_user&ui_passwd=$ui_passwd&ui_dbname=$ui_dbname&ui_collation=$ui_collation#$ui_table";?>"><?php echo getlang("Back");?></A></CENTER>
<BR><?php 
foot();
?>