<?php 
function form_lib_login() {
		global $dcrURL;
		global $dcr;
		global $IPADDR;
		redir($dcrURL,75);
	global $_SERVER;
	$iprange=trim(getval("_SETTING","liballowlogin_iprange"));
	if ($iprange!="") {
//////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 * ip_in_range.php - Function to determine if an IP is located in a
 *                   specific range as specified via several alternative
 *                   formats.
 *
 * Network ranges can be specified as:
 * 1. Wildcard format:     1.2.3.*
 * 2. CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
 * 3. Start-End IP format: 1.2.3.0-1.2.3.255
 *
 * Return value BOOLEAN : ip_in_range($ip, $range);
 *
 * Copyright 2008: Paul Gregg <pgregg@pgregg.com>
 * 10 January 2008
 * Version: 1.2
 *
 * Source website: http://www.pgregg.com/projects/php/ip_in_range/
 * Version 1.2
 *
 * This software is Donationware - if you feel you have benefited from
 * the use of this tool then please consider a donation. The value of
 * which is entirely left up to your discretion.
 * http://www.pgregg.com/donate/
 *
 * Please do not remove this header, or source attibution from this file.
 */


// decbin32
// In order to simplify working with IP addresses (in binary) and their
// netmasks, it is easier to ensure that the binary strings are padded
// with zeros out to 32 characters - IP addresses are 32 bit numbers
Function decbin32 ($dec) {
  return str_pad(decbin($dec), 32, '0', STR_PAD_LEFT);
}

// ip_in_range
// This function takes 2 arguments, an IP address and a "range" in several
// different formats.
// Network ranges can be specified as:
// 1. Wildcard format:     1.2.3.*
// 2. CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
// 3. Start-End IP format: 1.2.3.0-1.2.3.255
// The function will return true if the supplied IP is within the range.
// Note little validation is done on the range inputs - it expects you to
// use one of the above 3 formats.
Function ip_in_range($ip, $range) {
  if (strpos($range, '/') !== false) {
    // $range is in IP/NETMASK format
    list($range, $netmask) = explode('/', $range, 2);
    if (strpos($netmask, '.') !== false) {
      // $netmask is a 255.255.0.0 format
      $netmask = str_replace('*', '0', $netmask);
      $netmask_dec = ip2long($netmask);
      return ( (ip2long($ip) & $netmask_dec) == (ip2long($range) & $netmask_dec) );
    } else {
      // $netmask is a CIDR size block
      // fix the range argument
      $x = explode('.', $range);
      while(count($x)<4) $x[] = '0';
      list($a,$b,$c,$d) = $x;
      $range = sprintf("%u.%u.%u.%u", empty($a)?'0':$a, empty($b)?'0':$b,empty($c)?'0':$c,empty($d)?'0':$d);
      $range_dec = ip2long($range);
      $ip_dec = ip2long($ip);

      # Strategy 1 - Create the netmask with 'netmask' 1s and then fill it to 32 with 0s
      #$netmask_dec = bindec(str_pad('', $netmask, '1') . str_pad('', 32-$netmask, '0'));

      # Strategy 2 - Use math to create it
      $wildcard_dec = pow(2, (32-$netmask)) - 1;
      $netmask_dec = ~ $wildcard_dec;

      return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
    }
  } else {
    // range might be 255.255.*.* or 1.2.3.0-1.2.3.255
    if (strpos($range, '*') !==false) { // a.b.*.* format
      // Just convert to A-B format by setting * to 0 for A and 255 for B
      $lower = str_replace('*', '0', $range);
      $upper = str_replace('*', '255', $range);
      $range = "$lower-$upper";
    }

    if (strpos($range, '-')!==false) { // A-B format
      list($lower, $upper) = explode('-', $range, 2);
      $lower_dec = (float)sprintf("%u",ip2long($lower));
      $upper_dec = (float)sprintf("%u",ip2long($upper));
      $ip_dec = (float)sprintf("%u",ip2long($ip));
      return ( ($ip_dec>=$lower_dec) && ($ip_dec<=$upper_dec) );
    }

    echo 'Range argument is not in 1.2.3.4/24 or 1.2.3.4/255.255.255.0 format';
    return false;
  }

}
//////////////////////////////////////////////////////////////////////////////////////////////////////
	$pass=false;
	$iprangea=explodenewline($iprange);
	@reset($iprangea);
	while (list($k,$v)=each($iprangea)) {
		if (ip_in_range($IPADDR,$v)==true) {
			$pass=true;
			break;
		}
	}
		if ($pass==false) {
			echo "<BR>";
			$s=getlang("ไม่อนุญาตให้ล็อกอินได้ เนื่องจากเจ้าหน้าที่สูงสุดได้กำหนดกลุ่มเลขไอพีสำหรับปฏิบัติงานของเจ้าหน้าที่ห้องสมุดไว้ [$iprange] (หมายเลขไอพีของคุณคือ $IPADDR)<BR>หากมีปัญหาหรือข้อสงสัย กรุณาติดต่อผู้ดูแลระบบ::l::Cannot login. Administration specific IP Range for librarian [$iprange] (Your IP Address is $IPADDR)<BR> For more information please contact your administrator.");
			html_dialog("IP Range restriction",$s);
			foot();
			die;
		}
	}
?><FORM METHOD=POST ACTION="/<?php  echo $dcr;?>/library/login.php">

<TABLE width=700 height= 260 align=center border=0 cellpadding=0 cellspacing=0
background="/<?php  echo $dcr;?>/neoimg/formlogin_library.png">
<TR>
	<TD valign=middle style="padding-right: 30px;">

	<TABLE align=right >
<TR>
	<TD bgcolor="#6C6C6C" style="font-size: 18px; font-weight: bold; color: #FF8000; " align=center colspan=2><?php  echo getlang("กรุณาป้อนล็อกอินและรหัสผ่าน::l:: Enter login and password "); ?></TD>
</TR>
	<TR>
		<TD><B><?php  echo getlang("รหัสล็อกอิน::l::Loginid"); ?></B></TD>
		<TD>: <input ID = "FC" type = "text" name = "useradminid" 4  autocomplete=off>
<SCRIPT LANGUAGE = "JavaScript">
<!--
getobj('FC').focus()
          //-->
</SCRIPT></TD>
	</TR>
	<TR>
		<TD><B><?php  echo getlang("รหัสผ่าน::l::Password"); ?></B></TD>
		<TD>: <input type = "password" name = "passwordadmin" autocomplete=off></TD>
	</TR>

<TR>
	<TD></TD>
	<TD><input  type = submit value = "<?php  echo getlang("เข้าสู่ระบบ::l::Login"); ?>" name = "submit" class=frmbtn>
<input type = reset value = "<?php  echo getlang("ลบข้อมูล::l::Reset"); ?>" name = "submit2" class=frmbtn></TD>
</TR>
</TABLE>
	
	</TD>
</TR>


</TABLE>
</FORM>

							<CENTER><BR>
							<A HREF="/<?php echo $dcr;?>/root/"><?php  echo getlang("ระบบเจ้าหน้าที่สูงสุด::l::Administrator system"); ?></A> : 
							<A HREF="/<?php echo $dcr;?>/">Home Page</A><BR>
<BR>
</CENTER>


<CENTER><BR>

<?php 
if (getval("_SETTING","islibcanusecookielogin")=="yes") {
	$libraryautologincookie=trim($_COOKIE[LIBAUTHC]);
		$libraryautologincookies=tmq("select * from library_cookielogin where dat='$libraryautologincookie' ");
		if (tnr($libraryautologincookies)!=0) {
			pagesection(getlang("ล็อกอินอัตโนมัติ::l::Autologin"));
			while ($r=tmq_fetch_array($libraryautologincookies)) {
				$s=tmq("select * from library where UserAdminid='$r[loginid]' ");
				if (tnr($s)!=1) {
					continue;
				}
				$s=tfa($s);
				?><TABLE>
				<FORM METHOD=POST ACTION="/<?php echo $dcr;?>/library/login.php">
						<TR>
						<INPUT TYPE="hidden" name=cookielogin value="<?php  echo $s[UserAdminID]?>">
					<TD><INPUT TYPE="submit" value="<?php  echo getlang("ล็อกอินเป็น::l::Login as"); ?>  <?php  echo $s[UserAdminName]?> (<?php  echo $s[UserAdminID]?>)" style="background-color: #DFEEFF; width: 340px; "></TD>
				</TR>
				</FORM>
				</TABLE><?php 
			}
		}
}
$ipuse=trim($_SERVER[REMOTE_ADDR]);
//echo $ipuse;
$s=tmq("select * from library where ipautologin='$ipuse' ",false);
//echo tmq_num_rows($s);
$tmp= tmq_num_rows($s);
//var_dump($tmp);
if ($ipuse!="" &&$tmp!=0) {
	pagesection(getlang("ล็อกอินอัตโนมัติ::l::Autologin")." (IP)");
	echo "<CENTER>".getlang("ล็อกอินอัตโนมัติสำหรับ::l::Autologin for ")." IP:$ipuse</CENTER>";
	while ($r=tfa($s,false)) { 
		//printr($r);
		?>		<FORM METHOD=POST ACTION="/<?php echo $dcr;?>/library/login.php">
<TABLE>
				<TR>
				<INPUT TYPE="hidden" name=refererip value="<?php  echo $ipuse?>">
				<INPUT TYPE="hidden" name=choosedid value="<?php  echo $r[UserAdminID]?>">
			<TD><INPUT TYPE="submit" value="<?php  echo getlang("ล็อกอินเป็น::l::Login as"); ?>  <?php  echo $r[UserAdminName]?> (<?php  echo $r[UserAdminID]?>)" style="background-color: #DFEEFF; width: 340px; "></TD>
		</TR>
		
		</TABLE></FORM><?php 
	}
}

?>

<img border=0 width=1 height=1 style="visibility:hidden;"
src="<?php  echo getval("SYSCONFIG","ulibmasterurl");?>_pingserver.php?tg=<?php echo $_SERVER[SERVER_ADDR];?>&e=<?php  
echo str_replace('"','',strip_tags(getval("global", "HEAD")));
echo " ";
echo str_replace('"','',strip_tags(getval("global", "HEAD 2")));
echo " COMSPEC=";
echo urlencode($_SERVER[COMSPEC]);
echo " DOCUMENT_ROOT=";
echo urlencode($_SERVER[DOCUMENT_ROOT]);
echo " HTTP_HOST=";
echo urlencode($_SERVER[HTTP_HOST]);
echo " SERVER_ADDR=";
echo urlencode($_SERVER[SERVER_ADDR]);
echo " SERVER_ADMIN=";
echo urlencode($_SERVER[SERVER_ADMIN]);
echo " SERVER_NAME=";
echo urlencode($_SERVER[SERVER_NAME]);
echo " SERVER_PORT=";
echo urlencode($_SERVER[SERVER_PORT]);
echo " SERVER_SIGNATURE=";
echo urlencode($_SERVER[SERVER_SIGNATURE]);
echo " DCRURL=";
echo urlencode($dcrURL);
echo " rand=";

echo rand();?>">
</CENTER><br><?php 
}
?>