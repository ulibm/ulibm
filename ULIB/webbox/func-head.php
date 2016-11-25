<?php  //พ
function local_edithtmlbtn($wh,$txt) {
	global $dcrURL;
	if (loginchk_lib('check')==true) {?><div style="clear: both;"></div>
	<A HREF="<?php  echo $dcrURL?>webbox/man.pagehtml.php?classid=<?php  echo $wh?>"  rel="gb_page_fs[]" style="nofloat:left; display: inline-block; width: 12px; height: 12px; overflow: hidden;" class="smaller2 a_btn" TITLE="<?php  echo $wh?>"
	onmouseover="this.style.width='auto';"
	onmouseout="this.style.width='12px';"
	><img src="<?php  echo $dcrURL?>webbox/config.png"   hspace=2 vspace=0 border=0 width=10 height=10	> <?php  echo getlang($txt)?></A>
	<?php }
	$s=tmq("select * from webbox_pagehtml where classid='$wh' ");
	$s=tmq_fetch_array($s);
	$jsid="editable".randid();
	$jsstradmin=" style='border: solid 0px #2d8fbf;' onmouseover='local_edithtmlbtn_over(\"$jsid\"); 'onmouseout='local_edithtmlbtn_out(\"$jsid\"); ' ";
	$jsstr=" ";
	if (loginchk_lib('check')==true) {
		echo "<div ID='$jsid' $jsstradmin>".stripslashes($s[html])."</div>";
	} else {
		echo "<div $jsstr>".stripslashes($s[html])."</div>";
	}
}

