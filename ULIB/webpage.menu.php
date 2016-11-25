<?php 
if (barcodeval_get("webpage-o-isshowweblogodecis")=="yes") {
?>
		<TABLE width=200  >
<TR>
	<TD align=center><IMG SRC="./_tmp/logo/_weblogoicon.png" WIDTH="150" HEIGHT="150" BORDER="0" ></TD>
</TR>
</TABLE>
<?php 
} else {
	?><IMG SRC="./neoimg/spacer.gif" WIDTH="150" HEIGHT="5" BORDER="0" ><?php 
}
	?><div style="border-width: 1px;
		border-style: solid; border-color: #8F8F8F;  padding: 3px"
		><TABLE width=200  cellpadding=0 cellspacing=0 border=0>
<?php 
	if ($_ISULIBMASTER=="yes") {
		$ishide_menuadvsear=barcodeval_get("webpage-o-ishide_menuadvsear");	
		$ishide_menubasicsear=barcodeval_get("webpage-o-ishide_menubasicsear");	
		$ishide_menumemlogin=barcodeval_get("webpage-o-ishide_menumemlogin");	
		$ishide_menuusissearch=barcodeval_get("webpage-o-ishide_menuusissearch");	
		$allishidemainmenu="$ishide_menuusissearch$ishide_menuadvsear$ishide_menubasicsear$ishide_menumemlogin";
		if ($allishidemainmenu=="yesyesyesyes") {
			$hidemainmenu="yes";
		} else {
			$hidemainmenu="no";
		}
	} else {
		$ishide_menuadvsear=barcodeval_get("webpage-o-ishide_menuadvsear");	
		$ishide_menubasicsear=barcodeval_get("webpage-o-ishide_menubasicsear");	
		$ishide_menumemlogin=barcodeval_get("webpage-o-ishide_menumemlogin");	
		$allishidemainmenu="$ishide_menuadvsear$ishide_menubasicsear$ishide_menumemlogin";
		if ($allishidemainmenu=="yesyesyes") {
			$hidemainmenu="yes";
		} else {
			$hidemainmenu="no";
		}
	}
	//echo "[$allishidemainmenu]";

	if ($hidemainmenu!="yes") {
?>
<TR>
	<TD class=table_td >
<div class="arrowlistmenu">
	<!-- <h3 class="headerbar"><?php  echo getlang("เมนูหลัก::l::Main menu");?></h3> -->
	<ul>
	<li class=headerbar style='width:200'><font><?php  echo getlang("เมนูหลัก::l::Main menu");?></FONT></li>
<?php if ($ishide_menuadvsear!="yes") {?>
	<li><A HREF="index.php?setforcehpmode=advsearch"><IMG SRC="<?php echo $dcrURL?>neoimg/menuicon/normal.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php  echo getlang("ค้นหาข้อมูลแบบ Advance::l::Searching : Advance Search ");?> </A> </li>
<?php }?>
<?php if ($ishide_menubasicsear!="yes") {?>
	<li><A HREF="index.php?setforcehpmode=search"><IMG SRC="<?php echo $dcrURL?>neoimg/menuicon/normal.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php  echo getlang("ค้นหาข้อมูลแบบ Basic::l::Searching : Basic Search ");?> </A> </li>
<?php }?>
<?php if ($_ISULIBMASTER=="yes" && $ishide_menuusissearch!="yes") {?>
	<li><A HREF="./_USIS.php"><IMG SRC="<?php echo $dcrURL?>neoimg/menuicon/normal.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle>  <?php  echo getlang("ULIBM : Single search::l::ULIBM : Single search");?> </A> </li>
<?php }?>
<?php if ($ishide_menumemlogin!="yes") {?>
	<li><A HREF="./member/"><IMG SRC="<?php echo $dcrURL?>neoimg/menuicon/normal.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle>  <?php  echo getlang("สมาชิกล็อกอิน::l::Member login");?> </A> </li>
<?php }?>
	</ul>
</div>
</td></tr>
<?php 
	}	
	?>
<TR>
	<TD class=table_td >
	<div class="arrowlistmenu">
	<!-- <h3 class="headerbar"><?php  echo getlang("เมนูเว็บไซต์::l::website's menu");?></h3> -->
<ul>
<?php 

