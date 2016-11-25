<?php

///configdb s
$u="root";
$p="xerenics0";
$dbname="ulibmnet_ulib6";
///configdb e

@mkdir("peacebackupdb");
$basepath=realpath(dirname(__FILE__));
$servername = "127.0.0.1";
$username = "$u";
$password = "$p";

   $result = array(); 
/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
	
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
        @mkdir("peacebackupdb/$name");
	$handle = fopen("peacebackupdb/$name/$table.sql",'w+');
	fwrite($handle,$return);
	fclose($handle);
}
function dbtbtoarray($host,$user,$pass)
{
global $res;
//echo "dbtbtoarray";
	
	$link = mysql_connect($host,$user,$pass);
$s= mysql_query('show databases');
while ($dcr=mysql_fetch_array($s)) {
  if ($dcr[0]=="information_schema") continue;
  //print_r($dcr);
	mysql_select_db($dcr[0],$link);

		$s2= mysql_query('SHOW TABLES');
		while($r= mysql_fetch_row($s2))
		{ //print_r($r);

			$res[] = "./peacebackupdb/".$dcr[0]."/".$r[0].".sql";
		}
}
}
function dirToArray($dir) { 
   global $result;


   $cdir = scandir($dir); 
   foreach ($cdir as $key => $value) 
   { 
      if (!in_array($value,array(".","..","staticbackup","peacebackup.seeder.php","peacebackup.puller.php","peacebackup","peacebackupdb","bin"))) 
      { 
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
         { 
           dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
         } 
         else 
         { 
            $ext=explode(".",$value);
            //echo count($ext); print_r($ext);
            if (count($ext)==0) {
               $ext="";
            } else {
               $ext=$ext[count($ext)-1];
            }
            $ext=strtolower($ext);
            //echo "[$ext]";
            if (strlen($ext)<6 && $ext!="" &&
            $ext!="exe" && $ext!="rar" && $ext!="db"
            ) {
               if (filesize($dir . DIRECTORY_SEPARATOR .  $value)<(10*1024*1024)) {
                  $result[] =$dir . DIRECTORY_SEPARATOR .  $value; 
               }
            }
         } 
      } 
   } 
   
   return $result; 
} 
$cmd=@trim($_GET["cmd"]);
$file=@trim($_GET["file"]);

if ($cmd=="filelist") {
$res=dirToArray(".");
if ($username!="" && $password!="") {
  dbtbtoarray($servername ,$username,$password);
}
//print_r($res); die;
$res=serialize($res);
$res=base64_encode($res);
echo $res;
die;
}

$file=base64_decode($file);
$filechk=explode("/",$file);
//print_r($filechk);
if ($cmd=="getfile" && ($filechk[0]=="peacebackupdb" || file_exists($file))) {
//echo "<BR>getfile: $file";

if ($filechk[0]=="peacebackupdb") {
$filechk[2]=str_replace(".sql","",$filechk[2]);
backup_tables($servername,$username,$password,$filechk[1],$filechk[2]);
   //die("kk");
} 
$handle = @fopen($file, "rb");
$buffera="";
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        $buffera=$buffera.$buffer;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

echo base64_encode($buffera);
die;
}
?>.eof seeder