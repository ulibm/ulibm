<?php 

?>
  <table width="<?php  echo $_TBWIDTH?>" border="0" cellspacing="0" cellpadding="0" align=center>
    <tr>
      <td>
	  
	  
    <table width="100%" border="0" cellspacing="1" cellpadding="3" 
bgcolor="#E2E2E2" background="">
          <tr>
            <td ><b><font face="MS Sans Serif" size="5" 
color="000000" >&nbsp;<font color="#FF9900" class=stupidmenu>
<?php  echo getlang("ใช้งานส่วนเสริม::l::Addon System") ; ?>
              </font></font> <?php  echo get_libsite_name($LIBSITE);?></b> <?php 
	if (library_gotpermission("switchownlibsite")) {
		echo "<FONT class=smaller2>[<A HREF='$dcrURL"."library/mainadmin.php?switchlibsite=yes' class=smaller2>".getlang("เลือก::l::Set")."</A>]</FONT>";
	}
	?></td>
	<TD align=right><nobr><span style="color: 999999;">
<img src='<?php  echo $dcrURL?>neoimg/userlock.png' align=absmiddle>
<?php  echo get_library_name($useradminid,true);?>
</span>&nbsp;&nbsp;</nobr></TD>
          </tr>
        </table>
		
		
      </td>


    </tr>
<TR bgcolor=f1f1f1><td>


<TABLE width="<?php  echo $_TBWIDTH?>" border=0 bgcolor=f1f1f1 cellpadding=2 cellspacing=0>
<TR align=center>
<td align=left style="padding-left: 20px;"><nobr><font style='font-size: 12px;color:#39537D'>
<?php 
$url=$dcrURL."/_addons/$_REQPERM/";
	$url="<A HREF='index.php' style='font-size: 12px;color:#39537D'>";
	$url=str_replace('//','/',$url);
	$url=str_replace('http:/','http://',$url);
	echo "<img src='$dcrURL/_addons/$_REQPERM/logo.png' align=absmiddle width=16 height=16 >&nbsp;$url".getlang($addon_name)."</A> ";

?></font></nobr>
</td>
<td width=450  background="/<?php echo "$dcr"; ?>/neoimg/menufade_1.png" style="background-repeat: no-repeat;background-position: top left; text-align:right; padding-right: 10px;" align=right>


<TABLE align=right border = "0" cellspacing = "0" cellpadding =0 >
<TR >

<?php 
  $PHP_SELF=str_replace('//','/',$PHP_SELF);
	//echo "$PHP_SELF";
	$homebtn=tmq("select * from library where UserAdminID='$useradminid'");
	$homebtn=tmq_fetch_array($homebtn);
	if ($homebtn[defmenu]!="") {
		$homebtn=tmq("select * from library_modules where code='$homebtn[defmenu]' ");
		$homebtn=tmq_fetch_array($homebtn);
		$spaththisfile=str_replace('[dcr]',$dcrs,$homebtn[url]);
		$spaththisfile=str_replace('//','/',$spaththisfile);
		$spaththisfile=trim($spaththisfile,'/');
		$homebtn[url]=str_replace('[dcr]',$dcrURL,$homebtn[url]);
		$svpath= $_SERVER[SCRIPT_FILENAME];
		$svpath = pathinfo($svpath);
		$svpath=trim($svpath["dirname"],'/');
		//echo "($spaththisfile!=$svpath)";
		if ($spaththisfile!=$svpath) {
			?><TD style='padding-right: 10px;'><A HREF="<?php  echo $homebtn[url]?>" target=_top><img src='<?php  echo $dcrURL?>neoimg/home.png' width=21 height=21 align=absmiddle ALT="<?php  echo getlang("หน้าหลักของคุณ::l::Your main menu") ." : ".getlang($homebtn[name]);?>" border=0></A></TD><?php 
		}
	}
	if ( $PHP_SELF !="/$dcr/library/mainadmin.php"	) {
?>

	<TD><img src='<?php  echo $dcrURL?>neoimg/media/roundedge-gray-left.png'></TD>
	<TD background='<?php  echo $dcrURL?>neoimg/media/roundedge-gray-right.png' style="background-repeat: no-repeat; background-position: top right; padding-right: 10px;padding-left: 4px;">
<a  href="/<?php echo "$dcr"; ?>/library/mainadmin.php" style="color:white;font-size:14px;font-weight:bold"><?php  echo getlang("เมนูหลัก::l::Menu"); ?></a> 
</TD>
<?php 
}	
?>
	<TD >&nbsp;</TD><?php 
	if (library_gotpermission("circulation")) {
?>
	<TD><img src='<?php  echo $dcrURL?>neoimg/media/roundedge-blue-left.png'></TD>
	<TD background='<?php  echo $dcrURL?>neoimg/media/roundedge-blue-right.png' style="background-repeat: no-repeat; background-position: top right; padding-right: 10px;padding-left: 4px;">
<a  href="/<?php echo "$dcr"; ?>/circulation/" style="color:white;font-size:14px;font-weight:bold"><?php  echo getlang("บริการยืมคืน::l::Circulations"); ?></a> 
</TD>
	<TD >&nbsp;</TD>
	<?php 
}	
?>
	<TD ><img src='<?php  echo $dcrURL?>neoimg/media/roundedge-red-left.png'></TD>
	<TD background='<?php  echo $dcrURL?>neoimg/media/roundedge-red-right.png' style="background-repeat: no-repeat; background-position: top right;padding-right: 10px;padding-left: 4px;">
<a  href="/<?php echo "$dcr"; ?>/library/logout.php"  style="color:white;font-size:14px;font-weight:bold;"><?php  echo getlang("ออกจากระบบ::l::Logout"); ?></a>

</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>


</td></tr>  
  </table>