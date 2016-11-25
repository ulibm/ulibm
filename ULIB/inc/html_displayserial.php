<?php 
function html_displayserial($ID,$item = "",$serialmode="box") {
	global $dcrs;
	global $dcrURL;
	global $thaimonstr;
	global $_pagesplit_btn_var;
	global $PHP_SELF;
	global $startrow;

	global $_TBWIDTH;
if ($serialmode=="") {
	$serialmode=getval("_SETTING","display_serialitemstyle");
}
$MID=$ID;
if ($serialmode=="") {
	$serialmode="box";
}

	//pagesection(getlang("รายการสื่อสารสนเทศ (วารสาร)::l::Items (serial)"));
?><?php  echo getlang("ดูแบบ::l::View mode");?>:
<A HREF="<?php  echo $dcrURL;?>dublin.php?ID=<?php  echo $ID?>&serialmode=box" class=a_btn target=_top><?php  echo getlang("กล่อง::l::Box");?></A>
<A HREF="<?php  echo $dcrURL;?>dublin.php?ID=<?php  echo $ID?>&serialmode=list" class=a_btn  target=_top><?php  echo getlang("รายการ::l::List");?></A><?php 
$linktofile=$PHP_SELF;
$linktofilefile=pathinfo($linktofile);
//printr($linktofilefile);
//echo "[linktofile=$linktofile]";

if ($serialmode=="box") {
?><TABLE align=center width=<?php echo $_TBWIDTH+10?> cellpadding=0 cellspacing=0>
<TR>
	<TD><?php 
$boxrow=6;
	$sb1="SELECT *  FROM media_mid where pid='$MID' ";	
			$sb1="$sb1 group by jenum_1,jenum_2,jenum_3,jenum_4,jenum_5,jenum_6,calln";
	$tdwidth=floor($_TBWIDTH/$boxrow)-10;
	if ($tdwidth<100) {
		 $tdwidth=100;
	}
	$sb1.=" order by 
   length(trim(jchrono_1)) desc,jchrono_1 desc,
   length(trim(jchrono_2)) desc,jchrono_2 desc,
     length(trim(jchrono_3)) desc,jchrono_3 desc,
     length(trim(jenum_1)) desc,jenum_1 desc,
     length(trim(jenum_2)) desc,jenum_2 desc,
     length(trim(jenum_3)) desc,jenum_3 desc,
     length(trim(jenum_4)) desc,jenum_4 desc,
     length(trim(jenum_5)) desc,jenum_5 desc,
     length(trim(jenum_6)) desc,jenum_6 desc,
     length(trim(inumber)) ,inumber   ";
  $sql1 ="$sb1" ; 
//echo $sql1;
//	

if ($linktofilefile[basename]=="dublinfull.php" || $linktofilefile[basename]=="dublin.php") {
	$result = tmqp($sql1,$linktofile."?ID=$ID&serialmode=$serialmode","ไม่พบข้อมูล::l::No result found",24);
} else {
   $result = tmq($sql1,false);
}
	
									


while($row = tmq_fetch_array($result)) {
	$sets=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and calln='$row[calln]' ");
	$thisnum=tmq_num_rows($sets);
	$setstp=tmq_fetch_array($sets);
	$thiscalln=trim(serial_get_volstr($setstp[id]));
	if ($thiscalln=="") {
		$thiscalln="<I>no call number</I>";
	}
   if ($setstp[jchrono_1]!=0||$setstp[jchrono_2]!=0||$setstp[jchrono_3]!=0) {
      $thiscalln.=" ($setstp[jchrono_1]-$setstp[jchrono_2]-$setstp[jchrono_3])";
   }
	?><div style="display: block; border: 1px solid #633F3D; width: <?php  echo $tdwidth;?>; height:130; margin: 2 2 2 2; float: left; padding: 2 2 2 2; overflow:hidden">
	<?php 
	
	$stat=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and calln='$row[calln]' and bcode<>'' ");
	$statbound=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and bcode<>'' and calln='$row[calln]' and (jpublicnote like '%bound%')");
	if (tmq_num_rows($statbound)!=0) {
		$dsped=true;
		$skiplastlink=true;
		echo "<div style=\"display: block: height:20; width: 100%; background-color:#FFBBBB;text-align: center;\">BOUND</div>";
		//$numitems=tmq_num_rows($stat);
		//echo "<A HREF='itemlist.php?MID=$MID&jenum_1=$row[jenum_1]&jenum_2=$row[jenum_2]&jenum_3=$row[jenum_3]&jenum_4=$row[jenum_4]&jenum_5=$row[jenum_5]&jenum_6=$row[jenum_6]&calln=".urlencode($row[calln])."' class=smaller2 rel='gb_page_fs[]' >items = ".number_format($numitems)."</A>";
	} elseif (tmq_num_rows($stat)!=0) {
		echo "<div style=\"display: block: height:20; width: 100%; background-color:#CFECCE;text-align: center;\">ARRIVED</div>";
		$numitems=tmq_num_rows($stat);
		//$numitems=tmq_num_rows($stat);
		if (floor($numitems)>1){
   		//echo "<A HREF='itemlist.php?MID=$MID&jenum_1=$row[jenum_1]&jenum_2=$row[jenum_2]&jenum_3=$row[jenum_3]&jenum_4=$row[jenum_4]&jenum_5=$row[jenum_5]&jenum_6=$row[jenum_6]&calln=".urlencode($row[calln])."' class=smaller2 rel='gb_page_fs[]' >items = ".number_format($numitems)."</A><BR>";
   		echo "<font class=smaller>items = ".number_format($numitems)."</font><BR>";
      }
 
	} else {
		$stat=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and bcode='' and calln='$row[calln]' and jnonpublicnote like '%expected%' ");
		if (tmq_num_rows($stat)!=0) {
			$dsped=true;
			echo "<div style=\"display: block: height:20; width: 100%; background-color:#EECCCC;text-align: center;\">EXPECTED</div>";
		}
		$stat=tmq("select * from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and bcode='' and calln='$row[calln]' and (jnonpublicnote like '%late%' or jnonpublicnote like '%wait%'  or jnonpublicnote like '%pend%' )");
		if (tmq_num_rows($stat)!=0) {
			$dsped=true;
			echo "<div style=\"display: block: height:20; width: 100%; background-color:#E6CDED;text-align: center;\">LATE</div>";
		}
		if ($dsped!=true) {
			echo "<div style=\"display: block: height:20; width: 100%; background-color:#DCDEDC;text-align: center;\">-</div>";
		}
	}
	?><FONT class=smaller2><?php  echo $thiscalln; ?></FONT><?php 
		$sets=tmq("select distinct place from media_mid where pid='$MID' and jenum_1='$row[jenum_1]' and jenum_2='$row[jenum_2]' and jenum_3='$row[jenum_3]' and jenum_4='$row[jenum_4]' and jenum_5='$row[jenum_5]' and jenum_6='$row[jenum_6]' and calln='$row[calln]' ");
	if (tmq_num_rows($sets)!=0) {
		echo "<FONT class=smaller2><BR><nobr><FONT class=smaller2 color=darkblue>".getlang("สถานที่::l::Shelves").":</FONT></nobr> ";
		while ($setsr=tmq_fetch_array($sets)) {
			echo get_itemplace_name($setsr[place],'&gt;');
		}
		echo "</FONT>";
	}
				//chk attatch
			$keyid="SERIAL-$MID-attatch-$row[jenum_1]-$row[jenum_2]-$row[jenum_3]-$row[jenum_4]-$row[jenum_5]-$row[jenum_6]-$row[calln]";
			$chka=tmq("select * from globalupload where keyid='$keyid' ",false);
			if (tnr($chka)>0) {
				echo "<BR><font class=smaller2><br>";
            if (tnr($chka)==1) {
   				?><img src="<?php  echo $dcrURL;?>neoimg/ulibfulltext.png" width="12" height="12" border="0"> <?php 
   				echo number_format(tnr($chka))." ".getlang("ไฟล์แนบ::l::Attatched files")."</a>";
               $chkar=tfa($chka);
               ?><a class=smaller2  href="<?php  echo $dcrUR; ?>_linkout.php?url=<?php  echo urlencode($dcrURL."_globalupload/$keyid/$chkar[hidename]");?>"
                target=_blank> <?php  echo mb_substr(stripslashes($chkar[filename]),0,20); ?></a><?php
            } else {
   				echo "<a class=smaller2 style='color:darkblue' href='$dcrURL"."library.serials/viewattatched.php?MID=$MID&bcode=$row[bcode]&keyid=$keyid' rel=\"gb_page_fs[]\">";
               ?><img src="<?php  echo $dcrURL;?>neoimg/ulibfulltext.png" width="12" height="12" border="0"> <?php 
   				echo number_format(tnr($chka))." ".getlang("ไฟล์แนบ::l::Attatched files")."</a>";
            }
			}
     //chain chk
      $chainchksql="select * from chainerlink where fromid='$MID' and ( 0  ";
      $allchaincode=",";
      while ($statr=tfa($stat)) {
         $chainchksql.="or frommid='$statr[id]' ";
         $allchaincode=$allchaincode.",".$statr[id];
      }
      $chainchksql.=")";
      $chainchk=tmq($chainchksql,false);
	  //echo tmq_num_rows($chain);
	  if (tmq_num_rows($chainchk)!=0) {
	  		echo "<BR><a class=smaller2 style='color:darkblue' href='$dcrURL"."library.serials/viewchainer.php?MID=$MID&allchaincode=$allchaincode' rel=\"gb_page_fs[]\">";
				?><img src="<?php  echo $dcrURL;?>neoimg/ulibfulltext.png" width="12" height="12" border="0" alt="" xalign=absmiddle> <?php 
				echo number_format(tnr($chainchk))." ".getlang("ดรรชนี::l::index(es)")."</a>";
	  }
	?></div><?php 
} // each row
 ?>
</div></TD>
</TR>
<?php echo $_pagesplit_btn_var;?>
</TABLE><?php 
	 
}
if ($serialmode=="list") {
?>
<blockquote> 
<?php  
  $sql2 ="SELECT *  FROM media_mid where pid=$ID and bcode<>'' "; 
//echo $sql2; 
	$sql2.=" order by 
   length(trim(jchrono_1)) desc,jchrono_1 desc,
   length(trim(jchrono_2)) desc,jchrono_2 desc,
     length(trim(jchrono_3)) desc,jchrono_3 desc,
     length(trim(jenum_1)) desc,jenum_1 desc,
     length(trim(jenum_2)) desc,jenum_2 desc,
     length(trim(jenum_3)) desc,jenum_3 desc,
     length(trim(jenum_4)) desc,jenum_4 desc,
     length(trim(jenum_5)) desc,jenum_5 desc,
     length(trim(jenum_6)) desc,jenum_6 desc ,
     length(trim(inumber)) ,inumber  
     ";
  $sql2 ="$sql2" ; 
//echo $sql1;


if ($linktofilefile[basename]=="dublinfull.php" || $linktofilefile[basename]=="dublin.php") {
	$r2 = tmqp($sql2,$linktofile."?ID=$ID&serialmode=$serialmode","ไม่พบข้อมูล::l::No result found",10);
} else {
   $r2 = tmq($sql2,false);
}
//$r2 = tmq($sql2);

echo "<table border=1 bordercolor=666666 cellpadding=0 width='$_TBWIDTH' align=center 
bgcolor=666666 cellspacing=1 class=table_border >
<Tr >
	<td width=5% class=table_head><nobr>".getlang("ลำดับที่::l::No.")."</B></td>
	<td align=center width=10% class=table_head><nobr>".getlang("ประเภท::l::Type")."</B></td>
 	<td align=center width=15% class=table_head><nobr>".getlang("เลขเรียก::l::CallNumber")."</B>/<nobr>".getlang("บาร์โค้ด::l::Barcode")."</B></td>
	<td align=center width=15% class=table_head><nobr>".getlang("สถานที่::l::Place")."</B></td>
  <td align=center width=15% class=table_head>".getlang("สถานะ::l::Status")."</B></td>
</tr>";
//echo $mMID;
$i2=1;
	//while (list(,$row2) = each($mMID)) {
while ($r = tmq_fetch_array($r2)) {
	$mMID=$r[bcode];

//intransit chk s
$isintransit=tmq("select * from itemtransit_sub where status='new' and bcode='$r[bcode]' ");
if (tnr($isintransit)!=0) {
	$r[status]="intransit";
}
//intransit chk e

////ishide also on html_displayserial() start
if (loginchk_lib("check")==false) {
	$rectype=tmq("select * from media_type where code='$r[RESOURCE_TYPE]'  ");
	$rectype=tmq_fetch_array($rectype);
	if ($rectype[ishide]=='yes') {
		continue;
	}
	$midstat=tmq("select * from media_mid_status where code='$r[status]'  ");
	$midstat=tmq_fetch_array($midstat);
	if ($midstat[ishide]=='yes') {
		continue;
	}
}

////ishide also on html_displayserial() end	  $mMID=$r[bcode];
//  echo "/ /$row2/ /";
if ($r[bcode]==$item) {
	$bg=" style='background-color:#FFE4CA' ";
	$star="**";
} else {
	$bg=" style='background-color:#FFFFFF'";
	$star="";
}


echo "<tr $bg><td class=table_td align=right>".($startrow+$i2).".</td>
	<td class=table_td  align=center><img border=0 width=48 height=48 src='";
	if ($r[status]=="reservmat") {
		$usecode="reservmat";
	} else {
		$usecode=$r[RESOURCE_TYPE];
	}
	if (file_exists("$dcrs/_tmp/mediatype/$usecode.png")==true) {
		echo "$dcrURL/_tmp/mediatype/$usecode.png";
	} else {
		echo "$dcrURL/_tmp/mediatype.png";
	}
	echo "' > <BR><FONT class=smaller2>".get_media_type($usecode)."</FONT>";
if ($r[status]!="") {
	echo " <BR> <FONT class=smaller2 COLOR='#002F5E'>".getlang("สถานะ::l::Status")."=".get_mid_status($r[status])."</FONT>";
}
//chk attatch
$keyid="SERIAL-$MID-attatch-$r[jenum_1]-$r[jenum_2]-$r[jenum_3]-$r[jenum_4]-$r[jenum_5]-$r[jenum_6]-$r[calln]";
$chka=tmq("select * from globalupload where keyid='$keyid' ",false);
echo "</td>";
$t02=marc_getserialcalln($r[id],"full","no");;
echo "<td  class=table_td align=left $bg> $t02$star <BR><FONT class=smaller2>&nbsp;&nbsp;Barcode: $r[bcode] </FONT>";
if (tnr($chka)>0) {

				echo "<font class=smaller2><br>";
            if (tnr($chka)==1) {
   				?><img src="<?php  echo $dcrURL;?>neoimg/ulibfulltext.png" width="12" height="12" border="0"> <?php 
   				echo number_format(tnr($chka))." ".getlang("ไฟล์แนบ::l::Attatched files")."</a>";
               $chkar=tfa($chka);
               ?><a class=smaller2  href="<?php  echo $dcrUR; ?>_linkout.php?url=<?php  echo urlencode($dcrURL."_globalupload/$keyid/$chkar[hidename]");?>"
                target=_blank> <?php  echo mb_substr(stripslashes($chkar[filename]),0,20); ?></a><?php
            } else {
   				echo "<a class=smaller2 style='color:darkblue' href='$dcrURL"."library.serials/viewattatched.php?MID=$MID&bcode=$row[bcode]&keyid=$keyid' rel=\"gb_page_fs[]\">";
               ?><img src="<?php  echo $dcrURL;?>neoimg/ulibfulltext.png" width="12" height="12" border="0"> <?php 
   				echo number_format(tnr($chka))." ".getlang("ไฟล์แนบ::l::Attatched files")."</a>";
            }
}

echo "</td>		";
echo "	<td class=table_td align=center $bg><a target=_top href='$dcrURL"."itemplaces.php?focuscalln=".urlencode($t02)."&focusshf=$r[place]' target=_blank class=smaller>";
echo get_itemplace_name($r[place],'<BR>&gt;');
echo "</a>";


echo "</td>";

$ecstat=bitem_get_checkoutstr($mMID);
 echo "<TD $bg class='table_td smaller' align=center>";
 echo $ecstat;
 html_displayrqitem($mMID,$r[place]);
	$hrs=getval("config","timetocirputtoshelf");

$hrs=getval("config","timetocirputtoshelf");
$hrsod=trim(getval("config","timeofdaytocirputtoshelf"),", ");

   if ("$hrs"=="-1") {
    $chkkn=tmq("select * from media_edittrace where edittype like 'add item bc=$r[bcode]' ");
    $chkknr=tfa($chkkn);
    if (date("Y-m-d",time())==date("Y-m-d",$chkknr[dt])) {
      $hrsword="รอจัดขึ้นชั้น::l::at Catalogue";
    } else {
      $hrsword="เพิ่งรับคืน ::l::At circulation";
    }
    if ($r[lastcheckin]>time()) {
      if (date("Y-m-d",time())==date("Y-m-d",$r[lastcheckin])) {
      	 echo "<br /><font color='#cc3333'  class=smaller><i>*";
      	 echo getlang("$hrsword");
      	 $hrsstr= date("H.i",$r[lastcheckin]);
      	 echo "</i>(".getlang("ขึ้นชั้น::l::, check shelf")."&#126;$hrsstr)</font>";
   	 } else {
          echo "<br /><font color='#cc3333' class=smaller><i>*";
      	 echo getlang("$hrsword");
      	 echo "</i></font>";
   	 }
    }
   	 //echo "<br /><font color='#cc3333'><i>*";
   	// echo getlang("รอจัดขึ้นชั้น::l::at Catalogue ");
   	 //$hrsstr= date("H.i",$r[lastcheckin]);
   	 //echo "</i></font>";    }
   } else {
      if (floor($r[lastcheckin]>time())) {
      //if (floor($r[lastcheckin]+(60*60*$hrs))>time()) {
      $chkkn=tmq("select * from media_edittrace where edittype like 'add item bc=$r[bcode]' ");
        $chkknr=tfa($chkkn);
        if (date("Y-m-d",time())==date("Y-m-d",$chkknr[dt])) {
       	 echo "<br /><font color='#cc3333' class=smaller><i>*";
       	 echo getlang("รอนำขึ้นชั้น::l::Catalogue");
       	 echo "</i></font>";
        } else {
       	 echo "<br /><font color='#cc3333' class=smaller><i>*";
       	 echo getlang("เพิ่งรับคืน::l::At circulation");
       	 echo "</i></font>";
        }
      }
  }
  //////////start is midstatus hide  also on html_displayserial() 
$midstat=tmq("select * from media_mid_status where code='$r[status]'  ");
$midstat=tmq_fetch_array($midstat);
if ($midstat[ishide]=='yes') { 
	echo "<BR><FONT class=smaller2>".getlang("รายการนี้ถูกซ่อนจากผู้ใช้::l::This item hidden from users")."</FONT>";
}
//////////end is midstatus hide  also on html_displayserial() 
 echo "</td>";
$i2 +=1;
echo "</tr>";

bitem_get_chaininfo($ID,$r[id]);

}
//echo "$i2";

if ($i2==1) {
  echo "<tr	><td colspan=7 align=center  class=table_td>- ".getlang("ไม่พบข้อมูล::l::No item found")." - </td></tr>";
}
 echo $_pagesplit_btn_var;

echo "</table>";
           ?>
</blockqoute>
 <?php 
}
}
?>