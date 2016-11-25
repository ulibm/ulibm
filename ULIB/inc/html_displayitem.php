<?php 
function html_displayitem($ID,$item = "") {
	global $thaimonstr;
	global $loginadmin;
	global $_pagesplit_btn_var;
	global $dcrs;
	global $PHP_SELF;
	global $dcrURL;
	global $_TBWIDTH;
		//pagesection(getlang("รายการสื่อสารสนเทศ::l::Items"));
?>

<?php  
  $sql2 ="SELECT *  FROM media_mid where pid=$ID order by length(sortcalln),sortcalln,length(inumber),inumber,id"; 
//echo $sql2; 
$linktofile=$PHP_SELF;
$linktofilefile=pathinfo($linktofile);

if ($linktofilefile[basename]=="dublinfull.php" || $linktofilefile[basename]=="dublin.php") {

	$r2 = tmqp($sql2,$linktofile."?ID=$ID&item=$item","ไม่พบข้อมูล::l::No result found",12);
} else {
   $r2 = tmq($sql2,false);
}
//$r2 = tmq($sql2);
if (tnr($r2)==0) {
	$tags=tmq("select * from media where id='$ID' ",false);
	$tags=tmq_fetch_array($tags);
	$marctype=$tags[leader];
	$marctype=substr($marctype,7,1);
	$tmpstr=trim(get_noitemstr($marctype,"strforlist"));
	if ($tmpstr!="") {
      html_dialog(getlang("ไม่มีไอเทมให้บริการ::l::No item available"),$tmpstr);
      return;
   }
   
}
echo "<table border=1 bordercolor=666666 cellpadding=0 width='".($_TBWIDTH-10)."' align=center bgcolor=666666 cellspacing=1  class=table_border>
<Tr >
	<td width=5% class=table_head><B><nobr>".getlang("ลำดับที่::l::No.")."</B></td>
	<td align=center width=10% class=table_head><B><nobr>".getlang("ประเภท::l::Type")."</B></td>
 	<td align=center width=40% class=table_head colspan=2><B><nobr>".getlang("เลขเรียก::l::CallNumber")."</B>";
 	if (loginchk_lib("check")==true || strtolower(getval("_SETTING","webhidemediabarcode"))!="yes") {
 	    echo "/<B><nobr>".getlang("บาร์โค้ด::l::Barcode")."</B>";
 	}
 	echo "</td>
	<td align=center class=table_head><B><nobr>".getlang("สถานที่::l::Shelf")."</B></td>
  <td align=center class=table_head><B>".getlang("สถานะ::l::Status")."</B></td>
</tr>";

$i2=1;
  while ($r = tmq_fetch_array($r2)) {
	  $mMID=$r[bcode];
//  echo "/ /$row2/ /";
if ($r[bcode]==$item) {
	$bg=" style='background-color:#FFE6E7; background-image:url(".$dcrURL."neoimg/blinkbg.gif);' ";
	$star="**";
} else {
	$bg=" style='background-color:white;' ";
	$star="";
}
//intransit chk s
$isintransit=tmq("select * from itemtransit_sub where status='new' and bcode='$r[bcode]' ");
if (tnr($isintransit)!=0) {
	$r[status]="intransit";
}
//intransit chk e

////ishide also on html_displayserial() start
	$rectype=tmq("select * from media_type where code='$r[RESOURCE_TYPE]'  ",false);
	$rectype=tmq_fetch_array($rectype);

if (loginchk_lib("check")==false) {
	if ($rectype[ishide]=='yes') {
		continue;
	}
	$midstat=tmq("select * from media_mid_status where code='$r[status]'  ");
	$midstat=tmq_fetch_array($midstat);
	if ($midstat[ishide]=='yes') {
		continue;
	}
}
////ishide also on html_displayserial() end
//printr($rectype); //die;
	$mdtypesetstatusdsp=$rectype[setstatusdsp];

 echo "<tr >
  <td $bg class=table_td align=right><FONT class=smaller2>$i2.</FONT></td>
	<td $bg class=table_td align=center><img border=0 width=48 height=48 src='";
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
	echo "' alt='".getlang($rectype[name])."'><BR><FONT class=smaller2>".get_media_type($usecode)."</FONT>";
if ($r[status]!="") {
	echo " <BR> <FONT class=smaller2 COLOR='#002F5E'>".getlang("สถานะ::l::Status")."=".get_mid_status($r[status])."</FONT>";
}
  echo " </td>";

$t02=marc_getmidcalln($r[bcode]);
///$t02=marc_getcalln($ID);

$forceshowyearfixwinitemstr="";
if (strtolower(getval("_SETTING","forceshowyearfixwinitem"))=="yes") {
   //echo $tags[tag008];
   $chkyearalreadyexists=trim($t02," ().-+:");
   $chkyearalreadyexists=substr($chkyearalreadyexists,-4);
	$tags=tmq("select * from media where id='$ID' ",false);
	$tags=tmq_fetch_array($tags);
	$dspy=$tags[tag008];
	$dspy=substr($dspy,7,4);
	if (floor($dspy)!=0 && $dspy!=$chkyearalreadyexists) {
      $forceshowyearfixwinitemstr= " ".$dspy." ";
   }
}

$inumber=$r[inumber];
/*
if (trim($inumber)=="ฉ.1") {
	$inumber="";
}
*/
if (trim($inumber)=="ฉ.") {
	$inumber="";
}
if (trim($inumber)=="") {
	$inumber="";
}
echo "<td nowidth=1% nowidth=2 $bg  class=table_td  align=left colspan=2>$t02 $forceshowyearfixwinitemstr $inumber&nbsp;$star <BR>";
//echo "<!--	<td $bg class=table_td>$r[tabean] </td>-->";
echo "	<FONT class=smaller2>&nbsp;&nbsp;";
if (loginchk_lib("check")==true || strtolower(getval("_SETTING","webhidemediabarcode"))!="yes") {
		echo "Barcode: $r[bcode]";
} 
	echo "</FONT> </td>		";
echo "	<td $bg class=table_td  align=center><a target=_top href='$dcrURL"."itemplaces.php?focuscalln=".urlencode($t02)."&focusshf=$r[place]'  class=smaller>";
echo get_itemplace_name($r[place],'<BR>&#9658;');
echo "</a> </td>";

$ecstat=bitem_get_checkoutstr($mMID);

$mdtypesetstatusdsp=trim($mdtypesetstatusdsp);
if ($mdtypesetstatusdsp!="") {
   $ecstat=getlang($mdtypesetstatusdsp);
}
 echo "<TD $bg class=table_td  align=center>";
 

 	

	$hrs=getval("config","timetocirputtoshelf");
//////////start is midstatus hide  also on html_displayserial() 
$midstat=tmq("select * from media_mid_status where code='$r[status]'  ");
$midstat=tmq_fetch_array($midstat);
if ($midstat[ishide]=='yes') {
	echo "<BR><FONT class=smaller2>".getlang("รายการนี้ถูกซ่อนจากผู้ใช้::l::This item hidden from users")."</FONT>";
}
//////////end is midstatus hide  also on html_displayserial() 
if (trim($midstat[setstatusdsp])!="") {
   echo "<BR>".getlang($midstat[setstatusdsp]);
} else {
echo $ecstat;
html_displayrqitem($mMID,$r[place]);
   if ("$hrs"=="-1") {
    $chkkn=tmq("select * from media_edittrace where edittype like 'add item bc=$r[bcode]' ");
    $chkknr=tfa($chkkn);
    if (date("Y-m-d",time())==date("Y-m-d",$chkknr[dt])) {
      $hrsword="รอจัดขึ้นชั้น::l::at Catalogue";
    } else {
      $hrsword="เพิ่งรับคืน::l::At circulation";
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
}
 echo "</td>";
$i2 +=1;
///////////admin ที่จะลบ
//////////////////////////////////////////////ขอยืมรายการ
///////////////////////////////////////////////จบขอยืม
echo "</tr>";

bitem_get_chaininfo($ID,$r[id]);


if (trim($r[note])!="") {
	echo "<tr bgcolor=white  class=table_td><td></td><td colspan=6 class=smaller style=\"padding: 3px;border-width: 1px; border-style: solid; border-color: aaaaaa\"><B class=smaller>Note:</B>$r[note]";
	echo "</td></tr>";
}

}
//echo "$i2";

if ($i2==1) {
  echo "<tr	bgcolor=white><td colspan=7 align=center  class=table_td>- ".getlang("ไม่พบข้อมูล::l::No item found")."  - </td></tr>";
}
echo $_pagesplit_btn_var;
echo "</table>";
           ?>
<br>

 <?php 
}
?>