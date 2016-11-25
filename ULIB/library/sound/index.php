<?php 
	; 
		
        include ("../../inc/config.inc.php");
		head();
		$_REQPERM="mainmenu";
        mn_lib();
?><br />
<br />

<table width=400 align=center>
<tr ><td class=table_head><?php  echo getlang("อีก 15 นาที จะงดให้บริการยืมคืน::l::Close circulation counter in 15 minutes");?></td>
</tr><tr><td class=table_td>
<!-- <OBJECT id="VIDEO" width="400" height="70" 
	CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6"
	type="application/x-oleobject">
		<PARAM NAME="URL" VALUE="1.mp3">
	<PARAM NAME="AutoStart" VALUE="False">
	<PARAM name="uiMode" value="mini">
	<PARAM name="PlayCount" value="1">
	<PARAM name="volume" value="90">
</OBJECT> -->
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="120" height="60" id="1" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="s1.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="s1.swf" quality="high" bgcolor="#ffffff" width="120" height="60" name="1" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
	</object>
</td></tr>
<tr ><td class=table_head><?php  echo getlang("งดให้บริการยืมคืน อีก 15 นาที จะปิดห้องสมุด::l::Circulation counter closed, Close in 15 minutes");?></td>
</tr><tr><td class=table_td>
<!-- <OBJECT id="VIDEO" width="400" height="70" 
	CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6"
	type="application/x-oleobject">
		<PARAM NAME="URL" VALUE="2.mp3">
	<PARAM NAME="AutoStart" VALUE="False">
	<PARAM name="uiMode" value="mini">
	<PARAM name="PlayCount" value="1">
	<PARAM name="volume" value="90">
</OBJECT> -->	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="120" height="60" id="1" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="s2.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="s2.swf" quality="high" bgcolor="#ffffff" width="120" height="60" name="1" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
	</object>
</td></tr>
<tr ><td class=table_head><?php  echo getlang("งดให้บริการ::l::Closed");?></td>
</tr><tr><td class=table_td>
<!-- <OBJECT id="VIDEO" width="400" height="70" 
	CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6"
	type="application/x-oleobject">
		<PARAM NAME="URL" VALUE="3.mp3">
	<PARAM NAME="AutoStart" VALUE="False">
	<PARAM name="uiMode" value="mini">
	<PARAM name="PlayCount" value="1">
	<PARAM name="volume" value="90">
</OBJECT> -->	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="120" height="60" id="1" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="s3.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="s3.swf" quality="high" bgcolor="#ffffff" width="120" height="60" name="1" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
	</object>
</td></tr>
</table><br />
<?php 
$dr="$dcrs/_tmp/libsound/";
if ($delll!="" && (strpos($delll,"..")==false)) {
	unlink($dr . stripslashes("$delll"));
}

if ($isupload!="") {

$newname=$_FILES['file']['name'];
// In PHP earlier then 4.1.0, $_FILES  should be used instead of $_FILES. 
//echo $_FILES['file']['name'] . "<BR>";


if (strlen($_FILES['file']['tmp_name'])!=0) { 
	$ext=explode('.',$_FILES['file']['name']);
	$pureext=strtolower($ext[count($ext)-1]);
	if ($pureext!="mp3" && $pureext!="mp3" && $pureext!="mp3" && $pureext!="mp3") {
		?><CENTER style="color: darkred;"><?php 
			echo "Not allow:".$pureext."<BR>";
		echo(getlang("อัพโหลดได้เฉพาะไฟล์เสียงเท่านั้น::l::Upload only sound files"));
		?></CENTER><?php 
	} else {
		copy($_FILES['file']['tmp_name'], "$dr" . $newname); 
	}
} else { 
   echo "Possible file upload attack. Filename: " . $_FILES['file']['name']; 
   echo "ท่านไม่ได้เลือกไฟล์";
	   die;
} 


//
}
?>
					  
					  <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                        <table align=center border=0 cordercolor=666666 cellpadding=1 cellspacing=0 ID=libmannuploadform>
                          <tr bgcolor="#FFFFFF"> 
                          <tr valign=middle bgcolor="#FFFFFF"> 
                            <td class=headsepper bgcolor=#FFFFFF><font color="#000000" face="MS Sans Serif"><?php  echo getlang("อัพโหลดไฟล์เสียง::l::Upload more sound files");?></font></td>
                            <td class=bodysepper> <font color="#000000"> 
                              <input type="file" name="file"> <input type="submit" name="Submit" value="   Upload   ">
                             <INPUT TYPE="hidden" name=isupload value=yes><br />
<?php  echo getlang("ห้ามอัพโหลดไฟล์ที่ชื่อไฟล์มีเครื่องหมายพิเศษ::l::Do not upload file with special sign in filename.");?>
                              <input type="hidden" name="MAX_FILE_SIZE" value="<?php  echo $_GLOBAL_UPLOADSIZE;?>">
                              </font></td>
                          </tr>
						  </table>
                      </form>
<br />
<?php 
html_libmann("librarysound","yes");
?><center><div align=center ID=libmannfilelist style="width: <?php  echo $_TBWIDTH;?>"><?php 
if ($handle = opendir($dr)) { 
   //echo "Directory handle: $handle\n"; 
   pagesection(getlang("เลือกไฟล์เสียงอื่น ๆ::l::Play more files"));
   /* This is the correct way to loop over the directory. */ 
	   $i=1;
   echo "<TABLE width=700 align=center>
   <TR class=table_head>
	<TD > File name</TD>
	<TD width=50> - </TD>
   </TR>";
   $i=0;
   while (false !== ($file = readdir($handle))) { 
	   if ($file!="." && $file !=".." && $file !="import" && !is_dir("$dcrs/_tmp/libsound/$file")) {
		   $i++;
		   $fsize=filesize("$dcrs/_tmp/libsound/$file");
		   echo "<tr><TD >";
		   ?><script language="JavaScript" src="audio-player.js"></script>
<object type="application/x-shockwave-flash" data="player.swf" id="audioplayer<?php  echo $i;?>" height="24" width="290">
<param name="movie" value="player.swf">
<param name="FlashVars" value="playerID=audioplayer1&soundFile=<?php  echo $dcrURL?>_tmp/libsound/<?php  echo $file;?>">
<param name="quality" value="high">
<param name="menu" value="false">
<param name="wmode" value="transparent">
</object><BR><?php 
		   echo "&nbsp;&nbsp;&nbsp;$i.  $file (" .number_format($fsize/1024). "  KBytes / ".number_format(($fsize/1024)/1024,2)." MB ) </TD><TD ><A HREF=\"index.php?delll=$file\" onclick=\"return confirm('".getlang("กรุณายืนยัน::l::Deletion confirmation")."');\" ><IMG SRC='../../neoimg/Delete.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle>".getlang("ลบ::l::Delete")." </A>"; 

			echo "</TD></tr>\n";

			$i=$i+1;
	   }
   } 
   echo "
   </TABLE>";
   closedir($handle); 
   if ($i==1) {
	  echo "<CENTER>- ".getlang("ไม่พบไฟล์เสียงอื่น ๆ::l::No other files")." -</CENTER> ";
   }
}
?></div></center><?php 
				foot();
?>