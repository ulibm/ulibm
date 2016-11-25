<?php 
include("$dcrs/web/jseffect.php");
$now=time();
?><TABLE width=780 cellpadding=0 cellspacing=0 border=0>
<TR valign=top>
	<TD width=200><?php  include("webpage.menu.php");?><BR><BR></TD>
	<TD ID=WEBPAGE_CONTENTTD><?php 
	$tmp=str_webpagereplacer(stripslashes(barcodeval_get("webpage-Homepagegreeting")));
	$Homepagegreetingline=barcodeval_get("webpage-Homepagegreetingline");
	$Homepagegreetingline=trim($Homepagegreetingline);
	$Homepagegreetingline=stripslashes($Homepagegreetingline);
	if ($Homepagegreetingline!="") {
		pagesection($Homepagegreetingline,"article");
	}
		$tmpquicksearch=strtolower(barcodeval_get("webpage-o-isshowquicksearch"));
		if ($tmpquicksearch=="yes") {
			$_QUICKSEARCHonlymember="yes";
			include("webpage.inc.quicksearch.php");
		}
		if (barcodeval_get("webpage-indexphotonews_isenable")=="yes") {
			$indexphotonews_count="select * from webpage_indexphotonews where cate='news' and dtstart<=$now and dtend>=$now order by dt desc";
			$indexphotonews_count=tmq($indexphotonews_count,false);
			//echo tmq_num_rows($indexphotonews_count);
			if (tmq_num_rows($indexphotonews_count)!=0) {
				$ipndisplaystyle=barcodeval_get("webpage-indexphotonews_style");
				//echo "[$ipndisplaystyle]";
				$indexphoto_h=barcodeval_get("webpage-indexphotonews_setheight");
				if ($ipndisplaystyle=="Frame") {
					?><CENTER><iframe width="550" height="<?php  echo $indexphoto_h;?>" FRAMEBORDER="NO" BORDER=0 SCROLLING=NO src="./library.indexphotonews/index.external.view.php?bgcolor=A3A3A3&set_height=<?php  echo $indexphoto_h;?>&set_width=550"></iframe></CENTER><?php 
				}
				//	echo "[$ipndisplaystyle]";
				if ($ipndisplaystyle=="Frame With Caption") {
					?><CENTER><iframe width="550" height="<?php  echo $indexphoto_h;?>" FRAMEBORDER="0" BORDER=0 SCROLLING=NO src="./library.indexphotonews/index.external.view2.php?bgcolor=A3A3A3&set_height=<?php  echo $indexphoto_h;?>&set_width=550"></iframe></CENTER><?php 
				}
				if ($ipndisplaystyle=="Matrix") {
					?><CENTER><iframe width="550" height="<?php  echo $indexphoto_h;?>" FRAMEBORDER="NO" BORDER=0 SCROLLING=NO src="./library.indexphotonews/index.external.viewmetrix.php?bgcolor=A3A3A3&set_height=<?php  echo $indexphoto_h;?>&set_width=550"></iframe></CENTER><?php 
				}
			}
		}
		?><TABLE width=100% cellpadding=3 cellspacing=0 border=0>
		<TR>
			<TD style="padding-left: 5px;"><?php 
	if (barcodeval_get("webpage-o-isshowcalendar")=="yes") {
		?><div style="border-width: 1px;
		border-style: solid; border-color: #8F8F8F; FLOAT: right; padding: 5px"><iframe src="webpage.calendar.php" width=200 height=180 FRAMEBORDER="no" BORDER=0
 id="iframe_calendar" SCROLLING=NO style="border-color: #AAAAAA;border-style: solid;border-width: 1"></iframe></div><?php 
	}
	if ($tmp!="") {
		//echo "<BR>";
		echo $tmp;
	} 
	
	//mocalen modern calendar
	$mocals=floor(barcodeval_get("mocal-o-dayhistory")*(60*60*24));
	$mocale=floor(barcodeval_get("mocal-o-dayforward")*(60*60*24));	
	$mocals=time()-$mocals;
	$mocale=time()+$mocale;
	$s=tmq("select * from webpage_mocalen where isshow='yes' and dt>=$mocals and dt<=$mocale order by dt asc");
