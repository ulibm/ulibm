<?php 
;
include("../inc/config.inc.php");
//print_r($_SESSION);
$bkfilename="backup-remote.sql";
$path=$path . "../_output/";

if ($command=="remotebackup") {

filelogs("OperateRemoteBackup",thaidatestr(time()),"BACKUPLOG-remote");


    flush();
    if (!is_dir($path))
        mkdir($path, 0777);
    chmod($path, 0777);
    if (file_exists($path . "$bkfilename"))
        {
		unlink($path . "$bkfilename");
        }


        $cur_time=date("Y-m-d H:i");
        $tables=tmq("show tables");
        $num_tables=@tmq_num_rows($tables);

		//print_r($forceskipdb);
        $i=0;
	$onlytable[]="media";
	$onlytable[]="media_mid";
	$onlytable[]="member";

while ($i < $num_tables) {
	$newfile="";
	$table = tmq_tablename($tables, $i);
	$i++;
	if (in_array ($table,$onlytable)) {
		echo "<IMG SRC='../neoimg/Green.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='' align=absmiddle> Operating ... $table";
		$newfile.=get_def($dbname, $table);
		$newfile.="\n\n";
		$newfile.=get_content($dbname, $table);
		$newfile.="\n\n";
		fso_file_write($path . "$bkfilename","a",$newfile);
		echo " <I>done</I>.<BR>";
	}

}

	$gz = gzopen($path . "$bkfilename.gz",'w9');
	gzwrite($gz, file_get_contents($path . "$bkfilename"));
	gzclose($gz);

	echo "<HR><A HREF='index.php?command=viewinfo'>viewinfo</A>";
	die;
}
if ($command=="viewinfo") {
	if (file_exists($path . "$bkfilename")) {
		echo "file found : size=".number_format(filesize($path . "$bkfilename")/1024,2)."kb";
		echo "/ ".number_format((filesize($path . "$bkfilename")/1024)/1024,2)."mb";
		echo "<BR>since".ymd_datestr(filectime($path . "$bkfilename")) ." - ".ymd_ago(filectime($path . "$bkfilename"));
		echo "<HR>";
		echo "GZ file found : size=".number_format(filesize($path . "$bkfilename.gz")/1024,2)."kb";
		echo "/ ".number_format((filesize($path . "$bkfilename.gz")/1024)/1024,2)."mb";
		echo "<BR>GZ since".ymd_datestr(filectime($path . "$bkfilename.gz")) ." - ".ymd_ago(filectime($path . "$bkfilename.gz"));
	} else {
		echo "never remote backup";
	}
	echo "<HR>
	<A HREF='index.php?command=remotebackup'>backupnow</A>
	<A HREF='../_output/$bkfilename'>get backup</A>
	<A HREF='../_output/$bkfilename.gz'>get gz</A>
	
	";
	die;
}

head();

$_REQPERM="fullbackup";
mn_lib("fullbackup");

    //echo $dbname;

    $page=explode("/", getenv(SCRIPT_NAME));
    $n=count($page) - 1;
    $page=$page[$n];
    $page=explode("\.", $page, 2);
    $extension=$page[1];
    $page=$page[0];
    $script="$page.$extension";
    $base_url="http://" . $SERVER_NAME;
    $directory=$HTTP_SERVER_VARS[PHP_SELF];
    $script_base="$base_url$directory";
    $base_path=$HTTP_SERVER_VARS[PATH_TRANSLATED];
    $root_path_www=$HTTP_SERVER_VARS[DOCUMENT_ROOT];
    $remove_end=strrchr($root_path_www, "/");
    $root_path=@str_replace("$remove_end", '', $root_path_www);
    $url_base="$base_url$directory";
    $url_base=str_replace("$script", '', "$HTTP_SERVER_VARS[PATH_TRANSLATED]");
?>

<BODY BGCOLOR = "#F4F4F4">

    <CENTER>

        <BR>

