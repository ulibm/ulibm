<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("function_req");
			pagesection(getlang("ความต้องการของระบบ::l::System Requirement"));

?><BR><TABLE align=center width=550>
<TR>
	<TD><?php 
function local_html_head($a,$b,$c) {
		?><BR><FONT SIZE="" COLOR="darkblue"><B><?php echo getlang($a);?></B></FONT><BR><?php 
		?><B><?php  echo getlang("ระบบที่เกี่ยวข้อง::l::Related modules"); ?>: </B><?php echo getlang($c);?><BR><?php  echo getlang("ผลการตรวจสอบ::l::Test result"); ?>: <?php 
}
function local_html_result($d,$e="") {
	if ($d) {
		?><FONT SIZE="" COLOR="darkgreen"><B><?php  echo getlang("ผ่านเงื่อนไข::l::PASS"); ?></B> <?php  echo getlang($e);?></FONT><?php 
	} else {
		?><FONT SIZE="" COLOR="darkred"><B><?php  echo getlang("ไม่ผ่านเงื่อนไข::l::FAIL"); ?></B> <?php  echo getlang($e);?></FONT><?php 
	}
	echo "<BR><HR>";
}
function local_res($a,$b,$c="") {
	local_html_head($a,$b,$c);
	if (function_exists("$b")) {
		local_html_result(true);
	} else {
		local_html_result(false);
	}
}

/////////////////////////

//local_res(getlang("ใช้ Apache เป็น web server::l::Use Apache as web server"),"apache_get_version","Server Software");

//////////////////////////
if (function_exists("apache_get_version")) {
	local_html_head("Apache version &gt; 1.2","","การทำงานของระบบ::l::System Operation");
		$s=apache_get_version();
		$s1=$s;
		$s=trim($s,"Apache/");
		$s=(floatval($s));
		
		if ($s>=1.2){
			local_html_result(true,"");
		} else {
			local_html_result(false,"แนะนำให้ใช้ เวอร์ชัน 1.2+ [ขณะนี้เป็น เวอร์ชัน $s1]::l::Version 1.2+ are recommended [currently $s1]");
		}
}
/////////////////////////

local_html_head("PHP version &gt; 5","","การทำงานของระบบ::l::System Operation");
	$s=phpversion();
	$s1=$s;
	$s=trim($s);
	$s=(floatval($s));
	
	if ($s>=5){
		local_html_result(true,"ขณะนี้เป็น เวอร์ชัน $s1");
	} else {
		local_html_result(false,"แนะนำให้ใช้ เวอร์ชัน 5+ [ขณะนี้เป็น เวอร์ชัน $s1]::l::Version ++ are recommended [currently $s1]");
	}

/////////////////////////
/*
local_html_head("เวอร์ชัน MySql &gt; 5","","การทำงานของระบบ::l::System Operation");
	$s=mysql_get_server_info($conn);
	$s1=$s;
	$s=floor(floatval($s));
	
	if ($s>=4){
		local_html_result(true,"ขณะนี้เป็น เวอร์ชัน $s1");
	} else {
		local_html_result(false,"แนะนำให้ใช้ เวอร์ชัน 5+ [ขณะนี้เป็น เวอร์ชัน $s1]::l::Version 4+ are recommended [currently $s1]");
	}
local_html_head("เวอร์ชัน 
MySqli &gt; 5","","การทำงานของระบบ::l::System Operation");
ConnDB();
	$s=mysqli_get_server_info($conn);
	$s1=$s;
	$s=floor(floatval($s));
	
	if ($s>=4){
		local_html_result(true,"ขณะนี้เป็น เวอร์ชัน $s1");
	} else {
		local_html_result(false,"แนะนำให้ใช้ เวอร์ชัน 5+ [ขณะนี้เป็น เวอร์ชัน $s1]::l::Version 5+ are recommended [currently $s1]");
	}*/
/////////////////////////