if (tmq_num_rows($s)!=0) {
  pagesection(barcodeval_get("mocal-o-name"),"articlelist");
	 			 ?>
<TABLE width=95% align=center bgcolor=#FFFFFF border=0 cellpadding=0 cellspacing=0 >
	<?php  
	$imocal=0;
	while ($r=tmq_fetch_array($s)) {
	if ($imocal ==0) {
	 echo "<tr ><td valign=top >";
}
$imocal++;
			if (mb_strlen($r[descr])>35) { $r[descr]=mb_substr($r[descr],0,35).'..'; }
				?><table width=135 align=left cellpadding=3 cellspacing=1 height=100	style="width: 135"<?php 
			 if ($r[dt]==ymd_mkdt(date('j'),date('n'),date('Y'))) {
			 		echo " style='border-width: 0;border-bottom-width: 1px;border-right-width: 1px; border-color:#666666; border-style: solid;' ";
			 }
?> border=0>
<tr><td bgcolor="<?php  echo $r[col]?>" valign=top style="padding-left: 10; cursor: hand; cursor: pointer;
background-image: url(./neoimg/mocalenclip.png); background-repeat: no-repeat;"
onclick="window.open('webpage.mocal.read.php?id=<?php  echo $r[id]?>','','width=550,height=500,resizable,scrollbars=yes')"
><b style="color:white;"><?php  echo $r[title]?></b><br />
<font color=white style='font-size: 11'><?php  echo ymd_datestr($r[dt],'shortd');?></font><br />
<font color=white style='font-size: 11'><?php  echo $r[descr];?></font>
<font color=white style='font-size: 11'><?php 
	$sc=tmq("select * from webpage_mocalen_resp where pid='$r[id]' ");
	if (tmq_num_rows($sc)!=0) {
		 echo "<br />".getlang("มีความเห็น::l::Got response").": <b style='font-size: 11'>" .number_format(tmq_num_rows($sc))."</b>";;;
	}
?></font>
</td></tr>
<TR bgcolor="<?php  echo $r[col]?>" valign=top height=7>
	<TD style="padding: 0; margin: 0"><IMG SRC="./neoimg/mocalenclipb.png" WIDTH="135" HEIGHT="7" BORDER="0" ALT=""></TD>
</TR>
</table><?php 	
if ($imocal % 4 ==0 && $imocal!=0) {
	 echo "</TD ></tr><tr ><td valign=top >";
}

	}
	?>
	</table><br />

	<?php 
}	
	//book showcase

$s=tmq("select * from index_db where webpageshowcase='yes' ");
if (tmq_num_rows($s)!=0) {
	 pagesection("วัสดุสารสนเทศแนะนำ::l::Material showcase","articlelist");
	 			 ?>
<TABLE width=100% align=center bgcolor=#FFFFFF border=0>
	<?php 
	$i=0;
	while ($r2=tmq_fetch_array($s)) {
		if (($i % 3) == 0) { echo "<TR valign=top><TD >"; }
		$i++;
		//echo "[$i".($i % 4 )."]";
		$rand=randid();
		
		   $r2[titl]=($r2[titl]);
		   $r2[auth]=($r2[auth]);

		if (mb_strlen($r2[titl])>35) { $r2[titl]=mb_substr($r2[titl],0,35).'..'; }
		if (mb_strlen($r2[auth])>17) { $r2[auth]=mb_substr($r2[auth],0,15).'..'; }
		?><TABLE border=0 align=left width=190 cellpadding=0 cellspacing=0>
			<TR>
				<TD><?php 
		$webreview=tmq("select * from webpage_showcase where mid='$r2[mid]' ");
		$webreviewstr="";
		if (tmq_num_rows($webreview)!=0) {
			$webreviewstr="<BR>&nbsp;<IMG SRC='./neoimg/reviewicon.png' WIDTH='20' HEIGHT='20' BORDER='0' align=absmiddle><B><FONT COLOR='#000066' style='font-size: 11px;'> ".getlang("มี review::l::Got review!")."</FONT></B>";
		}
			echo "<a href='dublin.php?ID=$r2[mid]' target=_blank style='font-size: 13px; padding-left:3'>";
			 echo res_cov_dsp($r2[mid],$tags,65,"yes"," style='border-color:black; float: left;;margin-right: 4'");
			 echo "".($r2[titl])."</a><br /> <font style='font-size: 11px;'>$r2[auth]</font>";		
		
			echo $webreviewstr;
				?></TD>
		</TR>
		</TABLE><?php 
		if (($i % 3) == 0) { echo "</TD></TR>"; }
	}
	?>
	</TABLE><br /><a href="./getfeed.php?feed=showcase" class=feedbtn><img align=absmiddle src="./neoimg/feed-icon-14x14.png" border=0> <?php  echo getlang("วัสดุฯแนะนำ::l::Books on showcase");?></a>
<?php 
}

	
	
	//page section
	$s=tmq("select * from webpage_sections where isshow='yes' and ispin='yes' order by dt desc");
	while ($r=tmq_fetch_array($s)) {
		   
		   pagesection(stripslashes($r[title]),"articlelist");
		echo "<BLOCKQUOTE>";
		echo str_webpagereplacer(stripslashes(stripslashes($r[body])));
		echo "</BLOCKQUOTE>";
	}

	$s=tmq("select * from webpage_sections where isshow='yes' and ispin<>'yes' order by dt desc");
	while ($r=tmq_fetch_array($s)) {

		pagesection(stripslashes($r[title]),"articlelist");
		echo "<BLOCKQUOTE>";
		echo str_webpagereplacer(stripslashes(stripslashes($r[body])));
		echo "</BLOCKQUOTE>";
	}
		?><BR><BR></TD>
		</TR>
		</TABLE></TD>
</TR>
</TABLE>