<?php pagesection(getlang("สำรองข้อมูล::l::Backup"));?>
        <B><?php  echo getlang("ระบบพร้อมแล้วสำหรับการสำรองข้อมูล::l::System are ready to backup"); ?>
        <BR><?php  echo getlang("กรุณาคลิกปุ่มด้านล่างเพื่อดำเนินการ::l::Click button below to start."); ?></B>

        <BR>

        <FORM NAME = "dobackup" METHOD = "post" ACTION = "backup.php" onsubmit="chk(this)";>

            <CENTER>

                <INPUT NAME = "dbhost" TYPE = "hidden" VALUE = "localhost" SIZE = "37" MAXLENGTH = "100">
				<INPUT NAME = "dbuser" TYPE = "hidden" VALUE = "<?php  echo $user; ?>" SIZE = "37" MAXLENGTH = "100">
				<INPUT NAME = "dbpass" TYPE = "hidden" VALUE = "<?php  echo $passwd; ?>" SIZE = "37" MAXLENGTH = "100">
				<INPUT NAME = "dbname" TYPE = "hidden" VALUE = "<?php  echo $dbname;?>" SIZE = "37" MAXLENGTH = "100">
				<INPUT NAME = "path" TYPE = "hidden" VALUE = "<?php  echo "$url_base"; ?>" SIZE = "37" MAXLENGTH = "100">

                <P>

                    <CENTER>

					<!-- <label><INPUT TYPE="radio" NAME="bktype" value="light" style="border: 0px"> <?php  echo getlang("เฉพาะข้อมูลสำคัญ (รวดเร็ว)::l::Only very important data (fast)"); ?></label><BR> -->
					<label><INPUT TYPE="radio" NAME="bktype" value="full" style="border: 0px" checked> <?php  echo getlang("ข้อมูลทั้งหมด ::l::All data"); ?></label><BR>
					<label><INPUT TYPE="radio" NAME="bktype" value="MAX" style="border: 0px" > <?php  echo getlang("สำรองโฟลเดอร์โปรแกรม $dcr ::l::Entire $dcr Directory"); ?></label><BR>
					<BR>
                        <INPUT NAME = "send" TYPE = "submit" VALUE = " <?php  echo getlang("เริ่มการสำรองข้อมูล::l::Start Backup precess"); ?> "  id=sumiter1><br>
					<a href="backup_hist.php"><?php  echo getlang("ประวัติการสำรองข้อมูล::l::Backup History"); ?></a>
						</CENTER></P>

        </FORM>
<SCRIPT LANGUAGE="JavaScript">
        <!--
        function chk(wh) {
			wh.send.disabled=true;
			wh.send.value=" <?php  echo getlang("กรุณารอสักครู่ ระบบกำลังทำการสำรองข้อมูล::l::Please while (backing-up your DB)"); ?> "
		}
        //-->
        </SCRIPT>
<?php ?>
<?php 
function local_hash($wh) {

	?>			<nobr class=smaller style="color:gray">SHA1=[<?php  echo sha1_file("../_output/$wh");?>]<BR>
			<nobr class=smaller style="color:gray">MD5=[<?php  echo md5_file("../_output/$wh");?>]<BR><?php 
}

