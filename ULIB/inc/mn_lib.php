<?php 
function mn_lib() {
	global $loginadmin;
	global $useradminid;
	global $dcr;
	global $dcrURL;
	global $PHP_SELF;
	global $dcrs;
	global $LIBSITE;
	global $_REQPERM;
	global $_FACULTYWORD;
	global $_ROOMWORD;
	global $_TBWIDTH;
	loginchk_lib();
	//redir if defmenu and no mainmenu
	if ($_REQPERM=="mainmenu" && !library_gotpermission("mainmenu")) {
		$homebtn=tmq("select * from library where UserAdminID='$useradminid'");
		$homebtn=tmq_fetch_array($homebtn);
		if ($homebtn[defmenu]!="") {
			$homebtn=tmq("select * from library_modules where code='$homebtn[defmenu]' ");
			$homebtn=tmq_fetch_array($homebtn);
			$spaththisfile=str_replace('[dcr]',$dcrURL,$homebtn[url]);
			//$spaththisfile=str_replace('//','/',$spaththisfile);
			//$spaththisfile=trim($spaththisfile,'/');
			redir($spaththisfile); 
			die;
		}
	}

	if ($_REQPERM=="") {
		die("<B>mn_lib()</B> error: require \$_REQPERM;");
	}
	$rq=tmq("select * from library_modules where code='$_REQPERM' ");
	if (tmq_num_rows($rq)==0) {
		die("library_modules where code='$_REQPERM'");
	}
	$rq=tmq_fetch_array($rq); 
	$returnname=getlang($rq[name]);

	$rqc=tmq("select * from library_modules_cate where code='$rq[nested]' ");
	if (tmq_num_rows($rqc)==0) {
		die("library_modules_cate where code='$rq[nested]'");
	}
	$rqc=tmq_fetch_array($rqc);
	if (!library_gotpermission($_REQPERM)) {
		html_dialog("Security alert","คุณไม่มีสิทธิ์เข้าใช้งานส่วนนี้");
		die;
	}
	?>

<script src="<?php  echo $dcrURL; ?>js/jquery/1.4.2/jquery.min.js"></script>

  <table width="<?php  echo $_TBWIDTH?>" border="0" cellspacing="0" cellpadding="0" align=center >
    <tr>
      <td>

    <table width="100%" border="0" cellspacing="1" cellpadding="3" 
bgcolor="#E2E2E2">
          <tr>
            <td style="padding-top: 0px;"><b><font face="MS Sans Serif" size="5" 
color="000000" >&nbsp;<font color="#FF9900" class=stupidmenu>
<?php  echo getlang("ระบบเจ้าหน้าที่ห้องสมุด::l::Librarian System"); ?>
              </font></font> <?php  echo get_libsite_name($LIBSITE);?></b> <?php 
	if (library_gotpermission("switchownlibsite")) {
		echo "<FONT class=smaller2>[<A HREF='$dcrURL"."library/mainadmin.php?switchlibsite=yes' class=smaller2>".getlang("เลือก::l::Set")."</A>]</FONT>";
	}
	?></td>
	<TD align=right><nobr><span style="color: 999999;">
	<?php 
 if (barcodeval_get("personalsetting-o-usepushmenu-$useradminid")!="no") {
 if (strtolower(barcodeval_get("personalsetting-o-pushmenulocation-$useradminid"))!="menu bar") {
?>
<link rel="stylesheet" type="text/css" href="<?php  echo $dcrURL; ?>library/pushmenu/jPushMenu.css" />
<script src="<?php  echo $dcrURL; ?>library/pushmenu/jPushMenu.php"></script>

<!-- <button class="toggle-menu menu-left">Toggle Left Menu</button>
<button class="toggle-menu menu-left push-body">Toggle Left Menu Push</button> -->

<!-- Left menu element-->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" ID=ULIB_libNAV>
<table width=270 cellpadding=0 cellspacing=0 border=0 style="height: 100%">
<tr valign=top>
	<td bgcolor="white"><iframe ID="libpushmenu" name="libpushmenu" style="height: 100%;width: 250px; border: 0px solid white!important;;"></iframe></td>
	<td bgcolor="blue" width=20><button class="toggle-menu menu-left" style="width: 20px; height: 100%; border: black 0px solid; background-color: #415998; padding: 0px 0px 0px 0px;"></button>
</td>
</tr>
</table>
</nav>


<!--call jPushMenu, required-->
<script>
if (isiniframe()==false) {
	jQuery(document).ready(function($) {
		$('.toggle-menu').jPushMenu();
	});
} else {
	tmp=getobj("ULIB_libNAV");
	tmp.style.display='none';
}
</script><?php 

} else {
   ?>
   <iframe ID="libpushmenu" name="libpushmenu" style="display:none;"></iframe>
   <form>
   <select ID="libpushmenudropdown" style="width:100px; " onchange="self.location=(this.value)" >
   <option value=""><?php echo getlang("เมนูด่วน::l::Push Menu");?>
   <?php
   $s=tmq("select * from pushmenu where loginid='$useradminid' order by ordr ",false);
if (tnr($s)==0) {
	echo "<option style='color: red' value=''>";
	echo getlang("ยังไม่ได้เพิ่มเมนูใดไว้::l::No menu added.");
	echo "</option>";
}
while ($r=tfa($s)) {
	$s2ql="select * from library_modules  where  code='$r[perm]' and isshow='yes' ";
	$s2qls=tmq($s2ql);
	$s2qlr=tfa($s2qls);	
   $s2qlr[name]=str_replace('[ROOMWORD]',$_ROOMWORD,$s2qlr[name]);
   $s2qlr[name]=str_replace('[FACULTYWORD]',$_FACULTYWORD,$s2qlr[name]);
	$url="";
	$thisperm2=library_gotpermission($s2qlr[code]);
	if ($thisperm2==false ) {
		continue;
	}
	if ($thisperm2==true && $s2qlr[url]!="") {
		$s2qlr[url]=str_replace('[dcr]',$dcrURL,$s2qlr[url]);
		$dcrURL2=trim($dcrURL,'/');
		$s2qlr[url]=str_replace($dcrURL2.'//',$dcrURL2.'/',$s2qlr[url]);
		$url="$s2qlr[url]";
	}
	if ($s2qlr[url]=="" ) {
		$url="";
		continue;
	}   
   echo "<option style='color: #000022' value='$url'>";
	echo getlang($s2qlr[name]);
	echo "</option>";
}
	echo "<option style='color: darkblue' value='$dcrURL"."library/personalsettings.php'>";
	echo getlang(" -- ตั้งค่า ::l:: -- settings");
	echo "</option>";
	echo "<option style='color: darkblue' value='$dcrURL"."library/personalsettings.pushmenuman.php'>";
	echo getlang(" -- จัดการเมนู ::l:: -- manage saved menu");
	echo "</option>";

   
   ?>   
   </select>
   </form>
   <?php
}
	}
?>

<img src='<?php  echo $dcrURL?>neoimg/userlock.png' align=absmiddle>
<?php  echo get_library_name($useradminid,true);?>
</span>&nbsp;&nbsp;</nobr></TD>
          </tr>
        </table>
		
      </td>
    </tr>
<TR bgcolor=f1f1f1><td>
<TABLE width="<?php  echo $_TBWIDTH?>" border=0 bgcolor=f2f2f2 cellpadding=2 cellspacing=0>
<TR align=center>
<td align=left style="padding-left: 20px;"><nobr><font style='font-size: 12px;color:#39537D'>
<?php 
$url="";
if ( $rqc[isplayathead]!="no") {
	if ( $rqc[url]!="") {
		$rqc[url]=str_replace('[dcr]',$dcrURL,$rqc[url]);
		$url="<A HREF='$rqc[url]' style='font-size: 12px;color:#39537D'>";
	}
	$url=str_replace('//','/',$url);
	$url=str_replace('http:/','http://',$url);
	$url=str_replace('https:/','https://',$url);
	echo "<img src='$dcrURL/neoimg/menuicon/folder.png' align=absmiddle  width=16 height=16>&nbsp;$url".getlang($rqc[name])."</A> ";
}
$url="";
if ( $rq[url]!="") {
	$rq[url]=str_replace('[dcr]',$dcrURL,$rq[url]);
	$url="<A HREF='$rq[url]'  style='font-size: 12px;'>";
}
$url=str_replace('//','/',$url);
$url=str_replace('http:/','http://',$url);
$url=str_replace('https:/','https://',$url);
	$rq[name]=str_replace('[ROOMWORD]',$_ROOMWORD,$rq[name]);
	$rq[name]=str_replace('[FACULTYWORD]',$_FACULTYWORD,$rq[name]);
	$rq[name]=getlang($rq[name]);
	$len=40;
	if (mb_strlen($rq[name])>$len) {
		$rq[name]=mb_substr($rq[name],0,$len).'..';
	}
echo "<img src='$dcrURL/neoimg/menuicon/$rq[icon]' align=absmiddle width=16 height=16>&nbsp;$url".stripslashes($rq[name])."</A> ";
if ($url!="" && $_REQPERM!="mainmenu" && barcodeval_get("personalsetting-o-usepushmenu-$useradminid")!="no") {
	?><a href="<?php  echo $dcrURL?>library/pushmenu/index.php?add=<?php  echo $_REQPERM;?>" target="libpushmenu"><img src='<?php  echo $dcrURL?>library/pushmenu/pushmenuadd_dis.png' align=absmiddle border=0 TITLE="Add to Push Menu (Expandable Left Menu)" 
	onmouseover="this.src='<?php  echo $dcrURL?>library/pushmenu/pushmenuadd_over.png'; return true;"
	onmouseout="this.src='<?php  echo $dcrURL?>library/pushmenu/pushmenuadd_dis.png'; return true;"
	></a><?php 
}
?></font> <?php 
//libmann s
if (strtolower(barcodeval_get("personalsetting-o-hidelibmann-$useradminid")!="yes")) {
$libmann=tmq("select id from libmann where nested='$_REQPERM' ",false);
if (tnr($libmann)!=0) {
	?><a href="javascript:void(null);" onclick="libmannloader();"><img src="<?php echo $dcrURL;?>neoimg/help-icon.png" width="12" height="12" border="0" alt="" align=absmiddle></a>
	<script>
function loadJS(src, callback) {
    var s = document.createElement('script');
    s.src = src;
    s.async = true;
    s.onreadystatechange = s.onload = function() {
        var state = s.readyState;
        if (!callback.done && (!state || /loaded|complete/.test(state))) {
            callback.done = true;
            callback();
        }
    };
    document.getElementsByTagName('head')[0].appendChild(s);
}
function libmannloader() {
	loadJS('<?php  echo $dcrURL?>js/intro/loader.php?code=<?php  echo $_REQPERM?>', function() { 
		// put your code here to run after script is loaded
		libmannstartIntro()
	});
}
</script>
	<?php 
}
}
//libmann e
?></nobr>
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
			?><TD style='padding-right: 10px;'><A HREF="<?php  echo $homebtn[url]?>" target=_top><img src='<?php echo $dcrURL?>neoimg/home.png' width=21 height=21 align=absmiddle ALT="<?php  echo getlang("หน้าหลักของคุณ::l::Your main menu") ." : ".getlang($homebtn[name]);?>" border=0></A></TD><?php 
		}
	}
	if ( $PHP_SELF !="/$dcr/library/mainadmin.php"	) {
?>

	<TD><img src='<?php echo $dcrURL?>neoimg/media/roundedge-gray-left.png'></TD>
	<TD background='<?php echo $dcrURL?>neoimg/media/roundedge-gray-right.png' style="background-repeat: no-repeat; background-position: top right; padding-right: 10px;padding-left: 4px;" ID="MN_LIB_MAINSYSTEMLINK">
<a  href="/<?php echo "$dcr"; ?>/library/mainadmin.php<?php 
	if ($rqc[topcate]!="") {
		echo "#".$rqc[topcate];
	}	
	?>" style="color:white;font-size:14px;font-weight:bold"><?php  echo getlang("เมนูหลัก::l::Menu"); ?></a> 
</TD>
<?php 
}
?>
	<TD >&nbsp;</TD><?php 
	if (library_gotpermission("circulation")) {
?>
	<TD><img src='<?php echo $dcrURL?>neoimg/media/roundedge-blue-left.png'></TD>
	<TD background='<?php echo $dcrURL?>neoimg/media/roundedge-blue-right.png' style="background-repeat: no-repeat; background-position: top right; padding-right: 10px;padding-left: 4px;">
<a  href="/<?php echo "$dcr"; ?>/circulation/" style="color:white;font-size:14px;font-weight:bold"><?php  echo getlang("บริการยืมคืน::l::Circulations"); ?></a> 
</TD>
	<TD >&nbsp;</TD>
	<?php 
}
?>
	<TD ><img src='<?php echo $dcrURL?>neoimg/media/roundedge-red-left.png'></TD>
	<TD background='<?php echo $dcrURL?>neoimg/media/roundedge-red-right.png' style="background-repeat: no-repeat; background-position: top right;padding-right: 10px;padding-left: 4px;">
