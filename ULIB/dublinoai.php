<?php 
include("inc/config.inc.php");
$ID=$mid;
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
$sql = "select * from index_db where id='".addslashes(urldecode($ID))."' ";
$result = tmq($sql);
$Num = tmq_num_rows($result);
if($Num == 0) {
	echo"<font s>ไม่สามารถหาวัสดุสารสนเทศ ID นี้ได้  ($ID)</font>";
	exit;
} else {


		$oainamemap=barcodeval_get("oaiman_namemap");
		$oainamemap=explodenewline($oainamemap);
		@reset($oainamemap);
		$oainamemapdb=Array();
		while (list($mk,$mv)=each($oainamemap)) {
			$mv=explode('=',$mv);
			$oainamemapdb[$mv[0]]=getlang($mv[1]);
		}
		//printr($oainamemapdb);


			function makeClickableLinks2($text)
{

        $text = html_entity_decode($text);
        $text = " ".$text;
        $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1" target=_blank>\\1</a>', $text);
        $text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1" target=_blank>\\1</a>', $text);
        $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
        '\\1<a href="http://\\2" target=_blank>\\2</a>', $text);
        $text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
        '<a href="mailto:\\1" target=_blank>\\1</a>', $text);
        return $text;
}
     	?><BR>
<table bgcolor=white width="<?php  echo $_TBWIDTH;?>" border=0 align=center cellpadding=1
cellspacing=0 >
<tr><td>
  <A href='<?php echo $dcrURL?>_qrgenner.php?url=<?php  echo urlencode($dcrURL."dublinoai.php?mid=$mid");?>' rel="gb_page_fs[]" style='color:#173960'><img src="<?php echo $dcrURL?>neoimg/qrico.png" width=16 align=baseline border=0> <B>QR code</B></a>

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
	//include("dublin.showcasereview.php");
	//
quickeditwebtext("bib-beforebib","$_TBWIDTH");
$result=tfa($result);

$oaidata=tmq("select * from oai_repo_i where code='".substr($result[remoteindex],4)."' and identifier='$result[remoteindex_ref]'  ",false);
$oaidata=tfa($oaidata);

$str=stripslashes($oaidata[data]);
//echo $str; die;
	$str=str_replace("<![CDATA[","",$str);
	$str=str_replace("]]>","",$str);

	$str=explode("<metadata>",$str);
	$str=$str[1];
	$str=explode("</metadata>",$str);
	$str=$str[0];
	//echo $str;
	$a=explode("<dc:",$str);
	@reset($a);
	//skip first
	list($k,$v)=each($a);
	?><table bgcolor=darkgray width='<?php  echo $_TBWIDTH;?>' border=1 align=center cellpadding=1 
cellspacing=1 bordercolor=#f5f5f5  class=table_border><?php 
		?><tr bgcolor=#f3f3f3 valign=top><td width = 20% valign = top  class=table_head style='text-align:left;'>&nbsp;<nobr> Identifier
		</nobr></td>
<td width =70%  class=table_td>
<?php  echo $ID;?>
</td></tr><?php 
		while (list($k,$v)=each($a)) {
		$val=explode("</dc:",$v);
		$val=$val[0];
		$val=explode(">",$v);
		//printr($val);
		$dckey=trim($val[0]);
		$dckey=ltrim($dckey);
		$dckey=explode(" ",$dckey);
		//echo $dckey[1];
		$dckey=$dckey[0];
		$dcval=trim($val[1]);
		$dcval=explode("</dc:",$dcval);
		$dcval=$dcval[0];
		$dcval=($dcval);
		if (trim($dcval)!="" && ($dcval)=="") {
			//$dcval=iconvutf($dcval);
		} else { //if have no problem with thai compat
			$dcval=($dcval);
		}
		//echo "$dckey=$dcval;<br>\n";
		?><tr bgcolor=#f3f3f3 valign=top><td width = 20% valign = top  class=table_head style='text-align:left;'>&nbsp;<nobr TITLE="<?php  echo $dckey;?>" >
		<?php  
		$dspkey=$oainamemapdb[$dckey];	
		if ($dspkey=="") {
			$dspkey=ucfirst($dckey);
		}
		echo $dspkey;?>
		</nobr></td>
<td width =70%  class=table_td >
<font charset="UTF-8" ><?php  

		echo (makeClickableLinks2($dcval));
		//echo $dcval;
		
	?></font>
</td></tr><?php 
	}
	?></table><?php 

//printr($result);
$o=tmq("select * from oai_repo where code='$oaidata[code]' ");
$o=tfa($o);
$i=$o[uidentify];
//printr($o);
$aa = unserialize($i);
//printr($aa);
html_dialog("Repository Information","

repositoryName: <b>".$aa[Identify][repositoryName]."</b><br>
baseURL: ".$aa[Identify][baseURL]."<br>
adminEmail: ".$aa[Identify][adminEmail]."<br>
<a href='".$aa[Identify][baseURL]."?verb=GetRecord&metadataPrefix=oai_dc&identifier=$oaidata[identifier]' target=_blank>source</a>
");

//printr($result); die;
///die;
quickeditwebtext("bib-afterbib","$_TBWIDTH");
// include("./dublin.bibacc.php");
//quickeditwebtext("bib-afterbibacc","$_TBWIDTH");


}






if (barcodeval_get("webpage-o-viewbib_showsocialacc") == "yes") {
	quickeditwebtext("bib-befor_socialacc","$_TBWIDTH");
	 include("./socialinternet/dublin.inc.socialinternetacc.php");
};

quickeditwebtext("bib-foot","$_TBWIDTH");

foot();
pcache_e();
?>