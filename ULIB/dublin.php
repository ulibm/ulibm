<?php 
include("inc/config.inc.php");
pcache_s("autourl",0,0,false,"bibdsp");
$html_start_title=marc_gettitle($ID);

head();
addons_module("bibdisplay_bodybegin");
mn_web("dspbib");

    $dspv="MTITLE=$MTITLE&MAUTHOR=$MAUTHOR&MDESCRIPTION=$MDESCRIPTION&MSUBJECT=$MSUBJECT&MRETYPE=$MRETYPE&MCALLNUM=$MCALLNUM&MFACULTY=$MFACULTY&page=$page";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
window.moveTo(0,0);
window.resizeTo(screen.availWidth,screen.availHeight);
//-->
</SCRIPT>
<div align="center">
  <?php 
$sql = "select * from media where ID='$ID' ";
$result = tmq($sql);
$Num = tmq_num_rows($result);
if($Num == 0) {
     html_dialog("",getlang("ไม่สามารถหาวัสดุสารสนเทศ ID นี้ได้ ::l::Bibliography record not found ")."($ID)");
	exit;
} else {

     	?><BR>
<table bgcolor=white width="<?php  echo $_TBWIDTH;?>" border=0 align=center cellpadding=1
cellspacing=0 >
<tr><td><a href='dublinfull.php?f=all&ID=<?php  echo $ID;?>&item=<?php  echo $item;?>'><B>Marc Display</B></a> 
<?php  if (barcodeval_get("webpage-o-viewbib_emailtome")=="yes") {?>
 : <A href='javascript:void(null)' onclick="return GB_showCenter('Send E-mail', '<?php echo $dcrURL?>dublin.emailme.php?id=<?php  echo $ID?>')" style='color:#173960'><B>E-mail record</B></a>
<?php  }?>
 : <A href='<?php echo $dcrURL?>_qrgenner.php?url=<?php  echo urlencode($dcrURL."dublin.php?ID=$ID");?>' rel="gb_page_fs[]" style='color:#173960'><img src="<?php echo $dcrURL?>neoimg/qrico.png" width=16 align=baseline border=0> <B>QR code</B></a>

</td>
                    <td width=50><a href="javascript:<?php 
	if (barcodeval_get("webpage-o-upacnopopup")=="yes") {
		echo " history.go(-1); ";
	} else {
		echo " window.close(); ";
	}		?>"><nobr><IMG SRC="neoimg/closewin.jpg" WIDTH="26" HEIGHT="26" BORDER="0" ALT="" align=absmiddle> <B>
	<?php 
	if (barcodeval_get("webpage-o-upacnopopup")=="yes") {
		echo getlang("กลับ::l::Back"); 
	} else {
		echo getlang("ปิดหน้าต่าง::l::Close window"); 
	}		?></B></td>
</tr></table>
 <?php 
	//
	include("dublin.showcasereview.php");
	//
   
quickeditwebtext("bib-beforebib","$_TBWIDTH");
include("dublin.bibcollections.php");
echo html_displaymedia($ID);
///die;
quickeditwebtext("bib-afterbib","$_TBWIDTH");
 include("./dublin.bibacc.php");
quickeditwebtext("bib-afterbibacc","$_TBWIDTH");

   if ($_ISULIBHAVESTER!="yes") {
   	if (barcodeval_get("webpage-o-upachideitem")=="yes") {
   	} else {
   		$module=get_itemmodule($ID);
   		if ($module=="item") {
   			html_displayitem($ID,$item);
   		} elseif ($module=="serial") {
   			html_displayserial($ID,$item,$serialmode);
   		} else {
   			echo "ผิดพลาด ไม่สามารถหาโมดูลสำหรับ $module";
   		}
   		quickeditwebtext("bib-afteritem","$_TBWIDTH");
   	}
   } else {
   	$tags=tmq_fetch_array($result);
   	include("$dcrs/_havester/sv/clientbibdetail.php");	
   }

}

if (barcodeval_get("display_dublinrelatebib")=="yes") {
	quickeditwebtext("bib-befor_relatebib","$_TBWIDTH");
	include("dublin.relatebib.php");
}

if (barcodeval_get("bookcomment_isenable") == "yes") {
	quickeditwebtext("bib-befor_bookcomment","$_TBWIDTH");
	 include("./member/inc.bookcomment.php");
};

if (getval("_SETTING","display_biblabelatupac")=="yes") {
	 ?><table width="<?php  echo $_TBWIDTH?>" align=center>
	<tr><td><?php html_label('b',$ID,"yes");?></td></tr>
	</table><?php 
}

if (barcodeval_get("webpage-o-viewbib_showsocialacc") == "yes") {
	quickeditwebtext("bib-befor_socialacc","$_TBWIDTH");
	 include("./socialinternet/dublin.inc.socialinternetacc.php");
};

quickeditwebtext("bib-foot","$_TBWIDTH");

foot();
pcache_e();
?>