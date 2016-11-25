<?php 
@error_reporting( E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);

/*
CREATE DATABASE tmpimport DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci; 
CREATE USER tmpimport@localhost IDENTIFIED BY 'tmpimport';
GRANT ALL  ON tmpimport.* TO 'tmpimport'@'localhost';

FLUSH PRIVILEGES;
*/
@ini_set( "display_errors", true );
$vspath="../";
set_time_limit(0);
// Emulate register_globals on
//if (!ini_get('register_globals')) {
    $superglobals = array($_SERVER, $_ENV,
        $_FILES, $_COOKIE, $_POST, $_GET);
    if (isset($_SESSION)) {
        array_unshift($superglobals, $_SESSION);
    }
    foreach ($superglobals as $superglobal) {
        extract($superglobal, EXTR_SKIP);
    }
    ini_set('register_globals', true);
//}
$f[]="inc/config.inc.sv.php";
//$f[]="inc/config.inc.php";
$f[]="inc/c.inc.php";
	$pp = @pathinfo($SCRIPT_FILENAME);
	//print_r($pp);

?><BR><BR>
<FORM METHOD=POST ACTION="index.php?action=yes" onsubmit="return submitchk(this.form);">
<table align=center cellspacing=20 width=550 style="-webkit-box-shadow: -3px -3px 30px 0px rgba(50, 50, 50, 1);
-moz-box-shadow:    -3px -3px 30px 0px rgba(50, 50, 50, 1);
box-shadow:         -3px -3px 30px 0px rgba(50, 50, 50, 1);" bgcolor=white>
<tr>
	<td align=left>

