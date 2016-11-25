<TABLE <?php  echo $subtablehtmltd;?> >
<TR>
	<TD class=table_head colspan=3><?php 
echo getlang("ส่วนเสริมที่ติดตั้ง::l::Installed Addons");
?></TD>
</TR>
<?php 
$adddir=$dcrs."_addons";
if ($handle = opendir($adddir)) {
   //rsort($handle);
   $sorteddirs=Array();
    while (false !== ($file = readdir($handle))) {
      $sorteddirs[]=$file;
    }
    sort($sorteddirs);
    @reset($sorteddirs);
      while (list($sorteddirsk,$file)=each($sorteddirs)) {
		//echo ($adddir."/$file");
		if (is_dir($adddir."/$file")) {
			//echo "$file\n";
			if (substr($file,0,1)==".") {
				continue;
			}
			if (substr($file,0,1)=="_") {
				continue;
			}
			//echo "$file\n";
			$chk=tmq("select * from addons where classid='$file' ");
			@include("$adddir/$file/info.php");
			$addon_name=getlang($addon_name);
			if (tnr($chk)==0) {
				//install module
				@include("$adddir/$file/install.php");
				tmq("delete from addons where classid='$file' ");
				tmq("insert into addons set classid='$file',name='".addslashes($addon_name)."' , dtinstall='$now' , installby='$useradminid'  ");
				if ($addon_name=="") {
					$addon_name=getlang("ไม่พบชื่อโมดุล::l::Module name not found")."[$file]";
				}
				$addon_execat=explode(",",$addon_execat);
				$addon_execat=arr_filter_remnull($addon_execat);
				@reset($addon_execat);
				tmq("delete from  addons_exec where classid='$file' ");
				while (list($k,$v)=each($addon_execat)) {
					tmq("insert into  addons_exec set classid='$file', location='$v' ");
				}
			}
	$addonchk=tmq("select * from addons where classid='$file' ");
	$addonchk=tfa($addonchk);
   if ($addonchk[disabled]=="yes")  {
		continue;
	}
				?><TR>
	<td class="table_td" width="16" style="background-color:#EEEEEE; width: 16"><img src="<?php  echo $dcrURL;?>_addons/<?php  echo $file;?>/logo.png"  width=16 height=16 align="absmiddle"></td>
	<td width="100%" style="background-color: rgb(249, 249, 249); " onmouseover="this.style.backgroundColor='#e5e5e5' " onmouseout="this.style.backgroundColor='#f9f9f9' " 
	onmouseup="this.style.backgroundColor='#f9f9f9' " onmousedown="this.style.backgroundColor='orange' " class="table_td">
	<?php 
	if (library_gotpermission("manulibaddon") ||   
			editperm_chk("ULIBADDON:$file","","manulibaddon")) {
		?><a HREF="<?php 
			echo $dcrURL."_addons/$file/index.php" ;

			?>"
			style="font-size:16px;width: 100%; display: block;"><?php  echo $addon_name?></a><?php 
	} else {
		?><font style="font-size:16px;width: 100%; display: block; color: #595959;" onclick="alert('<?php  echo getlang("คุณไม่มีสิทธิ์ใช้ส่วนเสริมนี้::l::You have no permission to use this addons");?>')"><?php  echo $addon_name?></font><?php 
	}
		?></td></TD>
	<td class="table_td" width="16" style="background-color:#EEEEEE; width: 16"><?php 

	if (!library_gotpermission("manulibaddon")) {
		echo "&nbsp;";
	} else {
		?><A HREF="../_addons/permission.php?permid=<?php  echo $file;?>"><IMG SRC="../neoimg/menuicon/configure16.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="<?php  echo getlang("จัดการสิทธิ์::l::Manage Permission");?>"></A><?php 
	}
				?></td>

</TR><?php 
		}
	}
	closedir($handle);
}

//disabled addons
if ($handle = opendir($adddir)) {
    while (false !== ($file = readdir($handle))) {
		//echo ($adddir."/$file");
		if (is_dir($adddir."/$file")) {
			//echo "$file\n";
			if (substr($file,0,1)==".") {
				continue;
			}
			if (substr($file,0,1)=="_") {
				continue;
			}
			//echo "$file\n";
			$chk=tmq("select * from addons where classid='$file' ");
			@include("$adddir/$file/info.php");
			$addon_name=getlang($addon_name);

	$addonchk=tmq("select * from addons where classid='$file' ");
	$addonchk=tfa($addonchk);
	if ($addonchk[disabled]!="yes")  {
		continue;
	}
				?><TR>
	<td class="table_td" width="16" style="background-color:#EEEEEE; width: 16"><img src="<?php  echo $dcrURL;?>_addons/<?php  echo $file;?>/logo.png"  width=16 height=16 align="absmiddle"></td>
	<td width="100%" style="background-color: rgb(249, 249, 249); " onmouseover="this.style.backgroundColor='#e5e5e5' " onmouseout="this.style.backgroundColor='#f9f9f9' " 
	onmouseup="this.style.backgroundColor='#f9f9f9' " onmousedown="this.style.backgroundColor='orange' " class="table_td">
	<?php 
		?><font
			style="font-size:13px;width: 100%; color: #444444; font-weight: bold;"><?php  echo $addon_name?></font> <?php 

			echo "<FONT class=smaller2>&nbsp;&nbsp;&nbsp;".getlang("ถูกปิดการใช้งาน::l::Disabled")."</FONT>";

		?></td></TD>
	<td class="table_td" width="16" style="background-color:#EEEEEE; width: 16"><?php 

	if (!library_gotpermission("manulibaddon")) {
		echo "&nbsp;";
	} else {
		?><A HREF="../_addons/permission.php?permid=<?php  echo $file;?>"><IMG SRC="../neoimg/menuicon/configure16.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="<?php  echo getlang("จัดการสิทธิ์::l::Manage Permission");?>"></A><?php 
	}
				?></td>

</TR><?php 
		}
	}
	closedir($handle);
}

?>
</TABLE>