if ($delfull=='yes') {
	if (file_exists("../_output/backup-full.sql")) {
		unlink("../_output/backup-full.sql");
		@unlink("../_output/backup-full.sql.gz");
		echo "<H1><FONT  COLOR=gray>".getlang("ทำการลบข้อมูลเรียบร้อยแล้ว::l::Data Erased!")."</FONT></H1>";
	} else {
		echo "<H2><FONT  COLOR=gray>".getlang("ไฟล์ได้ถูกลบไปแล้ว::l::Data already erased!")."</FONT></H2>";
	}
}
if ($dellight=='yes') {
	if (file_exists("../_output/backup-light.sql")) {
		unlink("../_output/backup-light.sql");
		@unlink("../_output/backup-light.sql.gz");
		echo "<H1><FONT  COLOR=gray>".getlang("ทำการลบข้อมูลเรียบร้อยแล้ว::l::Data Erased!")."</FONT></H1>";
	} else {
		echo "<H2><FONT  COLOR=gray>".getlang("ไฟล์ได้ถูกลบไปแล้ว::l::Data already erased!")."</FONT></H2>";
	}
}
if ($delmax=='yes') {
	if (file_exists("../_output/maxbackup.tgz")) {
		unlink("../_output/maxbackup.tgz");
		@unlink("../_output/maxbackup.tgz.tmp");
		echo "<H1><FONT  COLOR=gray>".getlang("ทำการลบข้อมูลเรียบร้อยแล้ว::l::Data Erased!")."</FONT></H1>";
	} else {
		echo "<H2><FONT  COLOR=gray>".getlang("ไฟล์ได้ถูกลบไปแล้ว::l::Data already erased!")."</FONT></H2>";
	}
}
?>
<TABLE width=400 align=center>
			<TR>
				<TD><?php 

		if (file_exists("../_output/backup-full.sql")) {
		pagesection(getlang("ข้อมูลการสำรองข้อมูลครั้งล่าสุด::l::Last Backup Information"));
	?>
			<?php 	echo getlang("ขนาดไฟล์=::l::File size=") . number_format(filesize("../_output/backup-full.sql")/1024)."KB<BR>";
			 ?>
<B><A HREF = "get.php?mode=full" target = _blank>
					 <IMG SRC="../neoimg/Down.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle > 
					 <?php  echo getlang("ดาวน์โหลดไฟล์ข้อมูล::l::Download backup file"); ?></A></B> 
					[<?php  echo getlang("คลิกขวาแล้วเลือก::l::Right-click then choose"); ?> Save Target As....]<BR>
       
		<?php if (file_exists("../_output/backup-full.sql.gz")) {?>
		<B><IMG SRC="../neoimg/Down.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle > <A HREF = "get.php?mode=full&iszip=.gz" target = _blank><?php  echo getlang("ดาวน์โหลดไฟล์ข้อมูล::l::Download backup file"); ?></A></B> (<?php echo getlang("บีบอัดแล้ว::l::Compressed")?>)<BR>
		<?php  local_hash("backup-full.sql.gz"); ?>
			<?php 	//echo getlang("ขนาดไฟล์=::l::File size=") . number_format(filesize("../_output/backup-full.sql.gz")/1024)."KB<BR>";
			 ?>
		<?php }?>
		<IMG SRC="../neoimg/Delete.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle >  <a href="index.php?delfull=yes">
					<B><?php  echo getlang("ลบไฟล์นี้::l::Delete this file"); ?></B></A><BR>
		<?php 
				
					$lastbackup=floor(barcodeval_get("lastbackup-full-date"));
					if ($lastbackup=="0") {
						echo "<FONT  COLOR=red>".getlang("ยังไม่เคยทำการสำรองข้อมูล::l::No previous backup recorded")."!</FONT>";
					} else {
						echo "<FONT  COLOR=darkgreen>".getlang("สำรองข้อมูลครั้งสุดท้ายเมื่อ::l::Last backup")." ".thaidatestr($lastbackup)." ".ymd_ago($lastbackup)."</FONT>";
					}
				
	}
	
	echo "";
	/*
			if (file_exists("../_output/backup-light.sql")) {
		pagesection(getlang("ข้อมูลการสำรองข้อมูลแบบรวดเร็วครั้งล่าสุด::l::Last Light-Backup Information"));
?>
			<?php 	echo getlang("ขนาดไฟล์=::l::File size=") . number_format(filesize("../_output/backup-light.sql")/1024)."KB<BR>";
			 ?>
<B><A HREF = "get.php?mode=light" target = _blank>
					<IMG SRC="../neoimg/Down.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle > <?php  echo getlang("ดาวน์โหลดไฟล์ข้อมูล::l::Download backup file"); ?></A></B> 
					[<?php  echo getlang("คลิกขวาแล้วเลือก::l::Right-click then choose"); ?> Save Target As....]<BR>

		<?php if (file_exists("../_output/backup-light.sql.gz")) {?>
		<B><IMG SRC="../neoimg/Down.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle > <A HREF = "get.php?mode=light&iszip=.gz" target = _blank><?php  echo getlang("ดาวน์โหลดไฟล์ข้อมูล::l::Download backup file"); ?></A></B> (<?php echo getlang("บีบอัดแล้ว::l::Compressed")?> )<BR>
			<?php  local_hash("backup-light.sql.gz"); ?>
			<?php //	echo getlang("ขนาดไฟล์=::l::File size=") . number_format(filesize("../_output/backup-light.sql.gz")/1024)."KB<BR>";
			 ?>
		<?php }?>
		<IMG SRC="../neoimg/Delete.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle >  <a href="index.php?dellight=yes">
					<B><?php  echo getlang("ลบไฟล์นี้::l::Delete this file"); ?></B></A><BR>
		<?php 
				
					$lastbackup=floor(barcodeval_get("lastbackup-light-date"));
					if ($lastbackup=="0") {
						echo "<FONT  COLOR=red>".getlang("ยังไม่เคยทำการสำรองข้อมูล::l::No previous backup recorded")."!</FONT>";
					} else {
						echo "<FONT  COLOR=darkgreen>".getlang("สำรองข้อมูลครั้งสุดท้ายเมื่อ::l::Last backup")." ".thaidatestr($lastbackup)." ".ymd_ago($lastbackup)."</FONT>";
					}
				
	}*/

		echo "";
			if (file_exists("../_output/maxbackup.tgz")) {
		pagesection(getlang("การสำรองข้อมูลทั้งโฟลเดอร์::l::Last Folder Backup Information"));
?>
			<?php 	echo getlang("ขนาดไฟล์=::l::File size=") . number_format((filesize("../_output/maxbackup.tgz")/1024)/1024)."MB<BR>";
			 ?>
<B><A HREF = "get.php?mode=MAX" target = _blank>
					<IMG SRC="../neoimg/Down.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle > <?php  echo getlang("ดาวน์โหลดไฟล์ข้อมูล::l::Download backup file"); ?></A></B> 
					[<?php  echo getlang("คลิกขวาแล้วเลือก::l::Right-click then choose"); ?> Save Target As....]<BR>

<?php  local_hash("maxbackup.tgz"); ?>
			<?php //	echo getlang("ขนาดไฟล์=::l::File size=") . number_format(filesize("../_output/maxbackup.tgz")/1024)."KB<BR>";
			 ?>
		<IMG SRC="../neoimg/Delete.gif" WIDTH="16" HEIGHT="16" BORDER="0" align=absmiddle >  <a href="index.php?delMAX=yes">
					<B><?php  echo getlang("ลบไฟล์นี้::l::Delete this file"); ?></B></A><BR>
		<?php 
				
					$lastbackup=floor(barcodeval_get("lastbackup-MAX-date"));
					if ($lastbackup=="0") {
						echo "<FONT  COLOR=red>".getlang("ยังไม่เคยทำการสำรองข้อมูล::l::No previous backup recorded")."!</FONT>";
					} else {
						echo "<FONT  COLOR=darkgreen>".getlang("สำรองข้อมูลครั้งสุดท้ายเมื่อ::l::Last backup")." ".thaidatestr($lastbackup)." ".ymd_ago($lastbackup)."</FONT>";
					}
				
	}

				?></TD>
			</TR>
			
         </TABLE>
       <center>  
         <?php 
$cl=barcodeval_get("activateulib-status");
if ($cl=="registered") {
	?><div align=center><iframe src="backup.php?push=yes&picker=<?php  echo randid();?>" align=absmiddle FRAMEBORDER="no" BORDER=0
 SCROLLING=NO width=420 height=80 style="float:center"></iframe></div><?php 
}
		?>
<BR>
<BR><BR>
<?php 
	foot();
?>