local_html_head("MySQL version &gt; 5","","Storage Engine");
	$s=tmq("SHOW variables like 'version' ");

	$r=tfa($s);
	//printr($r);
	if (floor($r[Value])>=5){
		local_html_result(true," ($r[Value])");
	} else {
		local_html_result(false,"เวอร์ชันไม่ถูกต้อง ($r[Value])");
	}


/////////////////////////

local_html_head("MySQL Storange Engine=MyISAM","","Storage Engine");
	$s=tmq("SHOW ENGINES ");
	$tmp="";
	while ($r=tfa($s)) {
	  if (strtolower($r[Engine])=="myisam") {
	  $tmp=$r[Support];
	  }
	}
	if (strtoupper($tmp)=="DEFAULT"){
		local_html_result(true,"Default ($tmp)");
	} else {
		local_html_result(false,"ไม่ได้ตั้ง MyISAM เป็น Engine เริ่มต้น  ($tmp)");
	}


//////////////////////////

local_html_head("MySQL Query Cache","","ระบบสืบค้น::l::Searching System");
	$s=tmq("SHOW VARIABLES LIKE  'query_cache_type'");
	$s=tfa($s);
	if (strtoupper($s[Value])!="OFF"){
		local_html_result(true,"Enabled ($s[Value])");
	} else {
		local_html_result(false,"ไม่เปิดใช้งาน  ($s[Value])");
	}


/////////////////////////
/*
local_html_head("MySql Encoding เป็นภาษาไทย::l::UTF encoding in MySql","","การทำงานของระบบ โดยเฉพาะการเรียงอักษร::l::System Operation , especially sorting-function");
	if (mysql_client_encoding($conn)=="tis620"){
		local_html_result(true,"แนะนำให้ใช้ tis620::l::tis620 are recommended");
	} else {
		local_html_result(false,"แนะนำให้ใช้ tis620 [ขณะนี้เป็น ".mysql_client_encoding($conn)."]::l::tis620 are recommended [currently ".mysql_client_encoding($conn)."]");
	}
	*/
	/////////////////////////
/////////////////////////

local_html_head("MySql Encoding เป็น UTF8::l::UTF8 encoding in MySql","","การทำงานของระบบ โดยเฉพาะการเรียงอักษร::l::System Operation , especially sorting-function");
$s=tmq("SELECT default_character_set_name as ccc FROM information_schema.SCHEMATA S WHERE schema_name = '$dbname';",
false);
$r=tfa($s);
//printr($r);
	if ($r[ccc]=="utf8"){
		local_html_result(true,"แนะนำให้ใช้ utf8::l::utf8 are recommended");
	} else {
		local_html_result(false,"แนะนำให้ใช้ utf8 [ขณะนี้เป็น $r[ccc]]::l::tis620 are recommended [currently $r[ccc]]");
	}
	
	/////////////////////////
/////////////////////////

local_html_head("PHP-xml","","การทำงานของระบบ OAI::l::System Operation , OAI");
	if(extension_loaded('xml')) {
		local_html_result(true,"ติดตั้ง php-xml แล้ว::l::php-xml installed");
	} else {
		local_html_result(false,"ยังไม่ได้ติดตั้ง php-xml ::l::php-xml not installed");
	}
	
	/////////////////////////	//////////////

local_res("G-Zip","gzopen","การบีบอัดข้อมูล::l::Data Compression");
local_res("ฟังก์ชันรูปภาพ::l::Image Function","ImageCreate","บาร์โค้ด::l::Barcode");
local_res("การเชื่อมต่อ Socket::l::Socket Communication","socket_create","SIP โปรโตคอล::l::SIP Protocol");
local_res("การเชื่อมต่อ LDAP::l::LDAP Function","ldap_bind","LDAP Authorization");
local_res("ฟังก์ชันการเชื่อมต่อ Z39.50::l::Z39.50 Function","yaz_connect","สืบค้นวัสดุสารสนเทศจากห้องสมุดอื่น ๆ::l::Retrieve information from other library");
//local_res("PDF document","pdf_open","บาร์โค้ด, พิมพ์ค่าปรับ, พิมพ์เอกสารอื่น ๆ::l::Barcode, Fines printing, Other documents");
local_res("FSO - Advance File System","file_get_contents","ดาวน์โหลดแบบฟอร์มต่าง ๆ และนำเข้า Marc จาก ULIB-Catalog::l::Download forms and import MARC from ULIB-Catalog ");
local_res("Server Status","system","Server Information");
local_res("Multibyte encoding","mb_detect_encoding","Language transformations");
//local_res("ฟังก์ชันการคำนวณวันเวลา","GregorianToJD","ระบบยืมคืน (หากไม่มีก็สามารถใช้งานโปรแกรม ULIB ได้)");
//local_res("Mail","mail","-");
//local_res("Printing Support","printer_open","ระบบยืมวัสดุอัตโนมัติ");