function local_webbox($r) {
	global $webbox_cur_columnwidth; // width of current column
	global $dcrURL;
	global $deftab;
	$boxradius =floor($r[boxradius]);
			//printr($r);
			//////////////////////////////////////////////////////////////////////////////////////////
			$ishide="no";
			if ($r[ishide]=="yes") {
				if (loginchk_lib('check')==true) {
				  $ishide="yes";
				  $r[title]=$r[title]." (".getlang("ซ่อน::l::Hiding").")";
					//echo "hide but ok";
				} else {
			    return;
   			}
			} 
			if ($r[title]=="") {
				if (loginchk_lib('check')==true) {
					$r[title]=getlang("กล่อง::l::Box");
				}
			}
			if ($r[bg_color]=="") {
				$r[bg_color]="FFFFFF";
			}
			?><div class="DragBox" id="webbox<?php  echo $r[id]?>"  overClass="OverDragBox" dragClass="DragDragBox" style="background-image:url(<?php  echo $dcrURL?>neoimg/alpha90.png);background-color: <?php  echo $r[border_color]?>; border-color: <?php  echo $r[border_color]?>;border-style: <?php  echo $r[border_style]?>;border-width: <?php  echo $r[border_width]?>; 
			  -moz-border-radius-topleft:<?php  echo $boxradius?>;
 -moz-border-radius-topright:<?php  echo $boxradius?>;
  -moz-border-radius-bottomright:<?php  echo $boxradius?>;
  -moz-border-radius-bottomleft:<?php  echo $boxradius?>;
  -webkit-border-top-left-radius:<?php  echo $boxradius?>;
  -webkit-border-top-right-radius:<?php  echo $boxradius?>;
  -webkit-border-bottom-left-radius:<?php  echo $boxradius?>;
  -webkit-border-bottom-right-radius:<?php  echo $boxradius?>;
  <?php 
	if (floor($r[border_width])!=0) {
	echo " width: calc(100% - ".( floor($r[border_width])*2  ) ."px)!important;;";
  }	  
  ?>
  "
	  <?php 	if (loginchk_lib('check')==true) {  ?>
	  onmouseover="this.style.boxShadow='0px 0px 25px 15px rgba(150,150,150,0.75);';this.style.MozBoxShadow='0px 0px 25px 15px rgba(150,150,150,0.75);';this.style.WebkitBoxShadow=' 0px 0px 25px 15px rgba(150,150,150,0.75)';;"
	  onmouseout="this.style.boxShadow='';this.style.MozBoxShadow='';this.style.WebkitBoxShadow='';;"
	  <?php  } ?>
  >
<?php 
	if (loginchk_lib('check')==true) {
	  ?>
			<A HREF="<?php  echo $dcrURL?>webbox/man.box.php?mode=edit&tab=<?php  echo $deftab;?>&id=<?php  echo $r[id]?>"  rel="gb_page_fs[]"><img src="<?php  echo $dcrURL?>webbox/config.png" style="float:right;" hspace=2 vspace=0 border=0 ></A>
			<?php  
			$edit_url="";
			if ($r[type]=="topmenulist") { $edit_url="man.box.topmenulist.php?pid=$r[id]"; }
			if ($r[type]=="tab") { $edit_url="man.box.tab.php?pid=$r[id]"; }
			if ($r[type]=="photoframesingle") { $edit_url="man.box.photoframesingle.php?pid=$r[id]"; }
			if ($r[type]=="newslist") { $edit_url="man.box.newslist.php?pid=$r[id]"; }
			if ($r[type]=="customlist") { $edit_url="man.box.customlist.php?pid=$r[id]"; }
			if ($r[type]=="calendar2") { $edit_url="man.box.calendar2.php?pid=$r[id]"; }
			if ($r[type]=="rss") { $edit_url="man.box.rss.php?id=$r[id]"; }
			if ($r[type]=="photogrid") { $edit_url="man.box.photogrid.php?id=$r[id]"; }
			if ($r[type]=="sepper") { $edit_url="man.box.sepper.php?id=$r[id]"; }
			if ($r[type]=="html") { $edit_url="man.box.html.php?id=$r[id]"; }
			if ($r[type]=="googlemap") { $edit_url="man.box.googlemap.php?id=$r[id]"; }
			if ($r[type]=="biblist") { $edit_url="man.box.biblist.php?pid=$r[id]"; }
			
			if ($edit_url!="") {
				?><A HREF="<?php  echo $dcrURL?>webbox/<?php  echo $edit_url?>"  rel="gb_page_fs[]"><img src="<?php  echo $dcrURL?>webbox/edit.png" style="float:right;" hspace=2 vspace=0 border=0 ></A><?php 
			}
	 }

	if (loginchk_lib('check')==true || $r[hideheader]!="yes") {?>
		<?php  if (strtolower(barcodeval_get("webboxoptions-showminicon"))=="yes" || loginchk_lib("check")==true) { ?>
			<A HREF="javascript:void(null)" 
			onclick="tmp=getobj('contentbox<?php  echo $r[id]?>'); tmp2=getobj('minmaxbtn<?php echo $r[id]?>'); if (tmp.style.display=='none')  { tmp.style.display='block';tmp2.src='<?php  echo $dcrURL?>webbox/minimize.gif';setcookie('webboxcollapse<?php echo $r[id]?>','');} else { tmp.style.display='none';tmp2.src='<?php  echo $dcrURL?>webbox/maximize.gif';setcookie('webboxcollapse<?php echo $r[id]?>','yes');}">
			<img src="<?php  echo $dcrURL?>webbox/minimize.gif" style="float:right;" hspace=2 vspace=0 border=0 ID="minmaxbtn<?php echo $r[id]?>"></A>
		<?php  } ?>

			&nbsp;<B style="color: red;" title="<?php  echo getlang("ซ่อนส่วนหัวไว้::l::Hiding header");?>"><?php  if ($r[hideheader]=="yes") { echo "!!"; }?></B>&nbsp;<?php  echo $r[title]; ?>
<?php  }?>
			<div ID="loading<?php echo $r[id]?>" style="font-size: 13; color: darkgray;   background-color: <?php  echo $r[bg_color];?>;" class=contentbox><CENTER><img src="<?php  echo $dcrURL?>webbox/loading_animation.gif"><BR> Loading..</CENTER></div>
			<div ID="contentbox<?php  echo $r[id]?>" class=contentbox
			style="  -moz-border-radius-bottomright:<?php  echo $boxradius?>;
  -moz-border-radius-bottomleft:<?php  echo $boxradius?>;
  -webkit-border-bottom-left-radius:<?php  echo $boxradius?>;
  -webkit-border-bottom-right-radius:<?php  echo $boxradius?>;
  background-color: <?php  echo $r[bg_color];?>;
  ">
</div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	if (getcookie("webboxcollapse<?php echo $r[id]?>")=="yes") {
		tmp=getobj('contentbox<?php  echo $r[id]?>'); 
		tmp2=getobj('minmaxbtn<?php echo $r[id]?>'); 
		tmp.style.display='none';
		tmp2.src='<?php  echo $dcrURL?>webbox/maximize.gif';
	}
//-->
</SCRIPT>
<?php 
	if ($r[type]=="tab" && $_HPSIDEBARTAB_htmled!="yes") {
		$_HPSIDEBARTAB_htmled="yes";
		?><link rel="stylesheet" type="text/css" href="<?php  echo $dcrURL?>js/tabcontent.css" />
		<script type="text/javascript" src="<?php  echo $dcrURL?>js/tabcontent.js">
		/************************************************ Tab Content script v2.2-  Dynamic Drive DHTML code library (www.dynamicdrive.com)* This notice MUST stay intact for legal use* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code***********************************************/
		</script><?php 
	}
?>
<?php 	if (loginchk_lib('check')==true && $r[type]=="photonews") {?>
<A HREF="<?php  echo $dcrURL?>library.indexphotonews/" target=_blank class="smaller2 a_btn"><?php  echo getlang("จัดการภาพข่าว::l::Manage Photo news");?></A>
<?php }?>
<?php 	if (loginchk_lib('check')==true && $r[type]=="eventcalendar") {?>
<A HREF="<?php  echo $dcrURL?>library.webmenu/h_mocalen.php" target=_blank class="smaller2 a_btn"><?php  echo getlang("จัดการกิจกรรม::l::Manage Events");?></A>
<?php }?>
<?php 	if (loginchk_lib('check')==true && $r[type]=="weeklybook") {?>
<A HREF="<?php  echo $dcrURL?>library.weeklybook/" target=_blank class="smaller2 a_btn"><?php  echo getlang("จัดการ::l::Manage");?></A>
<?php }?>
</div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	xmlhttp<?php echo $r[id]?>=getHTTPObject();
	xmlhttp<?php echo $r[id]?>.onreadystatechange=function() {
		if (xmlhttp<?php echo $r[id]?>.readyState==4 && xmlhttp<?php echo $r[id]?>.status==200) {
			tmp1=getobj("loading<?php echo $r[id]?>");
			tmp1.style.display="none";
			tmp=getobj("contentbox<?php echo $r[id]?>");
			tmpstrres=xmlhttp<?php echo $r[id]?>.responseText+"";
			tmpstrres=""+udecode(tmpstrres)+"";
			tmp.innerHTML=""+tmpstrres+"";
			//alert(tmpstrres);
			console.log("box <?php echo $r[id]?> loaded;");
			//console.log("box <?php echo $r[id]?> code;"+tmpstrres);

<?php  if ($r[type]=="tab") {
?>
var countries=new ddtabcontent("webboxtabid<?php echo $r[id]?>");
countries.setpersist(true);
countries.setselectedClassTarget("link"); 
 
countries.init();
<?php }?>

		}
	}
	xmlhttp<?php echo $r[id]?>.open("GET","<?php  echo $dcrURL?>globalpuller.php?charset=UTF-8&url=<?php  echo urlencode($dcrURL."webbox/boxcontent.php?id=$r[id]&webbox_cur_columnwidth=$webbox_cur_columnwidth");?>",true);
	xmlhttp<?php echo $r[id]?>.send();
	console.log("box <?php echo $r[id]?> loading ; <?php  echo ($dcrURL."webbox/boxcontent.php?id=$r[id]&webbox_cur_columnwidth=$webbox_cur_columnwidth");?>");

/*
<?php  echo ($dcrURL."webbox/boxcontent.php?id=$r[id]&webbox_cur_columnwidth=$webbox_cur_columnwidth");?>
*/
<?php  if ($r[type]=="photogrid") {
?>

function photogridimageload<?php echo $r[id];?>() {
    
 var elem = document.querySelector('.grid<?php echo $r[id];?>');
 var msnry = new Masonry( elem, {
   // options
   itemSelector: '.grid<?php echo $r[id];?>-item',
   columnWidth: <?php echo floor($webbox_cur_columnwidth-3); ?>
 });

 // element argument can be a selector string
 //   for an individual element
 var msnry = new Masonry( '.grid<?php echo $r[id];?>', {
   // options
 });
}
setInterval("photogridimageload<?php echo $r[id];?>();",1000);
<?php }?>

//-->
</SCRIPT>
			<?php 
			//////////////////////////////////////////////////////////////////////////////////////////
}

function local_getwebboxtabdata($tab,$item) {
	$s=tmq("select * from webbox_tab_data where tabid='$tab' and item='$item' ");
	$s=tmq_fetch_array($s);
	return stripslashes($s[val]);
}
function local_setwebboxtabdata($tab,$item,$val) {
	tmq("delete from webbox_tab_data where tabid='$tab' and item='$item' ");
	tmq("insert into webbox_tab_data set tabid='$tab' , item='$item' , val='".addslashes($val)."'");
}

?>