<a  href="<?php echo "$dcrURL"; ?>/library/logout.php"  style="color:white;font-size:14px;font-weight:bold;"><?php  echo getlang("ออกจากระบบ::l::Logout"); ?></a>

</TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>


</td></tr>  
  </table>
  <?php 
$minsscreensaver=barcodeval_get("personalsetting-o-minsscreensaver-$useradminid");
if ($minsscreensaver!="-1") {
	if (floor($minsscreensaver)==0) {
		$minsscreensaver=5;
	}
?>
<script language="javascript" src="<?php  echo $dcrURL?>js/idle.js" type="text/javascript"></script>
 <div style="background-color: black;height: 100%; width: 100%; min-height: 100%; min-width 100%; position: fixed; top: 0px; left: 0px; visible: none; text-align: center; display: none; z-index: 100" ID=idlescreensaver><center><br><br><br><br><img src="<?php  echo $dcrURL;?>_tmp/logo/_weblogo.png" border=0 width=261 height=66>.</center></div>
<script type="text/javascript">
<!--

			var awayCallback = function() {
				//console.log(new Date().toTimeString() + ": away");
				tmp=getobj("idlescreensaver");
				tmp.style.display="block";
			};

			var awayBackCallback = function(){
				//console.log(new Date().toTimeString() + ": back");
				tmp=getobj("idlescreensaver");
				tmp.style.display="none";
		};
			var onVisibleCallback = function(){
				tmp=getobj("idlescreensaver");
				tmp.style.display="none";
				//console.log(new Date().toTimeString() + ": now looking at page");
			};

			var onHiddenCallback = function(){
				tmp=getobj("idlescreensaver");
				tmp.style.display="block";
				//console.log(new Date().toTimeString() + ": not looking at page");
			};
			//this is one way of using it.
			
			var idle = new Idle();
			idle.onAway = awayCallback;
			idle.onAwayBack = awayBackCallback;
			idle.setAwayTimeout(<?php  echo floor($minsscreensaver)*1000*60?>);
			//idle.start(); [<?php  echo floor($minsscreensaver)?>]
			

//-->
</script>
<?php } // idle?>
<?php 
if (strtolower(barcodeval_get("personalsetting-o-keepalivesession-$useradminid"))=="yes") {
   ?>
   <iframe ID="keepaliveif" name="keepaliveif" style="display:none!important;" src="<?php echo $dcrURL;?>library/_keepalive.php"></iframe>
   <?php
}
	$now=time();
	tmq("delete from library_entermodule where dt<".($now-(60*60*24*60))); //60 days
	tmq("insert into library_entermodule set loginid='$useradminid',dt='$now',module='$_REQPERM' ");
	return $returnname;
}
?>