$mn=tmq("select * from webpage_menu where isshow='yes' order by ordr");
while ($mnr=tmq_fetch_array($mn)) {
	$alt=trim(stripslashes($mnr[descr]));
	$htmlli="";
	if ($mnr[type]=="sepper") {
		$sepperbgcol=barcodeval_get("WEB-MENU-SEPPERCOLOR-$mnr[id]");
		if ($sepperbgcol=="") {
			$sepperbgcol="#000000";
		}
		$htmlli=" class=headerbar style='width:200; background-color:$sepperbgcol'";
		//$htmlli=" class=headerbar style='width:200'";
		$link="";
	}
	if ($mnr[type]=="content") {
		$link="<A HREF='./webpage.contentread.php?id=$mnr[id]' >";
	}
	if ($mnr[type]=="webboard") {
		$link="<A HREF='./web/viewforum.php?ID=$mnr[id]' >";
	}
	if ($mnr[type]=="picalbum") {
		$link="<A HREF='./web/viewforum.php?ID=$mnr[id]&picalbum=yes' >";
	}
	if ($mnr[type]=="url") {
		$inf=tmq("select * from webpage_menu_url  where refid='$mnr[id]' ");
		$inf=tmq_fetch_array($inf);
		$link="<A HREF='$inf[url]'  target='$inf[target]'>";
	}
	if ($mnr[type]=="wiki") {
		$inf=tmq("select * from webpage_menu_wiki  where refid='$mnr[id]' ");
		$inf=tmq_fetch_array($inf);
		$link="<A HREF='$dcrURL"."webpage.wiki.php?title=".urlencode($inf[text])."' >";
	}
	?><li <?php echo $htmlli?> TITLE="<?php  echo $alt;?>" ALT="<?php  echo $alt;?>" ><?php echo $link;?><IMG 
	SRC="<?php echo $dcrURL?>/neoimg/webpagemenu/<?php  echo $mnr[icon]?>" class="WEBPAGE_MENUIMGICON" BORDER="0" ALT="" align=absmiddle hspace=0 vspace=0 width=16 height=16
	> <?php  echo getlang($mnr[name]);?> </A></FONT></li>
	<?php 
}
?>
</ul>
</div>
</TD>
</TR>
<?php 
if (barcodeval_get("webpage-o-isshowboardcategroup")=="yes") {
?>
<TR>
	<TD class=table_td >
<div class="arrowlistmenu">
	<h3 class="headerbar"><?php  echo getlang("หัวข้อเว็บบอร์ด::l::Webboard's ");?></h3>
<ul>
<?php $s=tmq("select * from webboard_boardcate where isshowtouser='yes' order by ordr");
while ($r=tmq_fetch_array($s)) {
?><li><A HREF="./webboard/viewforum.php?ID=<?php  echo $r[id];?>"><IMG SRC="<?php echo $dcrURL?>neoimg/menuicon/folder.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle>  <?php  echo getlang($r[name]);?> </A> </li>
<?php }?>
</ul></div></td></tr>
<?php 
}
if (barcodeval_get("webpage-o-isshowothermenugroup")=="yes") {
?>
<TR>
	<TD align=left>
<div class="arrowlistmenu">
	<h3 class="headerbar"><?php  echo getlang("อื่น ๆ::l::Others ");?></h3>
</div>
<UL style="padding-top: 0px;">
<?php $smallmenucol=" style='color:darkred' ";?>
	<LI><nobr><A HREF="about.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("เกี่ยวกับ ULIB::l::About ULIB");?></A></nobr> 
	<LI><nobr><A HREF="contact.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("ติดต่อเจ้าหน้าที่::l::Contact librarian");?></A></nobr> 
	<LI><nobr><A HREF="freedb.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("ฐานข้อมูลใช้ฟรี::l::Free Database");?></A></nobr>
	<?php if (barcodeval_get("rqroom-onoff")=="yes") {?>
		<LI><nobr><A HREF="requestroom1.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("บริการให้จองห้อง::l::Request Room");?></A></nobr>
	<?php }?>
	<LI><nobr><A HREF="search-browse-reservmat.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("รายการหนังสือสำรอง::l::Reserved Books");?></A></nobr> 
	<LI><nobr><A HREF="search-browse-title.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("เรียงตามชื่อเรื่อง::l::By Title");?></A></nobr> 
	<LI><nobr><A HREF="search-browse-rated.php" class=smaller <?php echo $smallmenucol;?>><?php  echo getlang("เรียงตามลำดับความนิยม::l::By rating");?></A></nobr> 
	<LI><nobr><A HREF="search-browse-author.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("เรียงตามผู้แต่ง::l::By Author");?></A></nobr>
	<LI><nobr><A HREF="search-browse-subject.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("รายการหัวเรื่อง::l::Subjects");?></A></nobr>
	<LI><nobr><A HREF="closeservice.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("วันปิดทำการ::l::Close Service");?></A></nobr> 
	<LI><nobr><A HREF="resource_type.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("ประเภทวัสดุสารสนเทศ::l::Resource Type");?></A></nobr> 
	<LI><nobr><A HREF="itemplaces.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("สถานที่จัดเก็บ::l::Places&Shelves");?></A></nobr> 
	<LI><nobr><A HREF="usoundex.php" class=smaller <?php echo $smallmenucol;?>><?php echo getlang("เกี่ยวกับ USOUNDEX::l::About USOUNDEX");?></A></nobr>

	</UL>
	</TD>
</TR>
<?php 
  }//ifshow other menu
?>
</TABLE></div>
<?php 

	if (barcodeval_get("webpage-o-isshowcalendarleftmenu")=="yes") {
		?><iframe src="webpage.calendar.php" width=100% height=180 FRAMEBORDER="no" BORDER=0
 id="iframe_calendarleftmenu" SCROLLING=NO style="border-color: #AAAAAA;border-style: solid;border-width: 1"></iframe><?php 
	}

	echo barcodeval_get("webpage-o-htmlunderleftmenu");

$webpage_hpsidebarmode="left";
include("webpage.hpsidebar.php");
?>