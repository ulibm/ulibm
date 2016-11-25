<?php 

?><center><?php 
$news=floor($readid);
if($news!=0) {
	quickeditwebtext("webbox-topmenu_list_read_befor","100%");

	$s=tmq("select * from webbox_topmenu_list_sub where id='$news' and isshow='yes' ");
	if (tnr($s)==1) {
		$s=tfa($s);
		?>
		<table align=center width=100%>
		<tr>
			<td><?php 
			echo "<font style=\"font-size: 22px;\">".stripslashes($s[title])."</font>";
		echo "<br>";
			echo ymd_datestr($s[dt],"date");
			if (loginchk_lib("check")) {
				?><a href="<?php  echo $dcrURL;?>library.webbox.cascademenu/h_menu_list_sub.php?pid=<?php  echo $s[pid]?>&fftmode=edit&ffteditid=<?php  echo $s[id]?>&startrow=0" class=a_btn target=_blank><?php  echo getlang("แก้ไข::l::Edit");?></a><?php 
			}
			echo "<br>";
			echo getlang("โดย::l::by")." ".html_library_name($s[loginid]);
			echo "<br>";
			echo str_webpagereplacer(stripslashes($s[body]));
			if (strtolower($s[globalslideshow])=="yes") {
				html_ugallery("webbox_topmenu_list_sub-$s[id]","100%");
			}
		?></td>
		</tr>
		</table>
		<?php 
	}
}
?></center><?php 




$slist=tmq("select * from webbox_topmenu_list where pid='$listid' order by ordr ");
while ($rlist=tfa($slist)) {
   ?><div style="-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
padding: 3px 3px 3px 3px ;
margin-bottom: 7px;
display:block; background-color: #<?php  echo $rlist[bgcol];?>; 
width: 99%;
"


><b style='color:#<?php  echo $rlist[fgcol];?>; '>&nbsp;<?php  echo stripslashes(str_webpagereplacer(getlang($rlist[name])));?></b><br />

<div style="-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
padding: 3px 3px 3px 3px ;
margin-top: 5px;
display:block; background-color: #ffffff; 
width: cal(100%-6px);
"


><?php
if (trim($rlist[descr])!="") { ?>
<font style='color:#000000;' class=smaller><?php  echo stripslashes(str_webpagereplacer(getlang($rlist[descr])));?></font><br />
<?php } ?>
<?php 
$s2=tmq("select * from webbox_topmenu_list_sub where pid='$rlist[id]' and isshow='YES' order by dt desc,id desc");
   echo "<div style='clear:both'></div>";
while ($r2=tfa($s2)) {
   if ($rlist[dsptype]=="thumbnail_list") {
  
      echo "<div style='width:100%; border: 0px solid Silver; border-bottom-width: 1px;'>";
      $imgurl=fft_upload_get("webbox_topmenu_list_sub","coverimg",$r2[id]);
      if ($r2[directurl]=="") {
         echo "<a href=\"index.php?viewtopmenulist=yes&listid=$listid&readid=$r2[id]\">";
      } else {
         echo "<a href=\"$r2[directurl]\" target=_blank>";
      }
		echo "<img style=' float: left; ' width=116 border=0 hspace=3 src='";
   	echo $imgurl[url];
   	echo "'>";
	   echo "".
		stripslashes($r2[title])."</a>";
		if ($r2[tailicon]!="None.png") {	
   		?> <img src="<?php  echo $dcrURL;?>neoimg/gificon/<?php  echo $r2[tailicon];?>" height=12><?php 
		}	
		echo "<br> 
		<font class=smaller2>".stripslashes($r2[descr])."</font> ";

		echo "<br>
		<font class=smaller2>".ymd_datestr($r2[dt],"date")."</font>";;
      echo "<div style='clear:both'></div>";
		echo "</div>";
   }
   if ($rlist[dsptype]=="list") {
      echo "<div style='width:100%; border: 0px solid Silver; border-bottom-width: 1px;'><img src='$dcrURL/neoimg/webpagemenu/$r2[icon]' width=20 height=20> ";
      if ($r2[directurl]=="") {
         echo "<a href=\"index.php?viewtopmenulist=yes&listid=$listid&readid=$r2[id]\">";
      } else {
         echo "<a href=\"$r2[directurl]\" target=_blank>";
      }
		echo stripslashes($r2[title])."</a> ";
		if ($r2[tailicon]!="None.png") {	
   		?> <img src="<?php  echo $dcrURL;?>neoimg/gificon/<?php  echo $r2[tailicon];?>" height=12><?php 
		}			
		echo "<font class=smaller2>(".ymd_datestr($r2[dt],"date").")</font>";;
		
		echo "</div>";
   }
   if ($rlist[dsptype]=="box") {
      echo "<div style='width:120; height: 120px; display: block; 
      border: 1px solid Silver; overflow: hidden; 
      float: left; margin: 3px 3px 3px 3px;;'>";
      if ($r2[directurl]=="") {
         echo "<a href=\"index.php?viewtopmenulist=yes&listid=$listid&readid=$r2[id]\" class=smaller>";
      } else {
         echo "<a href=\"$r2[directurl]\" target=_blank class=smaller>";
      }
      
		echo stripslashes($r2[title])."</a>";
		if ($r2[tailicon]!="None.png") {	
   		?> <img src="<?php  echo $dcrURL;?>neoimg/gificon/<?php  echo $r2[tailicon];?>" height=12><?php 
		}
		echo "<br /><font class=smaller2> (".ymd_datestr($r2[dt],"date").")<br /></font>";;
		$imgurl=fft_upload_get("webbox_topmenu_list_sub","coverimg",$r2[id]);
      if ($r2[directurl]=="") {
         echo "<a href=\"index.php?viewtopmenulist=yes&listid=$listid&readid=$r2[id]\" class=smaller>";
      } else {
         echo "<a href=\"$r2[directurl]\" target=_blank class=smaller>";
      }		
      echo "<img width=116 border=0 src='";
   	echo $imgurl[url];
   	echo "'></a>";
		echo "</div>";
   }

}
   echo "<div style='clear:both'></div>";
?>
</div>

</div><?php 
}
?>