<CENTER><IMG SRC="../_tmp/logo/_weblogo.png" WIDTH="261" HEIGHT="66" BORDER="0" ALT=""><BR><B><FONT SIZE="6" COLOR="#4D4D4D">Welcome to Install Utility</FONT></B>
</CENTER><HR noshade><?php 
if ($action=="yes") {
sleep(1);
	@reset($f);
	while (list($k,$v)=each($f)) {
		$source="$vspath$v.tp";
		$dest="$vspath$v";
		@chmod($dest, 0777); 
		echo "<B><FONT  COLOR=darkgreen>Managing</FONT></B>:$v";
		if (!file_exists($source)) {
			echo "<BR>&nbsp;&nbsp;error: config template(*.tp) not exists.";
		} else {
			$handle = @fopen($source, "r");
			if ($handle) {
				$buffer="";
				while (!feof($handle)) {
					$buffer .= fgets($handle, 4096);
				}
				fclose($handle);
				$internalencoding="utf8";

				$buffer=str_replace('%DBPWD%',$vdbpwd,$buffer);
				$buffer=str_replace('%DBUSER%',$vdbuser,$buffer);
				$buffer=str_replace('%DBHOST%',$vdbhost,$buffer);
				$buffer=str_replace('%DBMODE%',$dbmode,$buffer);
				$buffer=str_replace('%DBNAME%',$vdbname,$buffer);
				$buffer=str_replace('%internalencoding%',$internalencoding,$buffer);

				if (is_writable($dest)) {
				   if (!$handle = fopen($dest, 'w')) {
						echo "<BR><B>writeerror: </B>Cannot open file ($dest)";
						exit;
				   }
				   if (fwrite($handle, $buffer) === FALSE) {
					   echo "<BR><B>writeerror: </B>Cannot write to file ($dest)";
					   exit;
				   }
				   fclose($handle);

				} else {
				   echo "<BR><B>writeerror: </B>The file $dest is not writable";
				   exit;
				}

				echo "<BR>&nbsp;&nbsp;<B>Success</B>.";
			} else {
				echo "<BR>&nbsp;&nbsp;<B>error</B>: config template cannot be opened ($source).";
			}
		}
		echo "<BR>";
	}
	echo "<BR>
		<HR><A HREF=index.php>Back to Install's main</A> <A HREF='../index.php'>Go to installed ULibM</A><BR><HR>";
	if ($istdb=="yes") {
		include("./tmq.php");
		$conn=mysql_connect($vdbhost, $vdbuser, $vdbpwd);
        if (!$conn) {
            die(("ติดต่อกับ MYSQL Server ไม่ได้/Cannot connect to MYSQL Server"));
		}

		if ($dropold=="yes") {
			mysql_query("Drop DATABASE `$vdbname` ");
			echo mysql_error();
		}
		if ($encodeasthai=="yes") {
			mysql_query("SET NAMES 'utf8';");
			echo mysql_error();
		}
		if ($dbversion=="0") {
		} elseif ($dbversion=="3") {
			mysql_query("CREATE DATABASE `$vdbname` ");
			echo mysql_error();
		} else {
			mysql_query("CREATE DATABASE `$vdbname` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci; ");
			echo mysql_error();
		}

		if (!mysql_select_db($vdbname, $conn)) {
			die(("ไม่สามารถเลือกใช้งานฐานข้อมูลได้/Cannot use specified database [$vdbname]"));
		}

$i=0;
$buff="";
$handle = fopen("./backup-full.sql", "rb");
$expact="#%%";
while (!feof($handle)) {
  $buff .= fread($handle, 1);
  $decus=substr($buff,-3);
  if ($decus==$expact) {
	  $buff=trim($buff,$expact);
	tmq($buff);
	$i++;

	//echo $buff; if ($i>50 ) die;
	$buff="";
  }
}

	mysql_query("delete from barcode_val where classid like 'activateulib-%' ");
	echo mysql_error();
	mysql_query("update library set `Password` = MD5( 'ulibm123' )  ");
	echo mysql_error();
	mysql_query("update useradmin set `Password` = MD5( 'ulibm123' ) ");
	echo mysql_error();
	mysql_query("update webpage_hpsidebar set `isshow` = 'no' ");
	echo mysql_error();


echo "<FONT COLOR=gray><BR>Database installed with $i queries.</FONT>";
	}
} else {
	$pp = @pathinfo($SCRIPT_FILENAME);
	$svpathforcmd=str_replace("install","",$pp[dirname]);
	$svpathforcmd=rtrim($svpathforcmd,"/\\");
	//print_r($pp);
	//print_r($_SERVER);
		$tmpisinstall=str_replace('index.php','',$SCRIPT_NAME);
		$tmpisinstall=trim($tmpisinstall,'/');
		$tmpisinstall=explode('/',$tmpisinstall);
		$tmpisinstall=$tmpisinstall[count($tmpisinstall)-1];
		//echo "[$tmpisinstall]";
		if ($tmpisinstall!="" && $tmpisinstall!="install") {
			die("ติดตั้งได้ก็ต่อเมื่อโฟลเดอร์นี้ชื่อ install, can install only when this folder named install.");
		}
	//print_r($tmpisinstall);

	?>
This will help you configure the program. please enter information required by the system.<BR>
More information and help available on <A HREF="http://www.ulibm.net" target=_blank>www.ulibm.net</A>
<HR noshade>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function confrm(wh) {
		if (confirm("Please Confirm/กรุณายืนยัน")){
			wh.sbmt.disabled=true
			return true;
		}
		return false;
	
	}
//-->
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
<!--
pic1= new Image(100,25); 
pic1.src="uploading.gif"; 


function getobj(the_id) {

	if (typeof the_id != 'string') {
		return the_id;
	}

	if (typeof document.getElementById != 'undefined') {
		return document.getElementById(the_id);
	} else if (typeof document.all != 'undefined') {
		return document.all[the_id];
	} else if (typeof document.layers != 'undefined') {
		return document.layers[the_id];
	} else {
		return null;
	}
}


function submitchk(wh) {
	if (confirm("Please Confirm/กรุณายืนยัน")){
		tmp=getobj("uploadbtn");
		tmp.style.display="none";
		tmp=getobj("uploading");
		tmp.style.display="inline";
		return true;
	} else {
		return false;
	}
}
//-->
</SCRIPT><BR>
&nbsp;&nbsp;&nbsp;Database Mode <select name="dbmode">
	<option value="mysql" >MySQL
	<option value="mysqli" selected>MySQLi
</select><BR>
&nbsp;&nbsp;&nbsp;Database Server <INPUT TYPE="text" NAME="vdbhost" value="localhost"><BR>
&nbsp;&nbsp;&nbsp;Database User <INPUT TYPE="text" NAME="vdbuser" value="root"><BR>
&nbsp;&nbsp;&nbsp;Database Name <INPUT TYPE="text" NAME="vdbname" value="<?php  
		$tmp=str_replace('index.php','',$SCRIPT_NAME);
		$tmp=trim($tmp,'/');
		$tmp=str_replace('install','',$tmp);
		$tmp=trim($tmp,'/');

		$tmp=explode('/',trim($tmp,'/'));
		$directory= $tmp[count($tmp)-1];
		echo strtolower($directory);?>"><BR>
&nbsp;&nbsp;&nbsp;Database Password <INPUT TYPE="password" NAME="vdbpwd" value=""><BR>
<INPUT TYPE="checkbox" NAME="istdb" value="yes"> Install Database<BR>
&nbsp;&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="dropold" value="yes"> Drop Old Database<BR>
&nbsp;&nbsp;&nbsp;<INPUT TYPE="checkbox" NAME="encodeasthai" value="yes" checked> Encode as UTF8<BR>
<BR><HR noshade>
<?php 

	
///////////////

$local_modchk_help= Array();
function local_modchk($wh,$cate="") {
	global $local_modchk_help;
	global $svpathforcmd;
	global $vspath;
	$vspath2=rtrim($vspath,'/');
	$b=@chmod($wh,0777);
	if (!$b) {
		echo "<B>"."มีปัญหาเกี่ยวกับการเปลี่ยนโหมดไฟล์/File permission problem"." </B>- ไม่อนุญาตให้ติดตั้ง [$wh]<BR>";
		$tmpd=trim($wh,'.');
		$tmpd=trim($tmpd,'/');
		$tmpd=trim($tmpd,'/.\\');
		//$tmpd=$dcrs.$tmpd;
		$local_modchk_help[].="chown apache:apache '$svpathforcmd/$tmpd' ;";
		//$local_modchk_help[].="chgrp apache '$vspath2/$tmpd' ;";
	}
}

	@reset($f);
	while (list($k,$v)=each($f)) {
		local_modchk("../$v",$v);
	}

if (count($local_modchk_help)!=0) {
	$local_modchk_help=array_unique($local_modchk_help);
	$local_modchk_help=join($local_modchk_help,"<BR>");
	?><BR><BR><TABLE bgcolor=#858585 width=100% align=center>
	<TR>
		<TD  bgcolor=#E0E0E0><?php  echo ("หากคุณเป็นผู้ดูแลระบบเซิร์ฟเวอร์บนระบบปฏิบัติการ Linux/If you are server administrator (Linux) ");?><BR>
		Execute in command line</TD>
	</TR>
	<TR>
		<TD  bgcolor=#E0E0E0><?php  echo $local_modchk_help;?><BR><BR><small><B>* apache:apache</B> คือชื่อ User และ Group ของโปรแกรม Apache หากเซิร์ฟเวอร์ของคุณมีการปรับแต่งเป็นอย่างอื่น ก็ต้องแก้ apache:apache ตามด้วย</small></TD>
	</TR>
	</TABLE><?php 
		//die;
}

if (!function_exists("mysql_connect")) {
	echo "<B>ไม่พบฟังก์ชันของ MySQL กรุณาตรวจสอบ/MySQL function not found</B> - ไม่อนุญาตให้ติดตั้ง";
	die;
}

///////////////		
	?>
<input type=hidden NAME="dbversion" value="4">

	<span ID="uploading" style="display:none">Processing: <IMG SRC="uploading.gif" WIDTH="128" HEIGHT="15" BORDER="0" ALT="" align=absmiddle></span>
	<span ID="uploadbtn"><INPUT TYPE="submit" value=" Install " name=sbmt ID=sbmt></span>

	<SCRIPT LANGUAGE="JavaScript">
	<!--
		tmp=getobj("uploadbtn");
		tmp.style.display="inline";
		tmp=getobj("uploading");
		tmp.style.display="none";

	//-->
	</SCRIPT>


	</td>
</tr>
</table>
</FORM>

<?php 

}

?>