<?php  ;
   include ("inc/config.inc.php");
	 
   if ($_GET[forcenomobile]=="yes") {
      $_SESSION[webforcenomobile]="yes";
   }
	$html_start_title=getlang(getval("global","TITLE BAR"));
   
  // echo "[$PHP_SELF]";
  // echo "[$forcehpmode]";
	 if ($_SESSION[webforcenomobile]!="yes" && strtolower(barcodeval_get("webmobile-options-useredirect"))=="yes" && floor(barcodeval_get("webmobile-options-redirectscreendecis"))>0) {
	  ?><script>
	   if (window.screen.width < <?php echo floor(barcodeval_get("webmobile-options-redirectscreendecis")); ?>) {
         // resolution is below decision point
         window.location = '<?php echo $dcrURL;?>mobile/'; 
       }
	  </script><?php
	 }

	if (($forcehpmode=="" || $rescanhp=="yes") && $IPADDR!="") {
	  //echo "here";
		$ulc=tmq("select * from ulibclient where ip='$IPADDR' ",false); 
		
		if (tmq_num_rows($ulc)!=0) {
			$ulc=tmq_fetch_array($ulc);
			//printr($ulc); die;;
			$ulcmod=$ulc[module];
			$ulm=tmq("select * from ulibclient_module where code='$ulcmod' ");
			$iscollec=substr($ulcmod,0,strlen('collections-webbox-'));
			if ($iscollec!='collections-webbox-') {
				// die("unsetting collections");
				ulibsess_unregister("usecollection");
				ulibsess_unregister("disablereselectcollection");
			}
			$iscollec=substr($ulcmod,0,strlen('collections-'));
			if ($iscollec!='collections-') {
				// die("unsetting collections");
				ulibsess_unregister("usecollection");
				ulibsess_unregister("disablereselectcollection");
			}
			if (tmq_num_rows($ulm)!=0) {
				$ulm=tmq_fetch_array($ulm);
				//printr($ulm); die;;
            ulibsess_unregister("usecollection");
            ulibsess_unregister("disablereselectcollection");
				tmq("update ulibclient set lastaccess='".time()."' where ip='$IPADDR'");
				redir("$dcrURL".$ulm[url]);
				die;
			}
		} else {
			$forcehpmode="";
			ulibsess_unregister("forcehpmode");
		}
	}
   include("./index.inc.php");
   
	function local_importtantannouce() {
		$tmp=getlang(getval("_SETTING","IMPORTTANT_INDEX_ANNOUCE"));
		if (trim($tmp)!="") {
			echo "<TABLE width=700 align=center class=table_border>
			<TR>
				<TD class=table_head>".getlang("ประกาศ::l::Annoucement")."</TD>
			</TR>
			<TR>
				<TD class=table_td align=center>".$tmp."<BR></TD>
			</TR>
			</TABLE>";
		}
	}
	$_TMPINDEXDSP="";
	if ((getval("_SETTING","form_at_hp")=="search" && $forcehpmode=="") ||  $forcehpmode=="search") {
		$_TMPINDEXDSP="search";
	} elseif ((getval("_SETTING","form_at_hp")=="member_login" && $forcehpmode=="") ||  $forcehpmode=="member_login") {
		$_TMPINDEXDSP="member_login";
	} elseif ((getval("_SETTING","form_at_hp")=="webbox" && $forcehpmode=="") ||  $forcehpmode=="webbox") {
		$_TMPINDEXDSP="webbox";
	} elseif ((getval("_SETTING","form_at_hp")=="webpage" && $forcehpmode=="") ||  $forcehpmode=="webpage") {
		$_TMPINDEXDSP="webpage";
	} elseif (getval("_SETTING","form_at_hp")=="undercon") {
		$_TMPINDEXDSP="undercon";
	}  elseif ((getval("_SETTING","form_at_hp")=="Wiki" && $forcehpmode=="") ||  $forcehpmode=="Wiki") {
		redir("webpage.wiki.php");
		die;
	}  elseif ((getval("_SETTING","form_at_hp")=="freedb" && $forcehpmode=="") ||  $forcehpmode=="freedb") {
		redir("freedb.php");
		die;
	} elseif ((getval("_SETTING","form_at_hp")=="browsetitle" && $forcehpmode=="") ||  $forcehpmode=="browsetitle") {
		redir("search-browse-title.php");
		die;
	} elseif ( getval("_SETTING","form_at_hp")=="rqroom"||$forcehpmode=="rqroom") {
		redir("requestroom1.php");
		die;
	} elseif ((getval("_SETTING","form_at_hp")=="browseauthor" && $forcehpmode=="") ||  $forcehpmode=="browseauthor") {
		redir("search-browse-author.php");
		die;
	} elseif ((getval("_SETTING","form_at_hp")=="advsearch" && $forcehpmode=="") ||  $forcehpmode=="advsearch") {
		$_TMPINDEXDSP="advsearch";
	}
		///////////////////////////////////////////////////////////////////////////////
														//Cache option             min   hours
														//                                     v        v
			  pcache_s("_ULIBINDEX-$_TMPINDEXDSP$deftab",     15,      0,      false,"HOMEPAGE");
			  //deftab for webbox mode
		///////////////////////////////////////////////////////////////////////////////
	if ($_TMPINDEXDSP=="search") {
		stat_add("visithp_type","search");
		head();
		mn_web("search");
		local_importtantannouce();
		?><table width=700 align=center>
		<tr>
		<td style = "background-image: url(neoimg/LightningSmall.jpg);
		background-repeat: no-repeat"> <img src = "./neoimg/spacer.gif" height = 40 width = 2><BR><BR><BR><?php 
			include ("searchForm.php");
			//echo "<hr>";
		?>
		</td>
		</tr></table>
		<?php 
	} elseif ($_TMPINDEXDSP=="webbox") {
	  stat_add("visithp_type","webbox");
		head();
		include($dcrs."library.webintropage/external.inc.php");
		if (barcodeval_get("webpage-o-ishidetopmenuathomepage")!="yes") {
			mn_web("webpage");
		} else {
			if ($_memid!="") {
				 include($dcrs."/member/menuadmin.php");
			}
		}
		//local_importtantannouce();
		include($dcrs."webbox/index.php");
	} elseif ($_TMPINDEXDSP=="member_login") {
	  stat_add("visithp_type","member_login");
		head();
		mn_web("advsearch");
		local_importtantannouce();
		echo "<BR><BR>";
		form_member_login();
	} elseif ($_TMPINDEXDSP=="webpage") {
	include($dcrs."library.webintropage/external.inc.php");
	  stat_add("visithp_type","webpage");
	  $isenablehpsidebar=strtolower(barcodeval_get("hpsidebar-o-enable"));
		include($dcrs."library.webintropage/external.inc.php");

		if ($isenablehpsidebar=="yes") {
		head();
		if (barcodeval_get("webpage-o-ishidetopmenuathomepage")!="yes") {
			mn_web("webpage");
		}
		$hpsidebarbgcol=barcodeval_get("hpsidebar-o-colo");?>
	<!-- end head, start body -->
	<table width="<?php  echo $_TBWIDTH?>" border=0 align=center bgcolor=white cellpadding=0 cellspacing=0>
	<TR valign=top>
		<TD align=left><?php 	
		local_importtantannouce();
		include("webpage.php");
		?></TD><TD>
<TABLE cellpadding=2 cellspacing=0 border=0>
		<TR>
			<TD style="padding-left: 3"><?php 
		$webpage_hpsidebarmode="homepage";
		include("webpage.hpsidebar.php");?></TD>
		</TR>
		</TABLE></TD>
	</TR>
	</TABLE>
	<?php 


?>

<?php 
		} else {
			head();
			if (barcodeval_get("webpage-o-ishidetopmenuathomepage")!="yes") {
				mn_web("webpage");
			}
			local_importtantannouce();
			include("webpage.php");
		}
	} elseif ($_TMPINDEXDSP=="undercon") {
	  stat_add("visithp_type","undercon");
		head();
		local_importtantannouce();
		include("undercon.php");
	} elseif ($_TMPINDEXDSP=="advsearch") {
	  stat_add("visithp_type","advsearch");
		head();
		local_importtantannouce();
		mn_web("advsearch");
		?><table width="<?php  echo $_TBWIDTH?>" align=center>
		<tr>
		<td style = "background-image: url(neoimg/LightningSmall.jpg);
		background-repeat: no-repeat"> <img src = "./neoimg/spacer.gif" height = 40 width = 2>
		<BR><BR><BR><BR><?php 
			include("advsearch.php");
		?>
		</td>
		</tr></table>
		<?php 
	}

/////////////////////////////////////////////////////////////////
	if (loginchk_lib('check')==true) {
		?>
		<TABLE width="<?php  echo $_TBWIDTH?>" align=center cellpadding=0 cellspacing=0>
		<TR>
			<TD align=center><A HREF="<?php  echo $dcrURL?>/library/mainadmin.php"><?php  echo getlang("กลับหน้าหลักเจ้าหน้าที่::l::Back to librarian's menu");?></A></TD>
		</TR>
		</TABLE>
		<?php 
	}
		if ($isenablehpsidebar=="yes") {
			?><table width=985 border=0 align=center bgcolor=white cellpadding=0 cellspacing=0>
	<TR valign=top>
		<TD><?php 
		foot();
?></TD>
		<TD width=205></TD>
	</TR>
	</TABLE><?php 
		} else {
			foot();
		}
		addons_module("homepage_beforeend");
	pcache_e();
?>