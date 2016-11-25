<?php 
include("../inc/config.inc.php");
html_start();
$tbname="keyhelp_cutter";
$az=explode(',',$_STR_A_Z);
sort($az);
//printr($az);
$recparentval=dspmarc($laststr);
$recparentval=urldecode($recparentval);
$recparentval=trim($recparentval);
$recparentval=strtolower($recparentval);
$recparentval=str_remspecialsign($recparentval);
$recparentval=str_replace(' ','',$recparentval);
if ($recparentval!="" && strlen($recparentval)>=3) {
	$recparentval2="";
	for ($i=0;$i<=strlen($recparentval);$i++) {
		if (in_array($recparentval[$i],$az)) {
			$recparentval2.=$recparentval[$i];
		}
	}
	$a3=mb_substr($recparentval2,0,3);
	$a2=mb_substr($recparentval2,0,2);
	$a1=mb_substr($recparentval2,0,1);
	$t=tmq("select * from $tbname where text like '$a3%' ",false);
	if (tnr($t)!=0) {
		//echo "[$recparentval2]";
		$class1=$recparentval2[0];
		$class2=$recparentval2[1];
		$class3=$recparentval2[2];
	} else {
		$t=tmq("select * from $tbname where text like '$a2%' ",false);
		if (tnr($t)!=0) {
			//echo "[$recparentval2]";
			$class1=$recparentval2[0];
			$class2=$recparentval2[1];
		} else {
			$t=tmq("select * from $tbname where text like '$a1%' ",false);
			if (tnr($t)!=0) {
				$class1=$recparentval2[0];
			}
		}
	}
}
?><TABLE cellpadding=0 cellspacing=0 class=table_border width=100%>
	<TR>
	<TD class=table_td>
	<?php 
		 while (list($ik,$i)=each($az)) {
		  	 echo " ";
		 		 $class1name=strtoupper($i)."";
				 
				 if ("$class1"=="$i") {
				 		echo "<b>";
				 }
		 		 echo "<a href='sanborncutter.php?parentjsid=$parentjsid&class1=$i'>";
		 		 echo $class1name;
				 echo "</a>";
			 		echo "</b>";
		 }
		?>
		<?php 	if ($class1!="") {
				$t=tmq("select * from $tbname where text like '$class1' ",false);
				if (tmq_num_rows($t)!=0) {
					$t=tmq_fetch_array($t);
					echo " <br />&nbsp;&nbsp;&nbsp;[ $t[text]=$r[num] ]";
				}
		?>
		 <a href='sanborncutter.php?parentjsid=<?php  echo $parentjsid?>&class1='> back </a>
		<?php  } ?>
	</TD>
</TR>
<?php 	if ($class1!="") {?>
	<TR>
	<TD class=table_td>
	<?php 
		reset($az);
		 $sub=tmq("select distinct substring(text,2,1) as aa from $tbname where text like '$class1%' ");
		 while ($subr=tmq_fetch_array($sub)) {
			 $i=$subr[aa];
		  	 echo " ";
		 		 $class2name="<FONT COLOR=aaaaaa>$class1</FONT>".strtoupper($i)."";
				 
				 if ("$class2"=="$i") {
				 		echo "<b>";
				 }
		 		 echo "<a href='sanborncutter.php?parentjsid=$parentjsid&class1=$class1&class2=$i'>";
		 		 echo $class2name;
				 echo "</a>";
		 		echo "</b>";
		 }
		 
		 if ($class2!="") {
				$t=tmq("select * from $tbname where text like '$class1$class2' ",false);
				if (tmq_num_rows($t)!=0) {
					$t=tmq_fetch_array($t);
					echo " <br />&nbsp;&nbsp;&nbsp;[ $t[text]=$t[num] ]";
				}
		} ?>

	</TD>
</TR>
<?php }?>

<?php 	if ($class2!="") {?>
	<TR>
	<TD class=table_td>
	<?php 

		 $sub=tmq("select distinct substring(text,3,1) as aa from $tbname where text like '$class1$class2%' ");
		 while ($subr=tmq_fetch_array($sub)) {
			 $i=$subr[aa];
		  	 echo " ";
		 		 $class3name="<FONT COLOR=aaaaaa>".$class1.$class2."</FONT>".strtoupper($i);
				 
				 if ("$class3"=="$i") {
				 		echo "<b>";
				 }
		 		 echo "<a href='sanborncutter.php?parentjsid=$parentjsid&class1=$class1&class2=$class2&class3=$i'>";
		 		 echo $class3name;
				 echo "</a>";
		 		echo "</b>";

		 }
		 
		 	if ($class3!="") {
				$t=tmq("select * from $tbname where text like '$class1$class2$class3' ",false);
				if (tmq_num_rows($t)!=0) {
					$t=tmq_fetch_array($t);
					echo " <br />&nbsp;&nbsp;&nbsp;[ $t[text]=$t[num] ]";
				}
		  }
		?>
	</TD>
</TR>
<?php }?>
</TABLE>
<?php 




//dsp
?><script language="javascript" type="text/javascript">
function copyText(theSel) {
if (!document.all) return; // IE only
theSel.select();
window.clipboardData.setData('Text',theSel.value);
}
</script> <?php 


function copier($wh) {
	global $parentjsid;
	$dspnum=substr($wh[text],0,2)."$wh[num]";
	$r= "<INPUT TYPE=text NAME='' value='$dspnum' ";
	/*
	if ($parentjsid!="") {
		$r.=" onclick=\"parent.getobj('$parentjsid').value=parent.getobj('$parentjsid').value+'$dspnum'; parent.showhidesuggestme_justhide(); return true;\" ";
	}*/
	$r.=" style='cursor: hand; cursor: pointer;; width: 80; text-align:center' 
	noonclick=\"copyText(this)\" onclick=\"this.select()\" onmouseup=\"this.select()\">";
	return $r;
}
function localclicker($wh) {
	$dspnum=substr($wh[text],0,2)."$wh[num]";

	return "
	<B onclick=\"localfillthis_dc('$dspnum');\" ><img src=\"../neoimg/uptod.png\" border=0 width=18 height=18></B><B onclick=\"localfillthis_lc('$dspnum');\" ><img src=\"../neoimg/uptol.png\" border=0 width=18 height=18><B onclick=\"localfillthis_nlm('$dspnum');\" ><img src=\"../neoimg/upton.png\" border=0 width=18 height=18></B><B onclick=\"localfillthis_localc('$dspnum');\" ><img src=\"../neoimg/upto9.png\" border=0 width=18 height=18></B>
	$wh[text]</a>";
}
$dsp[2][text]="Number";
$dsp[2][field]="num";
$dsp[2][align]="center";
$dsp[2][width]="10%";
$dsp[2][filter]="module:copier";

$dsp[3][text]="ตัวอักษรของชื่อ::l::Author Name";
$dsp[3][field]="text";
$dsp[3][width]="80%";
$dsp[3][filter]="module:localclicker";


	$limit=" 1 and text like '$class1$class2$class3%' ";

$o[tablewidth]="100%";

fixform_tablelister($tbname," $limit  ",$dsp,"no","no","no","parentjsid=$parentjsid&class1=$class1&class2=$class2&class3=$class3",$c," num",$o);
?><SCRIPT LANGUAGE="JavaScript">
<!--
function localfillthis_dc(wh) {
	parent.addtodcnum(wh);
}
function localfillthis_lc(wh) {
	parent.addtolcnum(wh);
}
function localfillthis_localc(wh) {
	parent.addtolocalcnum(wh);
}
function localfillthis_nlm(wh) {
	parent.addtonlmnum(wh);
}
//-->
</SCRIPT>