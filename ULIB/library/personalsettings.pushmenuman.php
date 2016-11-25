<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="mainmenu";
mn_lib();
loginchk_lib();
/*
CREATE TABLE  `pushmenu` (
 `id` DOUBLE NOT NULL AUTO_INCREMENT PRIMARY KEY ,
 `loginid` VARCHAR( 255 ) NOT NULL ,
 `ordr` DOUBLE NOT NULL ,
 `perm` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;
*/

if ($loadbasicmenu=="yes") {
   tmq("delete from pushmenu where loginid='$useradminid' ");
   tmq("insert into pushmenu set loginid='$useradminid' ,perm='circulation' ");
   tmq("insert into pushmenu set loginid='$useradminid' ,perm='DBbook' ");
   tmq("insert into pushmenu set loginid='$useradminid' ,perm='MembeDatabase' ");
   tmq("insert into pushmenu set loginid='$useradminid' ,perm='quickstat' ");
   tmq("insert into pushmenu set loginid='$useradminid' ,perm='serialsmodule-manageserial' ");
   tmq("insert into pushmenu set loginid='$useradminid' ,perm='barcodemenu' ");
   
}

$ordrid=floor($ordrid);
if ($ordr!="" && $ordrid!=0) {
	//echo "here";
	$a="index.php";
	$tbl="pushmenu";
	$condition="loginid";
	$conditionval="$useradminid";
	$field="ordr";
	$primary="id";
	$id="$ordrid";
	$direct="$ordr";
	ordr();
}
$delete=trim($delete);
if ($delete!="") {
	tmq("delete from pushmenu where loginid='$useradminid' and perm='$delete'  ");
}
$add=trim($add);
if ($add!="") {
	?><?php 
		$chk=tmq("select * from pushmenu where loginid='$useradminid' and perm='$add'  ");
		if (tnr($chk)==0) {
			tmq("insert into pushmenu set
			loginid='$useradminid',
			ordr=0,
			perm='$add'
			");
		}
}
?><style>
BODY {
	background-image: none!important;
}
</style>
<?php 
pagesection("จัดการเมนูด่วน::l::Manage Push Menu");
echo "<table align=center width=$_TBWIDTH class=table_border>";

$s=tmq("select * from pushmenu where loginid='$useradminid' order by ordr ",false);
if (tnr($s)==0) {
	echo "<br><br><br><center><font style='font-size: 18px; color: #434d67;font-weight: bold;'>";
	echo getlang("ยังไม่ได้เพิ่มเมนูใดไว้::l::No menu added.");
	echo "</font></center>";
}
while ($r=tfa($s)) {
		$s2ql="select * from library_modules  where  code='$r[perm]' and isshow='yes' ";
		$s2=tmq($s2ql,false);
		//echo tnr($s2);
		$r2=tfa($s2);
		//printr($r2);
								$r2[name]=str_replace('[ROOMWORD]',$_ROOMWORD,$r2[name]);
								$r2[name]=str_replace('[FACULTYWORD]',$_FACULTYWORD,$r2[name]);

								$url="";
								$thisperm2=library_gotpermission($r2[code]);
								if ($thisperm2==false ) {
									continue;
								}
								if ($thisperm2==true && $r2[url]!="") {
									$r2[url]=str_replace('[dcr]',$dcrURL,$r2[url]);
									$dcrURL2=trim($dcrURL,'/');
									$r2[url]=str_replace($dcrURL2.'//',$dcrURL2.'/',$r2[url]);
									$url="<A HREF='$r2[url]' style='font-size:16px;width: 100%; display: block;' target=_blank>  ";
								}
								if ($r2[url]=="" ) {
									$url="<b style='color: #818181; font-weight: normal;'  >&nbsp;";
								}




								echo "
								<TR class=table_dr>
								<TD class=table_td width=24 style='background-color:#EEEEEE; width: 24' ><img src='$dcrURL/neoimg/menuicon/$r2[icon]' align=absmiddle width=24 height=24> </TD>
												<TD width=100%
									style='background-color:#f9f9f9;' onmouseover=\"this.style.backgroundColor='#e5e5e5' \" 
									onmouseout=\"this.style.backgroundColor='#f9f9f9' \"
									onmouseup=\"this.style.backgroundColor='#f9f9f9' \"
									onmousedown=\"this.style.backgroundColor='orange' \" class=table_td>
$url";
if ($r2[isbold]=="yes") { echo "<B>";}
echo stripslashes(getlang($r2[name]));
if ($r2[isbold]=="yes") { echo "</B>";}
echo "</A>";
								echo "</TD>
								<td width=32>";
?><table >
<tr>
	<td><a href="personalsettings.pushmenuman.php?ordr=up&ordrid=<?php  echo $r[id];?>"><img src="../neoimg/Up.gif" width="16" height="16" border="0" alt=""></a></td>
	<td><a href="personalsettings.pushmenuman.php?delete=<?php  echo $r2[code];?>" onclick="return confirm('Confirm delete?');"><img src="../neoimg/Delete.gif" width="16" height="16" border="0" alt=""></a></td>
</tr>
<tr>
	<td><a href="personalsettings.pushmenuman.php?ordr=down&ordrid=<?php  echo $r[id];?>"><img src="../neoimg/Down.gif" width="16" height="16" border="0" alt=""></a></td>
	<td></td>
</tr>
</table><?php 
								echo "</td>
											</TR>";

}
echo "</table>";

?><center>
<BR>
<BR>
<a href="<?php echo $dcrURL;?>library/personalsettings.php" class=a_btn target=_top><?php echo getlang("ตั้งค่าส่วนบุคคล::l::Personal Settings"); ?></a><BR>
<a href="<?php echo $dcrURL;?>library/personalsettings.pushmenuman.php?loadbasicmenu=yes" class='a_btn smaller2' target=_self><?php echo getlang("โหลดเมนูพื้นฐาน::l::Load basic menu"); ?></a><BR>

</center><?php
foot();
?>