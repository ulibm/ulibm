<?php 
      include("inc/config.inc.php");
echo $kw;

if ($quicksearchlen==0) {
	$quicksearchlen=10;
}
if ($quicksearchmode=='') {
	$quicksearchmode="normalquicksearch";
}
if ($quicksearchaddword=='') {
	$quicksearchaddword="yes";
}
if ($quicksearchaddtaglist=='') {
	$quicksearchaddtaglist="yes";
}

if ($quicksearchmode=="normalquicksearch") {
	$s=tmq("select *,head as usingword from statordr_search_text where head like '%$kw%' or head='$kw' order by cc  desc limit 50  ",true);
} elseif ($quicksearchmode=="addbibtag") {
	$s=tmq("select *,word1  as usingword from webpage_bibtag where word1 like '%$kw%' or word1='$kw' order by word1  desc limit 100  ",false);
}

$sw=tmq("select * from indexword where word1 like '$kw%' order by word1  asc limit 10  ",false);
$swt=tmq("select * from webpage_bibtag where word1 like '$kw%' order by word1  asc limit 10  ",false);

$kw=urldecode($kw);
$kw=stripslashes($kw);
$kw=stripslashes($kw);
$kw=stripslashes($kw);
$kw=addslashes($kw);
$quicksearchlen=floor($quicksearchlen);
?><SCRIPT LANGUAGE="JavaScript">
<!--
quicksearchmode="<?php echo $quicksearchmode;?>"
function getPosLeft(obj) {
  var curleft = 0;
  if(obj.offsetParent)
  while(1) {
    curleft += obj.offsetLeft;
    if(!obj.offsetParent)
    break;
    obj = obj.offsetParent;
    }
  else if(obj.x)
  curleft += obj.x;
  return curleft;
}

function getPosTop(obj) {
  var curtop = 0;
  if(obj.offsetParent)
  while(1) {
    curtop += obj.offsetTop;
    if(!obj.offsetParent)
    break;
    obj = obj.offsetParent;
    }
  else if(obj.y)
  curtop += obj.y;
  return curtop;
}
	textbox=parent.getobj("INTERNALTEXTBOXKWSEARCH");
	tmp=parent.getobj("INTERNALTEXTBOXKWSEARCHdsp");
	tmp.style.top=(textbox.offsetHeight+getPosTop(textbox))+"px";
	tmp.style.left=getPosLeft(textbox)+"px";
	tmp.style.width=textbox.offsetWidth+"px";
	//alert(getPosTop(textbox));
	<?php 
	if (tmq_num_rows($s)==0 && tmq_num_rows($sw)==0 && tmq_num_rows($swt)==0 ) {
	?>
	tmp.style.display="none";
	<?php 
	} else {
		?>
		tmp.style.display="block";
		tmpstr="<TABLE width=100%  cellpadding=2 cellspacing=0 border=0>";
		<?php 
			$i=0;
		$iforjs=0; //id for ID='SUGGESTEDSUB$i'
		while ($r=tmq_fetch_array($s)) {
			if(!isUTF8($kw) && isUTF8($r[usingword])) {
				continue;
			}
			$i++;
			$iforjs++;
			if ($i>=$quicksearchlen) {
				break;
			}
			$html=$r[usingword];
			$html=str_replace("$kw","<B class=smaller2 style='color: darkblue;'>$kw</B>",$html);
		?>
		tmpstr+="<TR style='cursor: hand; cursor: pointer;'><TD style=' cursor: hand; cursor: pointer; '";
		tmpstr+=" onmouseover=\"this.style.backgroundColor='#FEFFCE'\" ";
		tmpstr+=" onmouseout=\"this.style.backgroundColor=''\" ";
		tmpstr+="><nobr><a href='javascript:void(null)' ID='SUGGESTEDSUB<?php  echo $iforjs?>'";
		tmpstr+=" onclick=\"local_fillword('<?php echo $r[usingword]?>');\" ";
		tmpstr+=" class=smaller2  style='width: 100%; overflow: clip; '><?php  echo $html?></a></nobr></TD></TR>";
		<?php 
		}
		if ($quicksearchaddtaglist=="yes" && tmq_num_rows($swt)!=0) {
			?>
			tmpstr+="<TR style='cursor: hand; cursor: pointer;'><TD ><B class=smaller2><?php  echo getlang("แท็ก::l::Tag");?>: </B>";
			<?php 
			while ($r=tmq_fetch_array($swt)) {
				$iforjs++;
				?>
				tmpstr+="<a href='javascript:void(null)' ID='SUGGESTEDSUB<?php  echo $iforjs?>'";
				tmpstr+=" onclick=\"local_fillword2('<?php echo $r[word1]?>'); return false\" ";
				tmpstr+=" class=smaller2 ><?php  echo $r[word1]?> </a>";
				<?php 
			}
			?>
			tmpstr+="</TD></TR>";
			<?php 
		}
			if ($quicksearchaddword=="yes" && tmq_num_rows($sw)!=0) {
			?>
			tmpstr+="<TR style='cursor: hand; cursor: pointer;'><TD ><B class=smaller2><?php  echo getlang("คำ::l::Word");?>: </B>";
			<?php 
			while ($r=tmq_fetch_array($sw)) {
				$iforjs++;
				?>
				tmpstr+="<a href='javascript:void(null)' ID='SUGGESTEDSUB<?php  echo $iforjs?>'";
				tmpstr+=" onclick=\"local_fillword2('<?php echo $r[word1]?>'); return false\" ";
				tmpstr+=" class=smaller2 ><?php  echo  $r[word1]?> </a>";
				<?php 
			}
			?>
			tmpstr+="</TD></TR>";
			<?php 
		}

		?>
			tmpstr+="<TR style='cursor: hand; cursor: pointer;'><TD align=right onclick=\"getobj('INTERNALTEXTBOXKWSEARCHdsp').style.display='none';\" class=smaller2>"+"Close";
			tmpstr+="</TD></TR>";
		tmpstr+="</TABLE>";

		tmp.innerHTML=tmpstr;
		<?php 
	}	
	?>


//-->
</SCRIPT>