local_html_head("ปิด Session.auto start::l::Turn session.auto start Off","","Session control");

	if(ini_get("session.auto_start") =="On") {
		local_html_result(false,"ถูกเปิดไว้::l::Turned on");
	} else {
		local_html_result(true,"ถูกปิดแล้ว::l::Turned off");
	}
local_html_head("max_input_vars &gt; 2000","","Variable Management");

	if(floor(ini_get("max_input_vars")) <2000) {
		local_html_result(false,ini_get("max_input_vars"));
	} else {
		local_html_result(true,ini_get("max_input_vars"));
	}

local_html_head("ฟังก์ชันสำหรับโหลดไฟล์จากอินเทอร์เน็ท::l::Function for downloading data frominternet","","Yaz-Pear-Pecl installing::l::Yaz-Pear-Pecl installing");

	if( !($fd = fopen($dcrURL,"r")) ) {
		local_html_result(false,"ใช้งานไม่ได้::l::Disabled");
	} else {
		local_html_result(true,"ใช้งานได้::l::Enabled");
	}
		/////////////////////////
if (function_exists("apache_get_modules")) {
local_html_head("mod_rewrite","","SEO Friendly");

	if( !(in_array('mod_rewrite', apache_get_modules())) ) {
		local_html_result(false,"ใช้งานไม่ได้::l::Disabled");
	} else {
		local_html_result(true,"ใช้งานได้::l::Enabled");
	}
}
		/////////////////////////
	
local_html_head("สามารถเชื่อมโยงไปยัง ULIBM Master site::l::Enable to connect to ULIBM Master site","","ดาวน์โหลดไฟล์, USIS, ULIB Catalog::l::File downloading, USIS, ULIB Catalog");
$searchuri=getval("SYSCONFIG","ulibmasterurl")."/activateulib/sv/ulibmasterresp.php?".randid();

$ch = curl_init($searchuri);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/html')); 
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');

	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  $result=curl_exec($ch);
	  
	if( $result != "ulibmasterresp" ) {
		local_html_result(false,"ใช้งานไม่ได้::l::Disabled");
	} else {
		local_html_result(true,"ใช้งานได้::l::Enabled");
	}

////////////////////////


?><BR><BR>
<HR>
<?php  echo getlang("<B>หมายเหตุ</B> ระบบนี้ เป็นระบบการตรวจสอบว่าเซิร์ฟเวอร์เครื่องนี้มีฟังก์ชันครบถ้วนตามที่ระบบต้องการหรือไม่ 
หากฟังก์ชันต่าง ๆ ไม่ครบอาจทำให้ใช้งานโปรแกรมได้ไม่ครบทุกฟังก์ชัน<BR>
<U>วิธีแก้ไขหากมีฟังก์ชันไม่ครบถ้วน</U>: ปรับแก้ที่เครื่องเซิร์ฟเวอร์ของท่าน (ไม่เกี่ยวกับตัวโปรแกรม ULIB)
::l::<B>Note</B> This page is a Functions checker, <BR>
if your server disabled some functions 
ULIB might work incorrectly in some modules.<BR>
If some function unavailable on your server? -- Please upgrade your web server not ULIB!
"); ?>

</TD>
</TR>
</TABLE><BR><?php 
foot();
?>